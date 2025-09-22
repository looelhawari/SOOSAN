<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SoldProductResource\Pages;
use App\Filament\Resources\SoldProductResource\RelationManagers;
use App\Models\SoldProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SoldProductResource extends Resource
{
    protected static ?string $model = SoldProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Product Information')
                    ->schema([
                        Forms\Components\Select::make('product_id')
                            ->relationship('product', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->model_number})")
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('serial_number')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Enter the unique serial number for this product'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Ownership Information')
                    ->schema([
                        Forms\Components\Select::make('owner_id')
                            ->relationship('owner', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('address'),
                            ])
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->email})")
                            ->columnSpan(2),
                        Forms\Components\Select::make('employee_id')
                            ->relationship('employee', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->email})")
                            ->helperText('Employee who processed this sale'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Sale Details')
                    ->schema([
                        Forms\Components\DatePicker::make('sale_date')
                            ->required()
                            ->default(now()),
                        Forms\Components\DatePicker::make('warranty_start_date')
                            ->required()
                            ->default(now()),
                        Forms\Components\DatePicker::make('warranty_end_date')
                            ->required()
                            ->after('warranty_start_date'),
                        Forms\Components\TextInput::make('purchase_price')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01),
                        Forms\Components\Textarea::make('notes')
                            ->columnSpanFull()
                            ->rows(3)
                            ->placeholder('Additional notes about this sale...'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable()
                    ->sortable()
                    ->label('Product'),
                Tables\Columns\TextColumn::make('serial_number')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Serial number copied')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('owner.name')
                    ->searchable()
                    ->sortable()
                    ->label('Owner'),
                Tables\Columns\TextColumn::make('employee.name')
                    ->searchable()
                    ->sortable()
                    ->label('Sold By'),
                Tables\Columns\TextColumn::make('sale_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('warranty_end_date')
                    ->date()
                    ->sortable()
                    ->color(fn($record) => $record->isUnderWarranty() ? 'success' : 'danger')
                    ->badge()
                    ->formatStateUsing(fn($record) => $record->isUnderWarranty() ? 'Valid until ' . $record->warranty_end_date->format('M d, Y') : 'Expired'),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSoldProducts::route('/'),
            'create' => Pages\CreateSoldProduct::route('/create'),
            'edit' => Pages\EditSoldProduct::route('/{record}/edit'),
        ];
    }
}
