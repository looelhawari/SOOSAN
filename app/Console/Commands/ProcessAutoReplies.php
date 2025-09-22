<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\AutoReplyMail;

class ProcessAutoReplies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:auto-reply {--dry-run : Run without sending emails}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process auto-replies for new unread emails';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        
        $this->info('Starting auto-reply processing...');
        
        try {
            // Connect to IMAP
            $client = Client::account('default');
            $client->connect();

            $folder = $client->getFolder('INBOX');
            
            // Get only unread messages for auto-reply
            $allMessages = $folder->messages()->all()->get();
            $unreadMessages = collect();
            
            foreach ($allMessages as $message) {
                try {
                    if (!$message->hasFlag('Seen') && !$message->hasFlag('\\Seen')) {
                        $unreadMessages->push($message);
                    }
                } catch (\Exception $e) {
                    // If flag checking fails, assume it's unread
                    $unreadMessages->push($message);
                }
            }

            $processed = 0;
            $sent = 0;
            $errors = 0;

            $this->info("Found {$unreadMessages->count()} unread messages");

            foreach ($unreadMessages as $message) {
                $processed++;
                
                $senderEmail = $message->getFrom()->count() > 0 ? $message->getFrom()[0]->mail : '';
                $senderName = $message->getFrom()->count() > 0 ? $message->getFrom()[0]->personal : '';
                $subject = $message->getSubject();

                $this->line("Processing email #{$processed}: {$senderEmail}");

                if (!empty($senderEmail)) {
                    if ($dryRun) {
                        $this->info("  [DRY RUN] Would send auto-reply to: {$senderEmail}");
                        $sent++;
                    } else {
                        try {
                            if ($this->sendAutoReply($senderEmail, $senderName, $subject)) {
                                $this->info("  ✓ Auto-reply sent to: {$senderEmail}");
                                $sent++;
                            } else {
                                $this->warn("  ⚠ Auto-reply skipped for: {$senderEmail}");
                            }
                        } catch (\Exception $e) {
                            $this->error("  ✗ Failed to send auto-reply to: {$senderEmail} - {$e->getMessage()}");
                            $errors++;
                        }
                    }
                } else {
                    $this->warn("  ⚠ No sender email found");
                }
            }

            $client->disconnect();

            // Output summary
            $this->newLine();
            $this->info("=== Auto-Reply Processing Complete ===");
            $this->line("Processed: {$processed} messages");
            $this->line("Sent: {$sent} auto-replies");
            if ($errors > 0) {
                $this->error("Errors: {$errors}");
            }
            
            if ($dryRun) {
                $this->warn("This was a dry run - no emails were actually sent");
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('Auto-reply processing failed: ' . $e->getMessage());
            Log::error('Auto-reply command error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Send auto-reply to new emails
     */
    private function sendAutoReply($senderEmail, $senderName, $originalSubject)
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
            throw $e;
        }
    }
}
