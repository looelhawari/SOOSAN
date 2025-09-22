<?php

namespace App\Filament\Resources\SoldProductResource\Pages;

use App\Filament\Resources\SoldProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSoldProducts extends ListRecords
{
    protected static string $resource = SoldProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
