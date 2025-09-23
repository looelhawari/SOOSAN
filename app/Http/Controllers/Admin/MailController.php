<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoReplyMail;

class MailController extends Controller
{
    public function inbox(Request $request)
    {
        try {
            $page = $request->get('page', 1);
            $perPage = 10; // تحديد 10 رسائل في كل صفحة

            // استخدام cache لتحسين الأداء (30 ثانية)
            $cacheKey = 'imap_inbox_messages_' . now()->format('Y-m-d_H-i');
            $cacheTime = 30; // 30 seconds

            $allData = Cache::remember($cacheKey, $cacheTime, function () {
                // الاتصال بـ IMAP
                $client = Client::account('default');
                $client->connect();

                // فتح صندوق الوارد
                $folder = $client->getFolder('INBOX');

                // جلب جميع الرسائل (أو عدد أكبر لدعم التصفح)
                $messages = $folder->messages()->all()->limit(100)->get();

                $mailData = $messages->map(function($message) {
                    $isSeen = false;
                    try {
                        $isSeen = $message->hasFlag('Seen') || $message->hasFlag('\\Seen');
                    } catch (\Exception $e) {
                        // If flag checking fails, assume unread
                        $isSeen = false;
                    }

                    return [
                        'id' => $message->getMessageId(),
                        'uid' => $message->getUid(),
                        'from' => $message->getFrom()->count() > 0 ? $message->getFrom()[0]->mail : '',
                        'from_name' => $message->getFrom()->count() > 0 ? $message->getFrom()[0]->personal : '',
                        'subject' => $message->getSubject(),
                        'date' => $message->getDate(),
                        'body_text' => $message->getTextBody(),
                        'body_html' => $message->getHTMLBody(),
                        'has_attachments' => $message->getAttachments()->count() > 0,
                        'attachments_count' => $message->getAttachments()->count(),
                        'is_seen' => $isSeen,
                        'size' => $message->getSize(),
                        'priority' => $message->getPriority(),
                    ];
                });

                $client->disconnect();
                return $mailData;
            });

            // تحويل البيانات إلى collection وتطبيق pagination
            $totalMessages = $allData->count();
            $offset = ($page - 1) * $perPage;
            $paginatedMails = $allData->skip($offset)->take($perPage);

            // إنشاء pagination instance
            $pagination = new \Illuminate\Pagination\LengthAwarePaginator(
                $paginatedMails->values(),
                $totalMessages,
                $perPage,
                $page,
                [
                    'path' => $request->url(),
                    'pageName' => 'page',
                ]
            );

            // إضافة query parameters الموجودة
            $pagination->appends($request->query());

            // إحصائيات للـ dashboard
            $stats = [
                'total_messages' => $totalMessages,
                'unread_messages' => $allData->where('is_seen', false)->count(),
                'messages_with_attachments' => $allData->where('has_attachments', true)->count(),
                'today_messages' => $allData->where('date', '>=', now()->startOfDay())->count(),
            ];

            return view('admin.mails.inbox', [
                'mails' => $pagination,
                'stats' => $stats
            ]);

        } catch (\Exception $e) {
            Log::error('IMAP Connection Error: ' . $e->getMessage());

            return back()->with('error', __('admin.connection_error') . ': ' . $e->getMessage());
        }
    }

    public function show(Request $request, $uid)
    {
        try {
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            // Use the correct method to get message by UID
            $messages = $folder->messages()->all()->get();
            $message = null;

            foreach ($messages as $msg) {
                if ($msg->getUid() == $uid) {
                    $message = $msg;
                    break;
                }
            }

            if (!$message) {
                $client->disconnect();
                return back()->with('error', __('admin.message_not_found'));
            }

            // تحويل الرسالة إلى مقروءة
            try {
                $message->setFlag(['Seen']);
            } catch (\Exception $flagError) {
                // If setting flag fails, just log it but continue
                Log::warning('Could not set Seen flag: ' . $flagError->getMessage());
            }

            $mailData = [
                'id' => $message->getMessageId(),
                'uid' => $message->getUid(),
                'from' => $message->getFrom()->count() > 0 ? $message->getFrom()[0]->mail : '',
                'from_name' => $message->getFrom()->count() > 0 ? $message->getFrom()[0]->personal : '',
                'to' => $message->getTo()->count() > 0 ? $message->getTo()[0]->mail : '',
                'subject' => $message->getSubject(),
                'date' => $message->getDate(),
                'body_text' => $message->getTextBody(),
                'body_html' => $message->getHTMLBody(),
                'attachments' => $message->getAttachments(),
                'headers' => $message->getHeaders(),
                'is_seen' => true,
                'size' => $message->getSize(),
                'priority' => $message->getPriority(),
            ];

            $client->disconnect();

            return view('admin.mails.show', ['mail' => $mailData]);

        } catch (\Exception $e) {
            Log::error('IMAP Message Error: ' . $e->getMessage());
            return back()->with('error', __('admin.message_display_error') . ': ' . $e->getMessage());
        }
    }

