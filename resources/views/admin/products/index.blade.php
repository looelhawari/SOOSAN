@extends('layouts.admin')

@section('title', __('products.title'))
@section('page-title', __('products.title'))

@push('styles')
    <style>
        /* Reset and Base Styles */
        .modern-container * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        .modern-container {
            font-family: 'Inter', 'Segoe UI', system-ui, sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            padding: 1rem;
            color: #1a202c;
            line-height: 1.6;
        }

        .dark-mode .modern-container {
            background: linear-gradient(135deg, #1a202c 0%, #2d3748 100%);
            color: #f7fafc;
        }

        /* Page Header */
        .modern-page-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            padding: 2rem 1.5rem;
            margin: -1rem -1rem 2rem;
            border-radius: 0 0 24px 24px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .modern-page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.1)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,133.3C672,139,768,181,864,197.3C960,213,1056,203,1152,170.7C1248,139,1344,85,1392,58.7L1440,32L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
            z-index: 0;
        }

        .modern-page-header .container-fluid {
            position: relative;
            z-index: 1;
        }

        .modern-page-header h1 {
            font-weight: 700;
            font-size: clamp(1.5rem, 4vw, 2rem);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .modern-page-header p {
            font-size: 1rem;
            opacity: 0.9;
            margin-bottom: 0;
        }

        .header-actions {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
            justify-content: flex-end;
            align-items: center;
        }

        /* Modern Card */
        .modern-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark-mode .modern-card {
            background: rgba(45, 55, 72, 0.95);
            border-color: rgba(74, 85, 104, 0.3);
        }

        /* Stats Cards */
        .modern-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .modern-stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .modern-stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #667eea, #764ba2);
        }

        .modern-stat-card:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .dark-mode .modern-stat-card {
            background: rgba(45, 55, 72, 0.95);
            border-color: rgba(74, 85, 104, 0.3);
        }

        .modern-stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #ffffff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin-bottom: 1rem;
            transition: transform 0.3s ease;
        }

        .modern-stat-card:hover .modern-stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .modern-stat-content h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.25rem;
            line-height: 1;
            a
        }

        .dark-mode .modern-stat-content h3 {
            color: #f7fafc;
        }

        .modern-stat-content p {
            color: #718096;
            font-size: 0.875rem;
            font-weight: 500;
            margin: 0;
        }

        .dark-mode .modern-stat-content p {
            color: #a0aec0;
        }

        /* Search and Filter Controls */
        .modern-controls {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 1.5rem;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .dark-mode .modern-controls {
            background: rgba(45, 55, 72, 0.95);
            border-color: rgba(74, 85, 104, 0.3);
        }

        .modern-controls-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
        }

        .dark-mode .modern-controls-header {
            border-bottom-color: rgba(74, 85, 104, 0.8);
        }

        .modern-controls-header i {
            color: #667eea;
            font-size: 1.25rem;
        }

        .modern-controls-header h3 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #1a202c;
            margin: 0;
        }

        .dark-mode .modern-controls-header h3 {
            color: #f7fafc;
        }

        .modern-filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 1rem;
            align-items: end;
        }

        .modern-form-group label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 0.875rem;
        }

        .dark-mode .modern-form-group label {
            color: #f7fafc;
        }

        .modern-form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
            color: #1a202c;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(5px);
        }

        .modern-form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
            background: rgba(255, 255, 255, 1);
        }

        .dark-mode .modern-form-control {
            background: rgba(45, 55, 72, 0.9);
            border-color: #4a5568;
            color: #f7fafc;
        }

        .dark-mode .modern-form-control:focus {
            border-color: #667eea;
            background: rgba(45, 55, 72, 1);
        }

        .modern-form-control.select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1.25em 1.25em;
            padding-right: 2.5rem;
        }

        /* Buttons */
        .modern-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .modern-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .modern-btn:hover::before {
            left: 100%;
        }

        .modern-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .modern-btn-secondary {
            background: linear-gradient(135deg, #718096 0%, #4a5568 100%);
        }

        .modern-btn-secondary:hover {
            box-shadow: 0 10px 25px -5px rgba(113, 128, 150, 0.4);
        }

        /* Employee Notice */
        .modern-notice {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border-left: 4px solid #f59e0b;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-radius: 12px;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .dark-mode .modern-notice {
            background: linear-gradient(135deg, #451a03 0%, #78350f 100%);
            border-left-color: #f59e0b;
        }

        .modern-notice i {
            color: #f59e0b;
            font-size: 1.25rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .modern-notice h4 {
            color: #92400e;
            margin: 0 0 0.25rem 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .dark-mode .modern-notice h4 {
            color: #fbbf24;
        }

        .modern-notice p {
            color: #92400e;
            margin: 0;
            font-size: 0.875rem;
            line-height: 1.5;
        }

        .dark-mode .modern-notice p {
            color: #fcd34d;
        }

        /* Product Grid */
        .modern-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .modern-product-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.6s ease forwards;
            opacity: 1 !important;
            transform: none !important;
        }

        .modern-product-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dark-mode .modern-product-card {
            background: rgba(45, 55, 72, 0.95);
            border-color: rgba(74, 85, 104, 0.3);
        }

        .modern-product-card:nth-child(1) {
            animation-delay: 0.1s;
        }

        .modern-product-card:nth-child(2) {
            animation-delay: 0.2s;
        }

        .modern-product-card:nth-child(3) {
            animation-delay: 0.3s;
        }

        .modern-product-card:nth-child(4) {
            animation-delay: 0.4s;
        }

        .modern-product-card:nth-child(5) {
            animation-delay: 0.5s;
        }

        .modern-product-card:nth-child(6) {
            animation-delay: 0.6s;
        }

        /* Product Image */
        .modern-image {
            position: relative;
            height: 200px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .dark-mode .modern-image {
            background: linear-gradient(135deg, #2d3748 0%, #4a5568 100%);
        }

        .modern-image-wrapper {
            width: 100%;
            height: 200px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            background: inherit;
        }

        .modern-product-image {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .modern-product-card:hover .modern-product-image {
            transform: scale(1.1);
        }

        .modern-image-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #9ca3af;
            font-size: 2.5rem;
            gap: 0.5rem;
        }

        .dark-mode .modern-image-placeholder {
            color: #6b7280;
        }

        .modern-image-placeholder span {
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Status Badges */
        .modern-status-badges {
            position: absolute;
            top: 1rem;
            right: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            z-index: 10;
        }

        .modern-status {
            padding: 0.375rem 0.75rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .modern-status.active {
            background: rgba(16, 185, 129, 0.9);
            color: #ffffff;
        }

        .modern-status.inactive {
            background: rgba(239, 68, 68, 0.9);
            color: #ffffff;
        }

        .modern-status.featured {
            background: rgba(245, 158, 11, 0.9);
            color: #ffffff;
        }

        /* Product Content */
        .modern-content {
            padding: 1.5rem;
        }

        .modern-card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 0.75rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .dark-mode .modern-card-title {
            color: #f7fafc;
        }

        .modern-category {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 0.75rem;
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .dark-mode .modern-category {
            background: rgba(102, 126, 234, 0.2);
            border-color: rgba(102, 126, 234, 0.3);
        }

        .modern-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin: 1rem 0;
            padding: 1rem;
            background: rgba(248, 250, 252, 0.8);
            border-radius: 12px;
            border: 1px solid rgba(226, 232, 240, 0.5);
        }

        .dark-mode .modern-details {
            background: rgba(45, 55, 72, 0.8);
            border-color: rgba(74, 85, 104, 0.5);
        }

        .modern-detail-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.875rem;
        }

        .modern-detail-item i {
            color: #667eea;
            width: 16px;
            flex-shrink: 0;
        }

        .modern-detail-label {
            color: #6b7280;
            font-weight: 500;
            min-width: 60px;
        }

        .dark-mode .modern-detail-label {
            color: #9ca3af;
        }

        .modern-detail-value {
            font-weight: 600;
            color: #1a202c;
            flex: 1;
        }

        .dark-mode .modern-detail-value {
            color: #f7fafc;
        }

        /* Product Actions */
        .modern-actions {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 0.5rem;
            padding: 1rem 1.5rem;
            background: rgba(248, 250, 252, 0.8);
            border-top: 1px solid rgba(226, 232, 240, 0.5);
        }

        .dark-mode .modern-actions {
            background: rgba(45, 55, 72, 0.8);
            border-top-color: rgba(74, 85, 104, 0.5);
        }

        .modern-action-btn {
            padding: 0.625rem 1rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.75rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .modern-action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .modern-action-btn:hover::before {
            left: 100%;
        }

        .modern-action-btn.view {
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .modern-action-btn.view:hover {
            background: #3b82f6;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .modern-action-btn.edit {
            background: rgba(245, 158, 11, 0.1);
            color: #f59e0b;
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .modern-action-btn.edit:hover {
            background: #f59e0b;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4);
        }

        .modern-action-btn.delete {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .modern-action-btn.delete:hover {
            background: #ef4444;
            color: #ffffff;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.4);
        }

        /* Product Footer */
        .modern-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(226, 232, 240, 0.5);
            background: rgba(248, 250, 252, 0.5);
        }

        .dark-mode .modern-footer {
            border-top-color: rgba(74, 85, 104, 0.5);
            background: rgba(45, 55, 72, 0.5);
        }

        .modern-created-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #6b7280;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .dark-mode .modern-created-date {
            color: #9ca3af;
        }

        .modern-created-date i {
            color: #667eea;
        }

        /* Pagination */
        .modern-pagination-wrapper {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            margin: 2rem 0;
            padding: 1.5rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark-mode .modern-pagination-wrapper {
            background: rgba(45, 55, 72, 0.95);
            border-color: rgba(74, 85, 104, 0.3);
        }

        .modern-pagination-wrapper .pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.5rem;
            align-items: center;
            flex-wrap: wrap;
            justify-content: center;
        }

        .modern-pagination-wrapper .page-item {
            margin: 0;
            list-style: none;
        }

        .modern-pagination-wrapper .page-item.active .page-link {
            color: #ffffff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-color: #667eea;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
            font-weight: 600;
        }

        .modern-pagination-wrapper .page-item.disabled .page-link {
            color: #9ca3af;
            pointer-events: none;
            background: rgba(248, 250, 252, 0.8);
            border-color: rgba(226, 232, 240, 0.8);
            opacity: 0.6;
            cursor: not-allowed;
        }

        .dark-mode .modern-pagination-wrapper .page-item.disabled .page-link {
            background: rgba(45, 55, 72, 0.8);
            border-color: rgba(74, 85, 104, 0.8);
            color: #6b7280;
        }

        .modern-pagination-wrapper .page-link {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            color: #374151;
            text-decoration: none;
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(226, 232, 240, 0.8);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 44px;
            font-weight: 500;
            justify-content: center;
            backdrop-filter: blur(5px);
        }

        .dark-mode .modern-pagination-wrapper .page-link {
            background: rgba(45, 55, 72, 0.9);
            border-color: rgba(74, 85, 104, 0.8);
            color: #f7fafc;
        }

        .modern-pagination-wrapper .page-link:hover {
            color: #667eea;
            background: rgba(255, 255, 255, 1);
            border-color: #667eea;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
        }

        .dark-mode .modern-pagination-wrapper .page-link:hover {
            color: #667eea;
            background: rgba(45, 55, 72, 1);
            border-color: #667eea;
        }

        .pagination-info {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 500;
            text-align: center;
        }

        .dark-mode .pagination-info {
            color: #9ca3af;
        }

        /* Empty State */
        .modern-empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark-mode .modern-empty-state {
            background: rgba(45, 55, 72, 0.95);
            border-color: rgba(74, 85, 104, 0.3);
        }

        .modern-empty-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto 1.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 2rem;
            box-shadow: 0 10px 25px -5px rgba(102, 126, 234, 0.4);
        }

        .modern-empty-state h3 {
            color: #1a202c;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .dark-mode .modern-empty-state h3 {
            color: #f7fafc;
        }

        .modern-empty-state p {
            color: #6b7280;
            margin-bottom: 1.5rem;
            font-size: 1rem;
        }

        .dark-mode .modern-empty-state p {
            color: #9ca3af;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Mobile Responsive */
        @media (max-width: 1024px) {
            .modern-grid {
                grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            }

            .modern-filter-grid {
                grid-template-columns: 1fr 1fr;
                gap: 1rem;
            }

            .modern-filter-grid> :nth-child(3),
            .modern-filter-grid> :nth-child(4) {
                grid-column: span 2;
            }
        }

        @media (max-width: 768px) {
            .modern-container {
                padding: 0.75rem;
            }

            .modern-page-header {
                margin: -0.75rem -0.75rem 1.5rem;
                padding: 1.5rem 1rem;
            }

            .modern-page-header .row {
                flex-direction: column;
                gap: 1rem;
            }

            .header-actions {
                justify-content: center;
            }

            .modern-filter-grid {
                grid-template-columns: 1fr;
            }

            .modern-grid {
                grid-template-columns: 1fr;
            }

            .modern-image,
            .modern-image-wrapper {
                height: 180px;
            }

            .modern-stats {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .modern-actions {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }

            .modern-action-btn {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .modern-pagination-wrapper .page-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
                min-width: 36px;
            }
        }

        @media (max-width: 576px) {
            .modern-page-header h1 {
                font-size: 1.25rem;
            }

            .modern-page-header p {
                font-size: 0.875rem;
            }

            .modern-stats {
                grid-template-columns: 1fr;
            }

            .modern-stat-card {
                padding: 1rem;
            }

            .modern-stat-icon {
                width: 48px;
                height: 48px;
                font-size: 1.25rem;
            }

            .modern-stat-content h3 {
                font-size: 1.5rem;
            }

            .modern-controls {
                padding: 1rem;
            }

            .modern-content {
                padding: 1rem;
            }

            .modern-actions {
                padding: 1rem;
            }

            .modern-footer {
                padding: 1rem;
            }

            .modern-empty-state {
                padding: 2rem 1rem;
            }

            .modern-empty-icon {
                width: 64px;
                height: 64px;
                font-size: 1.5rem;
            }

            .modern-empty-state h3 {
                font-size: 1.25rem;
            }

            .modern-empty-state p {
                font-size: 0.875rem;
            }

            /* Mobile-specific text/icon switching */
            .mobile-text {
                display: none;
            }

            .mobile-icon {
                display: inline;
            }

            .modern-action-btn .mobile-text {
                display: none;
            }

            .modern-btn .mobile-text {
                display: none;
            }
        }

        /* Large screens optimization */
        @media (min-width: 1200px) {
            .modern-grid {
                grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            }

            .modern-filter-grid {
                grid-template-columns: 3fr 1fr 1fr auto;
            }
        }

        /* Focus and accessibility */
        .modern-form-control:focus,
        .modern-btn:focus,
        .modern-action-btn:focus,
        .modern-pagination-wrapper .page-link:focus {
            outline: 2px solid #667eea;
            outline-offset: 2px;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="modern-container">
        <!-- Page Header -->
        <div class="modern-page-header">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1>
                            <i class="fas fa-cubes"></i>
                            {{ __('products.hydraulic_breakers') }}
                        </h1>
                        <p>{{ __('products.manage_products') }}</p>
                    </div>
                    <div class="col-lg-4">
                        <div class="header-actions">
                            <a href="{{ route('admin.products.create') }}" class="modern-btn">
                                <i class="fas fa-plus"></i>
                                <span class="mobile-text">{{ __('products.add_product') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if (auth()->user()->isEmployee())
            <!-- Employee Notice -->
            <div class="modern-notice">
                <i class="fas fa-info-circle"></i>
                <div>
                    <h4>{{ __('products.employee_access') }}</h4>
                    <p>{{ __('products.employee_access_desc') }}</p>
                </div>
            </div>
        @endif

        <!-- Stats Cards -->
        <div class="modern-stats">
            <div class="modern-stat-card">
                <div class="modern-stat-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <div class="modern-stat-content">
                    <h3>{{ $products->total() }}</h3>
                    <p>{{ __('products.total_products') }}</p>
                </div>
            </div>

            <div class="modern-stat-card">
                <div class="modern-stat-icon" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="modern-stat-content">
                    <h3>{{ $products->where('status', 'active')->count() }}</h3>
                    <p>{{ __('products.active_products') }}</p>
                </div>
            </div>

            <div class="modern-stat-card">
                <div class="modern-stat-icon" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                    <i class="fas fa-star"></i>
                </div>
                <div class="modern-stat-content">
                    <h3>{{ $products->where('is_featured', true)->count() }}</h3>
                    <p>{{ __('products.featured_products') }}</p>
                </div>
            </div>

            <div class="modern-stat-card">
                <div class="modern-stat-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                    <i class="fas fa-tags"></i>
                </div>
                <div class="modern-stat-content">
                    <h3>{{ $categories->count() }}</h3>
                    <p>{{ __('products.categories') }}</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter Controls -->
        <div class="modern-controls">
            <div class="modern-controls-header">
                <i class="fas fa-search"></i>
                <h3>{{ __('products.search_filter_products') }}</h3>
            </div>

            <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
                <div class="modern-filter-grid">
                    <div class="modern-form-group">
                        <label for="search">{{ __('products.search_products') }}</label>
                        <input type="text" id="search" name="search" class="modern-form-control"
                            placeholder="{{ __('products.search_placeholder') }}" value="{{ request('search') }}">
                    </div>

                    <div class="modern-form-group">
                        <label for="category_filter">{{ __('products.category') }}</label>
                        <select id="category_filter" name="category" class="modern-form-control select">
                            <option value="">{{ __('products.all_categories') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="modern-form-group">
                        <label for="status_filter">{{ __('products.status') }}</label>
                        <select id="status_filter" name="status" class="modern-form-control select">
                            <option value="">{{ __('products.all_status') }}</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>
                                {{ __('products.active') }}</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>
                                {{ __('products.inactive') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="modern-btn">
                        <i class="fas fa-search"></i>
                        <span class="mobile-text">{{ __('products.search') }}</span>
                    </button>
                </div>
            </form>
        </div>

        @if ($products->count() > 0)
            <!-- Products Grid -->
            <div class="modern-grid">
                @foreach ($products as $product)
                    <div class="modern-product-card">
                        <!-- Product Image -->
                        <div class="modern-image">
                            @if ($product->image_url)
                                <div class="modern-image-wrapper">
                                    <img src="{{ $product->image_url }}" alt="{{ $product->model_name }}"
                                        class="modern-product-image" loading="lazy">
                                </div>
                            @else
                                <div class="modern-image-placeholder">
                                    <i class="fas fa-image"></i>
                                    <span>{{ __('products.no_image') }}</span>
                                </div>
                            @endif

                            <!-- Status Badges -->
                            <div class="modern-status-badges">
                                @if ($product->is_featured)
                                    <div class="modern-status featured">
                                        <i class="fas fa-star"></i>
                                        <span class="mobile-text">{{ __('products.featured') }}</span>
                                    </div>
                                @endif
                                <div class="modern-status {{ $product->is_active ? 'active' : 'inactive' }}">
                                    <i class="fas fa-{{ $product->is_active ? 'check' : 'times' }}"></i>
                                    <span
                                        class="mobile-text">{{ $product->is_active ? __('products.active') : __('products.inactive') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="modern-content">
                            <h4 class="modern-card-title">{{ $product->model_name }}</h4>

                            @if ($product->category)
                                <span class="modern-category">
                                    <i class="fas fa-tag"></i>
                                    {{ $product->category->name }}
                                </span>
                            @endif

                            <!-- Product Details -->
                            <div class="modern-details">
                                @if ($product->line)
                                    <div class="modern-detail-item">
                                        <i class="fas fa-layer-group"></i>
                                        <span class="modern-detail-label">{{ __('products.line') }}:</span>
                                        <span class="modern-detail-value">{{ $product->line }}</span>
                                    </div>
                                @endif
                                @if ($product->type)
                                    <div class="modern-detail-item">
                                        <i class="fas fa-tools"></i>
                                        <span class="modern-detail-label">{{ __('products.type') }}:</span>
                                        <span class="modern-detail-value">{{ $product->type }}</span>
                                    </div>
                                @endif
                                @if ($product->body_weight)
                                    <div class="modern-detail-item">
                                        <i class="fas fa-weight-hanging"></i>
                                        <span class="modern-detail-label">{{ __('products.weight') }}:</span>
                                        <span class="modern-detail-value">{{ $product->body_weight }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Product Actions -->
                        <div class="modern-actions">
                            <a href="{{ route('admin.products.show', $product) }}" class="modern-action-btn view">
                                <i class="fas fa-eye"></i>
                                <span class="mobile-text">{{ __('products.view') }}</span>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="modern-action-btn edit">
                                <i class="fas fa-edit"></i>
                                <span class="mobile-text">{{ __('products.edit') }}</span>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                style="display: contents;"
                                onsubmit="return confirm('{{ __('products.delete_confirmation') }}')">
                                    @csrf
                                @method('DELETE')
                                <button type="submit" class="modern-action-btn delete">
                                    <i class="fas fa-trash"></i>
                                    <span class="mobile-text">{{ __('products.delete') }}</span>
                                </button>
                            </form>
                        </div>

                        <!-- Product Footer -->
                        <div class="modern-footer">
                            <div class="modern-created-date">
                                <i class="fas fa-calendar"></i>
                                <span>{{ $product->created_at ? $product->created_at->format('M d, Y') : 'N/A' }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($products->hasPages())
                <div class="modern-pagination-wrapper">
                    <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
                        {{-- Previous Page Link --}}
                        @if ($products->onFirstPage())
                            <span class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                    <span class="mobile-text">{{ __('products.previous') }}</span>
                                </span>
                            </span>
                        @else
                            <a href="{{ $products->previousPageUrl() }}" class="page-item">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                    <span class="mobile-text">{{ __('products.previous') }}</span>
                                </span>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $start = max($products->currentPage() - 2, 1);
                            $end = min($start + 4, $products->lastPage());
                            $start = max($end - 4, 1);
                        @endphp

                        {{-- First page link --}}
                        @if ($start > 1)
                            <a href="{{ $products->url(1) }}" class="page-item">
                                <span class="page-link">1</span>
                            </a>
                            @if ($start > 2)
                                <span class="page-item disabled">
                                    <span class="page-link">...</span>
                                </span>
                            @endif
                        @endif

                        {{-- Page links --}}
                        @for ($page = $start; $page <= $end; $page++)
                            @if ($page == $products->currentPage())
                                <span class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $products->url($page) }}" class="page-item">
                                    <span class="page-link">{{ $page }}</span>
                                </a>
                            @endif
                        @endfor

                        {{-- Last page link --}}
                        @if ($end < $products->lastPage())
                            @if ($end < $products->lastPage() - 1)
                                <span class="page-item disabled">
                                    <span class="page-link">...</span>
                                </span>
                            @endif
                            <a href="{{ $products->url($products->lastPage()) }}" class="page-item">
                                <span class="page-link">{{ $products->lastPage() }}</span>
                            </a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($products->hasMorePages())
                            <a href="{{ $products->nextPageUrl() }}" class="page-item">
                                <span class="page-link">
                                    <span class="mobile-text">{{ __('products.next') }}</span>
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </a>
                        @else
                            <span class="page-item disabled">
                                <span class="page-link">
                                    <span class="mobile-text">{{ __('products.next') }}</span>
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </span>
                        @endif
                    </nav>

                    <div class="pagination-info">
                        {{ __('products.showing_results', ['first' => $products->firstItem(), 'last' => $products->lastItem(), 'total' => $products->total()]) }}
                    </div>
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="modern-empty-state">
                <div class="modern-empty-icon">
                    <i class="fas fa-cubes"></i>
                </div>
                <h3>{{ __('products.no_products_found') }}</h3>
                <p>{{ __('products.start_building_catalog') }}</p>
                <a href="{{ route('admin.products.create') }}" class="modern-btn">
                    <i class="fas fa-plus"></i>
                    <span class="mobile-text">{{ __('products.add_first_product') }}</span>
                </a>
            </div>
        @endif
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Auto-submit form on filter change
                const filterForm = document.getElementById('filterForm');
                const filterInputs = filterForm.querySelectorAll('select');

                filterInputs.forEach(input => {
                    input.addEventListener('change', function() {
                        filterForm.submit();
                    });
                });

                // Add loading state to forms
                document.querySelectorAll('form').forEach(form => {
                    form.addEventListener('submit', function() {
                        const submitBtn = form.querySelector('button[type="submit"]');
                        if (submitBtn && !submitBtn.dataset.noLoading) {
                            submitBtn.disabled = true;
                            const originalContent = submitBtn.innerHTML;
                            submitBtn.innerHTML =
                                '<i class="fas fa-spinner fa-spin"></i> <span class="mobile-text">{{ __('products.processing') }}</span>';

                            // Reset after 5 seconds as fallback
                            setTimeout(() => {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = originalContent;
                            }, 5000);
                        }
                    });
                });

                // Confirmation for delete actions
                document.querySelectorAll('form[method="POST"]').forEach(form => {
                    const methodInput = form.querySelector('input[name="_method"]');
                    if (methodInput && methodInput.value === 'DELETE') {
                        form.addEventListener('submit', function(e) {
                            if (!confirm('{{ __('products.delete_cannot_undone') }}')) {
                                e.preventDefault();
                            }
                        });
                    }
                });

                // Auto-hide alerts
                setTimeout(() => {
                    document.querySelectorAll('.alert').forEach(alert => {
                        if (alert.style) {
                            alert.style.opacity = '0';
                            alert.style.transition = 'opacity 0.3s ease';
                            setTimeout(() => alert.remove(), 300);
                        }
                    });
                }, 5000);

                // Enhanced focus effects
                const inputs = document.querySelectorAll('.modern-form-control');
                inputs.forEach(input => {
                    input.addEventListener('focus', function() {
                        this.parentElement.classList.add('focused');
                    });
                    input.addEventListener('blur', function() {
                        this.parentElement.classList.remove('focused');
                    });
                });

                // Smooth scroll for pagination
                document.querySelectorAll('.page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        if (this.getAttribute('href') && this.getAttribute('href') !== '#') {
                            setTimeout(() => {
                                window.scrollTo({
                                    top: 0,
                                    behavior: 'smooth'
                                });
                            }, 100);
                        }
                    });
                });

                // Image lazy loading fallback
                const images = document.querySelectorAll('.modern-product-image');
                images.forEach(img => {
                    img.addEventListener('error', function() {
                        this.parentElement.innerHTML = `
                <div class="modern-image-placeholder">
                    <i class="fas fa-image"></i>
                    <span>{{ __('products.image_error') }}</span>
                </div>
            `;
                    });
                });

                // Keyboard navigation for cards
                document.querySelectorAll('.modern-product-card').forEach((card, index) => {
                    card.setAttribute('tabindex', '0');
                    card.addEventListener('keydown', function(e) {
                        if (e.key === 'Enter' || e.key === ' ') {
                            e.preventDefault();
                            const viewLink = this.querySelector('.modern-action-btn.view');
                            if (viewLink) {
                                viewLink.click();
                            }
                        }
                    });
                });
            });

            // Performance optimization: Debounce search input
            let searchTimeout;
            const searchInput = document.getElementById('search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        // Auto-submit search after 500ms of no typing
                        if (this.value.length >= 3 || this.value.length === 0) {
                            document.getElementById('filterForm').submit();
                        }
                    }, 500);
                });
            }
        </script>
    @endpush
@endsection
