<?php

namespace App\Filament\Resources\ContactMessageResource\Pages;

use App\Filament\Resources\ContactMessageResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('mark_as_read')
                ->label('Mark as Read')
                ->icon('heroicon-o-check')
                ->color('success')
                ->visible(fn() => !$this->record->is_read)
                ->action(fn() => $this->record->markAsRead())
                ->after(fn() => $this->refreshFormData(['is_read', 'read_at'])),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // If the message is not read and we're viewing it, mark it as read automatically
        if ($this->record && !$this->record->is_read) {
            $this->record->markAsRead();

            // Update the data to reflect the change
            $data['is_read'] = true;
            $data['read_at'] = now()->format('Y-m-d H:i:s');
        }

        return $data;
    }
}
