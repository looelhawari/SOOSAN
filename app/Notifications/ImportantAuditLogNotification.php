<?php

namespace App\Notifications;

use App\Models\AuditLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ImportantAuditLogNotification extends Notification
{
    use Queueable;

    protected $auditLog;

    public function __construct(AuditLog $auditLog)
    {
        $this->auditLog = $auditLog;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $event = $this->auditLog->event;
        $eventTranslation = __("audit-logs.table.events.$event");
        $userName = $this->auditLog->user ? $this->auditLog->user->name : __('audit-logs.table.system');
        $modelType = $this->auditLog->auditable_type ? class_basename($this->auditLog->auditable_type) : __('audit-logs.table.system');

        $message = match ($event) {
            'login' => __('audit-logs.table.messages.login', ['user' => $userName]),
            'logout' => __('audit-logs.table.messages.logout', ['user' => $userName]),
            'login_failed' => __('audit-logs.table.messages.login_failed', ['user' => $userName]),
            default => __('audit-logs.table.messages.default'),
        };

        return [
            'type' => 'important_audit_log',
            'title' => $eventTranslation,
            'message' => $message,
            'event' => $event,
            'model_type' => $modelType,
            'user_name' => $userName,
            'audit_log_id' => $this->auditLog->id,
            'created_at' => $this->auditLog->created_at->format('Y-m-d H:i:s'),
            'icon' => __('audit-logs.table.icon_exclamation'),
            'color' => __('audit-logs.table.color_danger'),
            'url' => route('admin.audit-logs.show', $this->auditLog->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        $event = $this->auditLog->event;
        $eventTranslation = __("audit-logs.table.events.$event");
        $userName = $this->auditLog->user ? $this->auditLog->user->name : __('audit-logs.table.system');
        $message = match ($event) {
            'login' => __('audit-logs.table.messages.login', ['user' => $userName]),
            'logout' => __('audit-logs.table.messages.logout', ['user' => $userName]),
            'login_failed' => __('audit-logs.table.messages.login_failed', ['user' => $userName]),
            default => __('audit-logs.table.messages.default'),
        };
        return [
            'type' => 'important_audit_log',
            'title' => $eventTranslation,
            'message' => $message,
            'icon' => __('audit-logs.table.icon_exclamation'),
            'color' => __('audit-logs.table.color_danger'),
            'data' => $this->toArray($notifiable),
        ];
    }
}
