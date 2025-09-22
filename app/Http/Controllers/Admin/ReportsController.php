<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Owner;
use App\Models\Product;
use App\Models\SoldProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Dompdf\Options;

class ReportsController extends Controller
{
    public function index()
    {
        // Check if user has permission to access reports
        $user = auth()->user();
        if (!$user || !$user->canAccessReports()) {
            abort(403, __('reports.access_denied'));
        }

        // Get real statistics for preview
        $stats = $this->getPreviewStats();

        // Also get the comprehensive report data for the default period (last 30 days)
        $dateRange = $this->getDateRange(new \Illuminate\Http\Request(['period' => 'last_30_days']));
        $comprehensiveData = $this->getComprehensiveData($dateRange);
        $comprehensiveDateRange = $dateRange;

        return view('admin.reports.index', compact('stats', 'comprehensiveData', 'comprehensiveDateRange'));
    }

    private function getPreviewStats()
    {
        // Last 30 days statistics
        $last30Days = Carbon::now()->subDays(30);

        // Warranty statistics
        $warrantyStats = SoldProduct::select(
                DB::raw('COUNT(*) as total_sold'),
                DB::raw('COUNT(CASE WHEN warranty_end_date > NOW() AND warranty_voided != 1 THEN 1 END) as under_warranty'),
                DB::raw('COUNT(CASE WHEN warranty_end_date <= NOW() OR warranty_voided = 1 THEN 1 END) as expired')
            )->first();

        return [
            'comprehensive' => [
                'revenue' => SoldProduct::where('sale_date', '>=', $last30Days)->sum('purchase_price'),
                'sales' => SoldProduct::where('sale_date', '>=', $last30Days)->count(),
            ],
            'owners' => [
                'total_owners' => Owner::count(),
                'countries' => Owner::whereNotNull('country')->distinct('country')->count(),
            ],
            'sales' => [
                'products_sold' => SoldProduct::where('sale_date', '>=', $last30Days)->count(),
                'avg_sale' => SoldProduct::where('sale_date', '>=', $last30Days)->avg('purchase_price') ?? 0,
            ],
            'warranty' => [
                'under_warranty' => $warrantyStats->under_warranty ?? 0,
                'expired' => $warrantyStats->expired ?? 0,
                'total_sold' => $warrantyStats->total_sold ?? 0,
            ],
        ];
    }

