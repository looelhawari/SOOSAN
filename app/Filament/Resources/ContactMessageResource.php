<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactMessageResource\Pages;
use App\Filament\Resources\ContactMessageResource\RelationManagers;
use App\Models\ContactMessage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactMessageResource extends Resource
{
    protected static ?string $model = ContactMessage::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationLabel = 'Contact Messages';

    protected static ?string $navigationGroup = 'Communication';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Information')
                    ->schema([
                        Forms\Components\TextInput::make('first_name')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(['sm' => 1]),
                        Forms\Components\TextInput::make('last_name')
                            ->required()
                            ->maxLength(100)
                            ->columnSpan(['sm' => 1]),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('company')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->maxLength(50),
                    ])
                    ->columns(['sm' => 2]),

                Forms\Components\Section::make('Message Details')
                    ->schema([
                        Forms\Components\Select::make('subject')
                            ->options([
                                'sales' => 'Sales Inquiry',
                                'support' => 'Technical Support',
                                'parts' => 'Parts & Service',
                                'warranty' => 'Warranty Claim',
                                'other' => 'Other',
                            ])
                            ->required(),
                        Forms\Components\Textarea::make('message')
                            ->required()
                            ->rows(5),
                        Forms\Components\Toggle::make('newsletter')
                            ->label('Subscribed to newsletter'),
                        Forms\Components\Toggle::make('is_read')
                            ->label('Marked as read'),
                        Forms\Components\DateTimePicker::make('read_at')
                            ->label('Read at')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('created_at')
                            ->label('Submitted at')
                            ->disabled()
                            ->dehydrated(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Name')
                    ->searchable(['first_name', 'last_name'])
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('subject')
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'sales' => 'Sales Inquiry',
                        'support' => 'Technical Support',
                        'parts' => 'Parts & Service',
                        'warranty' => 'Warranty Claim',
                        'other' => 'Other',
                        default => $state,
                    })
                    ->colors([
                        'primary' => 'sales',
                        'success' => 'support',
                        'warning' => 'parts',
                        'danger' => 'warranty',
                        'gray' => 'other',
                    ])
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Read')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-envelope')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('subject')
                    ->options([
                        'sales' => 'Sales Inquiry',
                        'support' => 'Technical Support',
                        'parts' => 'Parts & Service',
                        'warranty' => 'Warranty Claim',
                        'other' => 'Other',
                    ]),
                Tables\Filters\Filter::make('unread')
                    ->label('Unread Only')
                    ->toggle()
                    ->query(fn(Builder $query): Builder => $query->where('is_read', false)),
            ])
            ->actions([
                Tables\Actions\Action::make('mark_as_read')
                    ->label('Mark as Read')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->visible(fn(ContactMessage $record) => !$record->is_read)
                    ->action(function (ContactMessage $record) {
                        $record->markAsRead();
                    })
                    ->after(function () {
                        return Tables\Actions\Action::make('success')
                            ->name('Success')
                            ->color('success');
                    }),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('mark_as_read')
                        ->label('Mark as Read')
                        ->icon('heroicon-o-check')
                        ->action(function ($records) {
                            foreach ($records as $record) {
                                if (!$record->is_read) {
                                    $record->markAsRead();
                                }
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
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
            'index' => Pages\ListContactMessages::route('/'),
            'view' => Pages\ViewContactMessage::route('/{record}'),
        ];
    }
}