    public function markAsSpam(Request $request, $uid)
    {
        try {
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            $messages = $folder->messages()->all()->get();
            $message = null;

            foreach ($messages as $msg) {
                if ($msg->getUid() == $uid) {
                    $message = $msg;
                    break;
                }
            }

            if ($message) {
                // نقل الرسالة إلى مجلد Spam (إذا كان متوفر)
                try {
                    $spamFolder = $client->getFolder('Spam');
                    $message->move($spamFolder->name);
                } catch (\Exception $e) {
                    // إذا لم يوجد مجلد Spam، ضع علامة كـ spam
                    try {
                        $message->setFlag(['Deleted']);
                    } catch (\Exception $flagError) {
                        Log::warning('Could not set Deleted flag: ' . $flagError->getMessage());
                    }
                }
            }

            $client->disconnect();

            return back()->with('success', __('admin.message_marked_spam'));

        } catch (\Exception $e) {
            Log::error('IMAP Spam Error: ' . $e->getMessage());
            return back()->with('error', __('admin.spam_marking_error'));
        }
    }

    public function archive(Request $request, $uid)
    {
        try {
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            $messages = $folder->messages()->all()->get();
            $message = null;

            foreach ($messages as $msg) {
                if ($msg->getUid() == $uid) {
                    $message = $msg;
                    break;
                }
            }

            if ($message) {
                try {
                    // نقل إلى مجلد الأرشيف
                    $archiveFolder = $client->getFolder('Archive');
                    $message->move($archiveFolder->name);
                } catch (\Exception $e) {
                    // إذا لم يوجد مجلد أرشيف، أنشئ مجلد جديد أو ضع علامة
                    try {
                        $message->setFlag(['Flagged']);
                    } catch (\Exception $flagError) {
                        Log::warning('Could not set Flagged flag: ' . $flagError->getMessage());
                    }
                }
            }

            $client->disconnect();

            return back()->with('success', __('admin.message_archived'));

        } catch (\Exception $e) {
            Log::error('IMAP Archive Error: ' . $e->getMessage());
            return back()->with('error', __('admin.archive_error'));
        }
    }

    public function downloadAttachment(Request $request, $uid, $attachmentId)
    {
        try {
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');

            $messages = $folder->messages()->all()->get();
            $message = null;

            foreach ($messages as $msg) {
                if ($msg->getUid() == $uid) {
                    $message = $msg;
                    break;
                }
            }

            if ($message) {
                $attachments = $message->getAttachments();
                $attachment = $attachments->get($attachmentId);

                if ($attachment) {
                    $client->disconnect();

                    return response($attachment->getContent())
                        ->header('Content-Type', $attachment->getMimeType())
                        ->header('Content-Disposition', 'attachment; filename="' . $attachment->getName() . '"');
                }
            }

            $client->disconnect();
            return back()->with('error', __('admin.attachment_not_found'));

        } catch (\Exception $e) {
            Log::error('IMAP Attachment Error: ' . $e->getMessage());
            return back()->with('error', __('admin.attachment_download_error'));
        }
    }

    /**
     * Send auto-reply to new emails
     */
    public function sendAutoReply($senderEmail, $senderName, $originalSubject)
    {
        try {
            // Check if auto-reply was already sent to this email today
            $cacheKey = 'auto_reply_sent_' . md5($senderEmail) . '_' . now()->format('Y-m-d');

            if (Cache::has($cacheKey)) {
                Log::info("Auto-reply already sent today to: {$senderEmail}");
                return false;
            }

            // Don't send auto-reply to our own support email or common auto-reply emails
            $excludedEmails = [
                'support@soosanegypt.com',
                'no-reply@',
                'noreply@',
                'do-not-reply@',
                'auto-reply@',
                'mailer-daemon@'
            ];

            foreach ($excludedEmails as $excluded) {
                if (stripos($senderEmail, $excluded) !== false) {
                    Log::info("Skipping auto-reply to excluded email: {$senderEmail}");
                    return false;
                }
            }

            // Send auto-reply email
            Mail::to($senderEmail)->send(new AutoReplyMail($senderName, $senderEmail, $originalSubject));

            // Cache that we sent auto-reply to prevent duplicates (expires at end of day)
            Cache::put($cacheKey, true, now()->endOfDay());

            Log::info("Auto-reply sent successfully to: {$senderEmail}");
            return true;

        } catch (\Exception $e) {
            Log::error('Auto-reply sending failed: ' . $e->getMessage());
            return false;
        }
    }
}