    public function downloadComprehensiveReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }

        // Force English locale for PDF reports
        app()->setLocale('en');

        $dateRange = $this->getDateRange($request);
        $data = $this->getComprehensiveData($dateRange);

        // Generate PDF using dompdf directly
        $html = view('admin.reports.comprehensive', compact('data', 'dateRange'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'comprehensive-business-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function downloadOwnersReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }

        // Force English locale for PDF reports
        app()->setLocale('en');

        $dateRange = $this->getDateRange($request);
        $data = $this->getOwnersData($dateRange);

        // Generate PDF using dompdf directly
        $html = view('admin.reports.owners', compact('data', 'dateRange'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'customer-owners-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function downloadSalesReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }

        // Force English locale for PDF reports
        app()->setLocale('en');

        $dateRange = $this->getDateRange($request);
        $data = $this->getSalesData($dateRange);

        // Generate PDF using dompdf directly
        $html = view('admin.reports.sales', compact('data', 'dateRange'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'sales-performance-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function getDateRange(Request $request)
    {
        $period = $request->get('period', 'last_30_days');

        switch ($period) {
            case 'last_7_days':
                return [
                    'start' => Carbon::now()->subDays(7),
                    'end' => Carbon::now(),
                    'label' => 'Last 7 Days'
                ];
            case 'last_30_days':
                return [
                    'start' => Carbon::now()->subDays(30),
                    'end' => Carbon::now(),
                    'label' => 'Last 30 Days'
                ];
            case 'last_90_days':
                return [
                    'start' => Carbon::now()->subDays(90),
                    'end' => Carbon::now(),
                    'label' => 'Last 90 Days'
                ];
            case 'this_year':
                return [
                    'start' => Carbon::now()->startOfYear(),
                    'end' => Carbon::now(),
                    'label' => 'This Year'
                ];
            case 'last_year':
                return [
                    'start' => Carbon::now()->subYear()->startOfYear(),
                    'end' => Carbon::now()->subYear()->endOfYear(),
                    'label' => 'Last Year'
                ];
            case 'custom':
                return [
                    'start' => Carbon::parse($request->get('start_date', Carbon::now()->subDays(30))),
                    'end' => Carbon::parse($request->get('end_date', Carbon::now())),
                    'label' => 'Custom Range'
                ];
            default:
                return [
                    'start' => Carbon::now()->subDays(30),
                    'end' => Carbon::now(),
                    'label' => 'Last 30 Days'
                ];
        }
    }

    private function getComprehensiveData($dateRange)
    {
        // Financial Overview - Based on your sold_products table
        $totalRevenue = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->sum('purchase_price'); // Using purchase_price as the main revenue metric

        $totalSales = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])->count();
        $averageSaleValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        // Calculate profit margin (assuming 30% margin for display purposes)
        $profitMargin = 30; // This can be adjusted based on actual business logic

        // Top Performing Products - Updated for your product structure
        $topProducts = SoldProduct::select('products.model_name', 'products.line', 'products.type',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'),
                DB::raw('AVG(sold_products.purchase_price) as avg_price'))
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('products.id', 'products.model_name', 'products.line', 'products.type')
            ->orderBy('total_revenue', 'desc')
            ->limit(10)
            ->get();

        // Monthly Trends - Updated for sale_date
        $monthlyTrends = SoldProduct::select(
                DB::raw('DATE_FORMAT(sale_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(purchase_price) as revenue'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Staff Performance - Updated for your user structure
        $staffPerformance = SoldProduct::select('users.name', 'users.role',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->join('users', 'sold_products.user_id', '=', 'users.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('users.id', 'users.name', 'users.role')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Product Categories Performance - Updated for your structure
        $categoryPerformance = SoldProduct::select('product_categories.name as category_name',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('product_categories.id', 'product_categories.name')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Regional Analysis - Updated for your owners structure
        $regionalData = Owner::select('city', 'country',
                DB::raw('COUNT(DISTINCT owners.id) as owner_count'),
                DB::raw('COUNT(sold_products.id) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as total_revenue'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereBetween('sold_products.sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('city', 'country')
            ->orderBy('total_revenue', 'desc')
            ->get();

        // Growth Metrics (comparing to previous period)
        $prevPeriodStart = $dateRange['start']->copy()->sub($dateRange['end']->diffInDays($dateRange['start']), 'days');
        $prevPeriodEnd = $dateRange['start']->copy()->subDay();

        $prevRevenue = SoldProduct::whereBetween('sale_date', [$prevPeriodStart, $prevPeriodEnd])->sum('purchase_price');
        $prevSales = SoldProduct::whereBetween('sale_date', [$prevPeriodStart, $prevPeriodEnd])->count();

        $revenueGrowth = $prevRevenue > 0 ? (($totalRevenue - $prevRevenue) / $prevRevenue) * 100 : 0;
        $salesGrowth = $prevSales > 0 ? (($totalSales - $prevSales) / $prevSales) * 100 : 0;

        // Additional metrics based on your actual data
        $totalProducts = Product::where('is_active', true)->count();
        $totalOwners = Owner::count();
        $activeStaff = User::where('role', 'employee')->count();
        $totalAdmins = User::where('role', 'admin')->count();

        // Contact messages metrics
        $contactMessages = DB::table('contact_messages')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->count();

        // Warranty analysis
        $warrantyAnalysis = SoldProduct::select(
                DB::raw('COUNT(*) as total_sold'),
                DB::raw('COUNT(CASE WHEN warranty_end_date > NOW() THEN 1 END) as under_warranty'),
                DB::raw('COUNT(CASE WHEN warranty_end_date <= NOW() THEN 1 END) as warranty_expired'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        return [
            'financial_overview' => [
                'total_revenue' => $totalRevenue,
                'total_sales' => $totalSales,
                'average_sale_value' => $averageSaleValue,
                'revenue_growth' => $revenueGrowth,
                'sales_growth' => $salesGrowth,
                'profit_margin' => $totalRevenue > 0 ? (($totalRevenue * 0.3) / $totalRevenue) * 100 : 0, // Assuming 30% margin
            ],
            'top_products' => $topProducts,
            'monthly_trends' => $monthlyTrends,
            'staff_performance' => $staffPerformance,
            'category_performance' => $categoryPerformance,
            'regional_data' => $regionalData,
            'totals' => [
                'total_owners' => $totalOwners,
                'total_products' => $totalProducts,
                'active_staff' => $activeStaff,
                'total_admins' => $totalAdmins,
                'contact_messages' => $contactMessages,
            ],
            'warranty_analysis' => $warrantyAnalysis,
        ];
    }

    private function getOwnersData($dateRange)
    {
        // Owner Demographics - Updated for your structure
        $ownersByCountry = Owner::select('country', DB::raw('COUNT(*) as count'))
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->get();

        $ownersByCity = Owner::select('city', 'country', DB::raw('COUNT(*) as count'))
            ->whereNotNull('city')
            ->groupBy('city', 'country')
            ->orderBy('count', 'desc')
            ->limit(20)
            ->get();

        // Owner Purchase Behavior - Updated for your sold_products structure
        $topBuyers = Owner::select('owners.*',
                DB::raw('COUNT(sold_products.id) as total_purchases'),
                DB::raw('SUM(sold_products.purchase_price) as total_spent'),
                DB::raw('AVG(sold_products.purchase_price) as avg_purchase'),
                DB::raw('MAX(sold_products.sale_date) as last_purchase_date'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereBetween('sold_products.sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('owners.id')
            ->orderBy('total_spent', 'desc')
            ->limit(20)
            ->get();

        // Recent Registrations
        $recentOwners = Owner::whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->orderBy('created_at', 'desc')
            ->get();

        // Owner Acquisition Trends
        $acquisitionTrends = Owner::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as new_owners'))
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Company analysis
        $companiesAnalysis = Owner::select('company',
                DB::raw('COUNT(*) as owner_count'),
                DB::raw('COUNT(sold_products.id) as total_purchases'),
                DB::raw('SUM(sold_products.purchase_price) as total_spent'))
            ->leftJoin('sold_products', 'owners.id', '=', 'sold_products.owner_id')
            ->whereNotNull('company')
            ->groupBy('company')
            ->orderBy('total_spent', 'desc')
            ->limit(15)
            ->get();

        // Language preferences
        $languagePreferences = Owner::select('preferred_language', DB::raw('COUNT(*) as count'))
            ->groupBy('preferred_language')
            ->get();

        return [
            'owners_by_country' => $ownersByCountry,
            'owners_by_city' => $ownersByCity,
            'top_buyers' => $topBuyers,
            'recent_owners' => $recentOwners,
            'acquisition_trends' => $acquisitionTrends,
            'companies_analysis' => $companiesAnalysis,
            'language_preferences' => $languagePreferences,
            'totals' => [
                'total_owners' => Owner::count(),
                'new_owners_period' => $recentOwners->count(),
                'owners_with_companies' => Owner::whereNotNull('company')->count(),
            ],
        ];
    }

    private function getSalesData($dateRange)
    {
        // Sales Summary - Updated for your structure
        $totalSales = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])->count();
        $totalRevenue = SoldProduct::whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])->sum('purchase_price');

        // Sales by Product - Updated for your product structure
        $salesByProduct = SoldProduct::select('products.model_name', 'products.line', 'products.type',
                'product_categories.name as category_name',
                DB::raw('COUNT(*) as quantity_sold'),
                DB::raw('SUM(sold_products.purchase_price) as revenue'),
                DB::raw('AVG(sold_products.purchase_price) as avg_price'))
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->join('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('products.id', 'products.model_name', 'products.line', 'products.type', 'product_categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Sales by Period - Updated for sale_date
        $dailySales = SoldProduct::select(
                DB::raw('DATE(sale_date) as date'),
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(purchase_price) as revenue'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Sales by Staff - Updated for your user structure
        $salesByStaff = SoldProduct::select('users.name', 'users.role',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(sold_products.purchase_price) as revenue'))
            ->join('users', 'sold_products.user_id', '=', 'users.id')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->groupBy('users.id', 'users.name', 'users.role')
            ->orderBy('revenue', 'desc')
            ->get();

        // Recent Sales - Updated with proper relationships
        $recentSales = SoldProduct::with(['product', 'owner', 'user'])
            ->join('products', 'sold_products.product_id', '=', 'products.id')
            ->join('owners', 'sold_products.owner_id', '=', 'owners.id')
            ->join('users', 'sold_products.user_id', '=', 'users.id')
            ->select('sold_products.*', 'products.model_name', 'owners.name as owner_name', 'users.name as user_name')
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->orderBy('sale_date', 'desc')
            ->limit(50)
            ->get();

        // Warranty Analysis
        $warrantyAnalysis = SoldProduct::select(
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('COUNT(CASE WHEN warranty_end_date > NOW() THEN 1 END) as active_warranties'),
                DB::raw('COUNT(CASE WHEN warranty_end_date <= NOW() THEN 1 END) as expired_warranties'),
                DB::raw('AVG(DATEDIFF(warranty_end_date, warranty_start_date)) as avg_warranty_days'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        // Serial Number Analysis
        $serialAnalysis = SoldProduct::select(
                DB::raw('COUNT(DISTINCT serial_number) as unique_serials'),
                DB::raw('COUNT(*) as total_sales'))
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        return [
            'summary' => [
                'total_sales' => $totalSales,
                'total_revenue' => $totalRevenue,
                'average_sale' => $totalSales > 0 ? $totalRevenue / $totalSales : 0,
            ],
            'sales_by_product' => $salesByProduct,
            'daily_sales' => $dailySales,
            'sales_by_staff' => $salesByStaff,
            'recent_sales' => $recentSales,
            'warranty_analysis' => $warrantyAnalysis,
            'serial_analysis' => $serialAnalysis,
        ];
    }

    public function downloadWarrantyReport(Request $request)
    {
        // Check if user has permission to access reports
        if (!auth()->user()->canAccessReports()) {
            abort(403, 'Access denied');
        }

        // Force English locale for PDF reports
        app()->setLocale('en');

        $dateRange = $this->getDateRange($request);
        $data = $this->getWarrantyData($dateRange);

        // Check if JSON format is requested (for AJAX calls)
        if ($request->get('format') === 'json' || $request->wantsJson()) {
            return response()->json($data);
        }

        // Generate PDF using dompdf directly
        $html = view('admin.reports.warranty', compact('data', 'dateRange'))->render();

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $options->set('isHtml5ParserEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'warranty-coverage-report-' . Carbon::now()->format('Y-m-d-H-i-s') . '.pdf';

        return response()->streamDownload(
            fn () => print($dompdf->output()),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    /**
     * Get warranty data for enhanced PDF with separate tables
     * Route: /admin/reports/warranty-data
     */
    public function getWarrantyDataForPDF(Request $request)
    {
        // Check if user has permission to access reports
        $user = auth()->user();
        if (!$user || ($user && method_exists($user, 'canAccessReports') && !$user->canAccessReports())) {
            abort(403, 'Access denied');
        }

        // Get all sold products with warranty information
        $soldProducts = SoldProduct::with(['product', 'owner', 'employee'])
            ->select([
                'id',
                'product_id',
                'owner_id',
                'user_id',
                'serial_number',
                'sale_date',
                'purchase_price',
                'warranty_start_date',
                'warranty_end_date',
                'warranty_voided',
                'warranty_void_reason'
            ])
            ->orderBy('warranty_end_date', 'desc')
            ->get();

        $underWarranty = [];
        $expired = [];

        foreach ($soldProducts as $soldProduct) {
            $daysLeft = 0;
            $status = 'Expired';

            // Calculate warranty status
            if ($soldProduct->warranty_voided) {
                $status = 'Voided';
            } elseif ($soldProduct->warranty_end_date && now() <= $soldProduct->warranty_end_date) {
                $daysLeft = now()->diffInDays($soldProduct->warranty_end_date);
                $status = 'Active';
            }

            $productData = [
                'model_name' => $soldProduct->product->model_name ?? 'N/A',
                'serial_number' => $soldProduct->serial_number ?? 'N/A',
                'owner_name' => $soldProduct->owner->name ?? 'N/A',
                'purchase_date' => $soldProduct->sale_date ? $soldProduct->sale_date->format('Y-m-d') : 'N/A',
                'purchase_price' => $soldProduct->purchase_price ?? 0,
                'warranty_start_date' => $soldProduct->warranty_start_date ? $soldProduct->warranty_start_date->format('Y-m-d') : 'N/A',
                'warranty_end_date' => $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('Y-m-d') : 'N/A',
                'created_by' => $soldProduct->employee->name ?? 'N/A',
                'days_left' => $daysLeft,
                'company' => 'SoosanEgypt',
                'status' => $status,
                'warranty_end' => $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('Y-m-d') : 'N/A'
            ];

            // Separate into two arrays based on warranty status
            if ($status === 'Active') {
                $underWarranty[] = $productData;
            } else {
                $expired[] = $productData;
            }
        }

        return response()->json([
            'under_warranty' => $underWarranty,
            'expired' => $expired,
            'summary' => [
                'total_products' => count($underWarranty) + count($expired),
                'under_warranty_count' => count($underWarranty),
                'expired_count' => count($expired),
                'warranty_value_active' => array_sum(array_column($underWarranty, 'purchase_price')),
                'warranty_value_expired' => array_sum(array_column($expired, 'purchase_price'))
            ]
        ]);
    }

    /**
     * Get owners data for PDF generation
     * Route: /admin/reports/owners-data
     */
    public function getOwnersDataForPDF(Request $request)
    {
        // Check if user has permission to access reports
        $user = auth()->user();
        if (!$user || ($user && method_exists($user, 'canAccessReports') && !$user->canAccessReports())) {
            abort(403, 'Access denied');
        }

        // Get all owners with their purchase data
        $owners = Owner::with(['soldProducts.product'])
            ->select([
                'id',
                'name',
                'email',
                'phone_number',
                'company',
                'address',
                'city',
                'country',
                'created_at'
            ])
            ->get();

        $ownersData = [];
        $totalRevenue = 0;
        $countryStats = [];
        $cityStats = [];
        $companyStats = [];

        foreach ($owners as $owner) {
            $purchases = $owner->soldProducts;
            $totalSpent = $purchases->sum('purchase_price') ?? 0;
            $totalRevenue += $totalSpent;

            // Build owner data
            $ownerData = [
                'name' => $owner->name ?? 'N/A',
                'email' => $owner->email ?? 'N/A',
                'phone' => $owner->phone_number ?? 'N/A',
                'company' => $owner->company ?? 'Individual',
                'city' => $owner->city ?? 'N/A',
                'country' => $owner->country ?? 'N/A',
                'registration_date' => $owner->created_at ? $owner->created_at->format('Y-m-d') : 'N/A',
                'total_purchases' => $purchases->count(),
                'total_spent' => $totalSpent,
                'items_owned' => $purchases->map(function ($purchase) {
                    return [
                        'product' => $purchase->product->model_name ?? 'N/A',
                        'serial' => $purchase->serial_number ?? 'N/A',
                        'purchase_date' => $purchase->sale_date ? $purchase->sale_date->format('Y-m-d') : 'N/A',
                        'price' => $purchase->purchase_price ?? 0
                    ];
                })->toArray()
            ];

            $ownersData[] = $ownerData;

            // Country statistics
            $countryKey = $owner->country ?? 'Unknown';
            if (!isset($countryStats[$countryKey])) {
                $countryStats[$countryKey] = ['count' => 0, 'revenue' => 0];
            }
            $countryStats[$countryKey]['count']++;
            $countryStats[$countryKey]['revenue'] += $totalSpent;

            // City statistics
            $cityKey = ($owner->city ?? 'Unknown') . ', ' . ($owner->country ?? 'Unknown');
            if (!isset($cityStats[$cityKey])) {
                $cityStats[$cityKey] = ['count' => 0, 'revenue' => 0];
            }
            $cityStats[$cityKey]['count']++;
            $cityStats[$cityKey]['revenue'] += $totalSpent;

            // Company statistics (only if company is not null/empty)
            if (!empty($owner->company)) {
                $companyKey = $owner->company;
                if (!isset($companyStats[$companyKey])) {
                    $companyStats[$companyKey] = ['count' => 0, 'revenue' => 0];
                }
                $companyStats[$companyKey]['count']++;
                $companyStats[$companyKey]['revenue'] += $totalSpent;
            }
        }

        // Sort statistics by revenue
        arsort($countryStats);
        arsort($cityStats);
        arsort($companyStats);

        return response()->json([
            'owners' => $ownersData,
            'analysis' => [
                'total_owners' => count($ownersData),
                'total_revenue' => $totalRevenue,
                'average_revenue_per_owner' => count($ownersData) > 0 ? $totalRevenue / count($ownersData) : 0,
                'countries' => $countryStats,
                'cities' => array_slice($cityStats, 0, 10, true), // Top 10 cities
                'companies' => array_slice($companyStats, 0, 10, true), // Top 10 companies
                'owners_with_companies' => count($companyStats),
                'individual_owners' => count($ownersData) - count($companyStats)
            ]
        ]);
    }

    /**
     * Get sales data for PDF generation
     * Route: /admin/reports/sales-data
     */
    public function getSalesDataForPDF(Request $request)
    {
        // Check if user has permission to access reports
        $user = auth()->user();
        if (!$user || !$user->canAccessReports()) {
            abort(403, 'Access denied');
        }

        $dateRange = $this->getDateRange($request);
        $salesData = $this->getSalesData($dateRange);

        // Get sold products with date filtering and complete information
        $soldProducts = SoldProduct::with(['product.category', 'owner', 'user'])
            ->whereNotNull('sale_date') // Only get products with actual sale dates
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']]) // Apply date filtering
            ->orderBy('sale_date', 'desc')
            ->get()
            ->map(function ($sale) {
                // Determine warranty status
                $warrantyStatus = 'Expired';
                if ($sale->warranty_voided) {
                    $warrantyStatus = 'Voided';
                } elseif ($sale->warranty_end_date && now() <= $sale->warranty_end_date) {
                    $warrantyStatus = 'Active';
                }

                return [
                    'model_name' => $sale->product->model_name ?? 'N/A',
                    'serial_number' => $sale->serial_number ?? 'N/A',
                    'quantity' => $sale->quantity ?? 1, // Default to 1 if quantity is null
                    'purchase_date' => $sale->sale_date ? $sale->sale_date->format('Y-m-d') : 'N/A',
                    'owner_name' => $sale->owner->name ?? 'N/A',
                    'owner_company' => $sale->owner->company ?? 'Individual',
                    'owner_location' => ($sale->owner->city ?? 'N/A') . ', ' . ($sale->owner->country ?? 'N/A'),
                    'purchase_price' => $sale->purchase_price ?? 0,
                    'total_price' => ($sale->purchase_price ?? 0) * ($sale->quantity ?? 1), // Unit price * quantity
                    'seller_name' => $sale->user->name ?? 'N/A',
                    'product_category' => $sale->product->category->name ?? 'N/A',
                    'product_line' => $sale->product->line ?? 'N/A',
                    'product_type' => $sale->product->type ?? 'N/A',
                    'warranty_status' => $warrantyStatus,
                    'warranty_start' => $sale->warranty_start_date ? $sale->warranty_start_date->format('Y-m-d') : 'N/A',
                    'warranty_end' => $sale->warranty_end_date ? $sale->warranty_end_date->format('Y-m-d') : 'N/A',
                ];
            });

        // Enhanced sales analysis for PDF with quantity support
        $totalSales = $soldProducts->count(); // Number of sale records
        $totalQuantity = $soldProducts->sum('quantity'); // Total units sold
        $totalRevenue = $soldProducts->sum('total_price'); // Sum of (unit_price * quantity)
        $averageSale = $totalSales > 0 ? ($totalRevenue / $totalSales) : 0;

        // Get period label for display
        $periodLabels = [
            'last_7_days' => 'Last 7 Days',
            'last_30_days' => 'Last 30 Days',
            'last_90_days' => 'Last 90 Days',
            'this_year' => 'This Year',
            'last_year' => 'Last Year',
            'custom' => 'Custom Date Range'
        ];
        $periodLabel = $periodLabels[$request->get('period', 'last_30_days')] ?? 'Last 30 Days';

        $enhancedData = [
            'summary' => [
                'total_sales' => $totalSales,
                'total_quantity' => $totalQuantity, // Total units sold
                'total_revenue' => $totalRevenue,
                'average_sale' => $averageSale,
                'period_label' => $periodLabel,
                'generated_at' => now()->format('Y-m-d H:i:s'),
                'date_range' => [
                    'start' => $dateRange['start']->format('Y-m-d'),
                    'end' => $dateRange['end']->format('Y-m-d')
                ]
            ],

            // Filtered sold products data
            'all_sold_products' => $soldProducts,

            // Enhanced product performance analysis - Most sold products based on filtered data
            'most_sold_products' => $soldProducts->groupBy('model_name')->map(function ($products, $modelName) use ($totalQuantity) {
                $quantitySold = $products->sum('quantity'); // Sum of quantities for this product
                $salesCount = $products->count(); // Number of sale records
                $revenue = $products->sum('total_price'); // Total revenue for this product
                $avgUnitPrice = $salesCount > 0 ? ($products->sum('purchase_price') / $salesCount) : 0; // Average unit price

                return [
                    'model_name' => $modelName,
                    'category' => $products->first()['product_category'] ?? 'N/A',
                    'line' => $products->first()['product_line'] ?? 'N/A',
                    'type' => $products->first()['product_type'] ?? 'N/A',
                    'quantity_sold' => $quantitySold, // Total units sold
                    'sales_count' => $salesCount, // Number of transactions
                    'revenue' => $revenue, // Total revenue
                    'avg_unit_price' => $avgUnitPrice, // Average price per unit
                    'total_price' => $revenue, // Same as revenue
                    'percentage_of_total' => $totalQuantity > 0 ?
                        round(($quantitySold / $totalQuantity) * 100, 2) : 0
                ];
            })->sortByDesc('quantity_sold')->values(),

            // Revenue analysis by different metrics based on actual sold products
            'revenue_analysis' => [
                'total_revenue' => $totalRevenue,
                'by_category' => $soldProducts->groupBy('product_category')->map(function ($products, $category) {
                    $totalRevenue = $products->sum('total_price'); // Sum of (unit_price * quantity)
                    $totalQuantity = $products->sum('quantity'); // Sum of quantities
                    $salesCount = $products->count(); // Number of transactions
                    return [
                        'category' => $category,
                        'revenue' => $totalRevenue,
                        'quantity' => $totalQuantity, // Total units sold in this category
                        'sales_count' => $salesCount, // Number of transactions
                        'avg_price' => $totalQuantity > 0 ? ($totalRevenue / $totalQuantity) : 0, // Average price per unit
                        'products_count' => $products->pluck('model_name')->unique()->count()
                    ];
                })->sortByDesc('revenue')->values(),

                'by_product_line' => $soldProducts->groupBy('product_line')->map(function ($products, $line) {
                    $totalRevenue = $products->sum('total_price');
                    $totalQuantity = $products->sum('quantity');
                    return [
                        'line' => $line ?: 'N/A',
                        'revenue' => $totalRevenue,
                        'quantity' => $totalQuantity,
                        'avg_price' => $totalQuantity > 0 ? ($totalRevenue / $totalQuantity) : 0,
                        'products_count' => $products->count()
                    ];
                })->sortByDesc('revenue')->values(),

                'monthly_breakdown' => $soldProducts->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item['purchase_date'])->format('Y-m');
                })->map(function ($sales, $month) {
                    $totalRevenue = $sales->sum('purchase_price');
                    $totalSales = $sales->count();
                    return [
                        'month' => $month,
                        'total_sales' => $totalSales,
                        'total_revenue' => $totalRevenue,
                        'avg_price' => $totalSales > 0 ? ($totalRevenue / $totalSales) : 0
                    ];
                })->sortBy('month')->values()
            ],

            // Top performing analysis based on actual sold products
            'top_analysis' => [
                'top_products_by_quantity' => $soldProducts->groupBy('model_name')->map(function ($products, $modelName) {
                    return [
                        'model_name' => $modelName,
                        'quantity_sold' => $products->count(),
                        'revenue' => $products->sum('purchase_price'),
                        'avg_price' => $products->count() > 0 ? ($products->sum('purchase_price') / $products->count()) : 0
                    ];
                })->sortByDesc('quantity_sold')->take(5)->values(),

                'top_products_by_revenue' => $soldProducts->groupBy('model_name')->map(function ($products, $modelName) {
                    return [
                        'model_name' => $modelName,
                        'quantity_sold' => $products->count(),
                        'revenue' => $products->sum('purchase_price'),
                        'avg_price' => $products->count() > 0 ? ($products->sum('purchase_price') / $products->count()) : 0
                    ];
                })->sortByDesc('revenue')->take(5)->values(),

                'top_customers_by_spending' => $soldProducts->groupBy('owner_name')->map(function ($sales, $owner) {
                    $totalSpent = $sales->sum('purchase_price');
                    $totalPurchases = $sales->count();
                    return [
                        'owner_name' => $owner,
                        'company' => $sales->first()['owner_company'] ?? 'Individual',
                        'location' => $sales->first()['owner_location'] ?? 'N/A',
                        'total_spent' => $totalSpent,
                        'total_purchases' => $totalPurchases,
                        'avg_purchase' => $totalPurchases > 0 ? ($totalSpent / $totalPurchases) : 0
                    ];
                })->sortByDesc('total_spent')->take(10)->values(),

                'top_sales_staff' => $soldProducts->groupBy('seller_name')->map(function ($sales, $seller) {
                    $totalRevenue = $sales->sum('purchase_price');
                    $totalSales = $sales->count();
                    return [
                        'name' => $seller,
                        'sales_count' => $totalSales,
                        'revenue' => $totalRevenue,
                        'avg_sale' => $totalSales > 0 ? ($totalRevenue / $totalSales) : 0
                    ];
                })->sortByDesc('revenue')->take(5)->values()
            ],

            // Staff performance analysis based on actual sold products
            'staff_performance' => $soldProducts->groupBy('seller_name')->map(function ($sales, $seller) {
                $totalRevenue = $sales->sum('purchase_price');
                $totalSales = $sales->count();
                return [
                    'name' => $seller,
                    'role' => 'Sales Representative', // Default role
                    'sales_count' => $totalSales,
                    'revenue' => $totalRevenue,
                    'avg_sale' => $totalSales > 0 ? ($totalRevenue / $totalSales) : 0
                ];
            })->sortByDesc('revenue')->values(),

            // Daily sales trend based on actual data
            'daily_trends' => $soldProducts->groupBy('purchase_date')->map(function ($sales, $date) {
                $totalRevenue = $sales->sum('purchase_price');
                $totalSales = $sales->count();
                return [
                    'date' => $date,
                    'sales_count' => $totalSales,
                    'revenue' => $totalRevenue,
                    'avg_sale' => $totalSales > 0 ? ($totalRevenue / $totalSales) : 0
                ];
            })->sortBy('date')->values(),

            // Recent transactions
            'recent_transactions' => $soldProducts->take(20)->map(function ($sale) {
                return [
                    'model_name' => $sale['model_name'],
                    'serial_number' => $sale['serial_number'],
                    'owner_name' => $sale['owner_name'],
                    'seller_name' => $sale['seller_name'],
                    'sale_date' => $sale['purchase_date'],
                    'purchase_price' => $sale['purchase_price'],
                    'warranty_start' => $sale['warranty_start'],
                    'warranty_end' => $sale['warranty_end']
                ];
            }),

            // Warranty and serial analysis based on actual data
            'warranty_analysis' => [
                'total_sales' => $soldProducts->count(),
                'active_warranties' => $soldProducts->filter(function ($sale) {
                    return $sale['warranty_status'] === 'Active';
                })->count(),
                'expired_warranties' => $soldProducts->filter(function ($sale) {
                    return $sale['warranty_status'] === 'Expired';
                })->count(),
                'voided_warranties' => $soldProducts->filter(function ($sale) {
                    return $sale['warranty_status'] === 'Voided';
                })->count(),
                'unique_serials' => $soldProducts->pluck('serial_number')->unique()->count()
            ],

            // Category breakdown based on actual data
            'category_analysis' => $soldProducts->groupBy('product_category')->map(function ($products, $category) {
                return [
                    'category' => $category,
                    'products_count' => $products->count(),
                    'quantity_sold' => $products->count(),
                    'total_revenue' => $products->sum('purchase_price'),
                    'avg_price' => $products->count() > 0 ? ($products->sum('purchase_price') / $products->count()) : 0
                ];
            })->values()
        ];

        return response()->json($enhancedData);
    }

    private function getWarrantyData($dateRange)
    {
        // Get detailed warranty information
        $warrantyDetails = SoldProduct::with(['product', 'owner'])
            ->select([
                'id',
                'product_id',
                'owner_id',
                'serial_number',
                'sale_date',
                'warranty_start_date',
                'warranty_end_date',
                'warranty_voided',
                'warranty_void_reason'
            ])
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->orderBy('warranty_end_date', 'asc')
            ->get()
            ->map(function ($soldProduct) {
                $daysLeft = null;
                $status = 'Expired';

                if ($soldProduct->warranty_voided) {
                    $status = 'Voided';
                } elseif ($soldProduct->warranty_end_date && now() <= $soldProduct->warranty_end_date) {
                    $daysLeft = now()->diffInDays($soldProduct->warranty_end_date);
                    $status = 'Active';
                }

                return [
                    'model_name' => $soldProduct->product->model_name ?? 'N/A',
                    'serial_number' => $soldProduct->serial_number ?? 'N/A',
                    'owner_name' => $soldProduct->owner->name ?? 'N/A',
                    'days_left' => $daysLeft ? $daysLeft . ' days' : 'Expired',
                    'warranty_end' => $soldProduct->warranty_end_date ? $soldProduct->warranty_end_date->format('M d, Y') : 'N/A',
                    'status' => $status
                ];
            });

        // Get summary statistics
        $summary = SoldProduct::select(
                DB::raw('COUNT(*) as total_sold'),
                DB::raw('COUNT(CASE WHEN warranty_end_date > NOW() AND warranty_voided != 1 THEN 1 END) as under_warranty'),
                DB::raw('COUNT(CASE WHEN warranty_end_date <= NOW() OR warranty_voided = 1 THEN 1 END) as expired_warranty'),
                DB::raw('COUNT(CASE WHEN warranty_voided = 1 THEN 1 END) as voided_warranty')
            )
            ->whereBetween('sale_date', [$dateRange['start'], $dateRange['end']])
            ->first();

        return [
            'warranty_details' => $warrantyDetails,
            'summary' => $summary,
            'period' => $dateRange['label']
        ];
    }
}
