<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('model_number')
                            ->maxLength(255),
                        Forms\Components\Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3),
                        Forms\Components\TextInput::make('price')
                            ->numeric()
                            ->prefix('$')
                            ->step(0.01),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Specifications (SI Units)')
                    ->schema([
                        Forms\Components\TextInput::make('body_weight')
                            ->numeric()
                            ->suffix('kg')
                            ->step(0.01),
                        Forms\Components\TextInput::make('operating_weight')
                            ->numeric()
                            ->suffix('kg')
                            ->step(0.01),
                        Forms\Components\TextInput::make('overall_length')
                            ->numeric()
                            ->suffix('mm')
                            ->step(0.01),
                        Forms\Components\TextInput::make('overall_width')
                            ->numeric()
                            ->suffix('mm')
                            ->step(0.01),
                        Forms\Components\TextInput::make('overall_height')
                            ->numeric()
                            ->suffix('mm')
                            ->step(0.01),
                        Forms\Components\TextInput::make('required_oil_flow')
                            ->suffix('l/min')
                            ->placeholder('20 ~ 40')
                            ->helperText('Enter single value or range (e.g., "20 ~ 40")'),
                        Forms\Components\TextInput::make('operating_pressure')
                            ->suffix('kgf/cm²')
                            ->placeholder('90 ~ 120')
                            ->helperText('Enter single value or range (e.g., "90 ~ 120")'),
                        Forms\Components\TextInput::make('impact_rate_std')
                            ->suffix('BPM')
                            ->placeholder('700 ~ 1,200')
                            ->helperText('Impact Rate (STD Mode)'),
                        Forms\Components\TextInput::make('impact_rate_soft_rock')
                            ->suffix('BPM')
                            ->placeholder('~')
                            ->helperText('Impact Rate (Soft Rock) - enter "~" if not applicable'),
                        Forms\Components\TextInput::make('hose_diameter')
                            ->suffix('in')
                            ->placeholder('3/8, 1/2')
                            ->helperText('Enter diameters separated by comma'),
                        Forms\Components\TextInput::make('rod_diameter')
                            ->numeric()
                            ->suffix('mm')
                            ->step(0.01),
                        Forms\Components\TextInput::make('applicable_carrier')
                            ->suffix('ton')
                            ->placeholder('1.2 ~ 3')
                            ->helperText('Enter single value or range (e.g., "1.2 ~ 3")'),
                    ])
                    ->columns(3),

                Forms\Components\Section::make('Media')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('images')
                            ->collection('images')
                            ->multiple()
                            ->reorderable()
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),
                        SpatieMediaLibraryFileUpload::make('documents')
                            ->collection('documents')
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf'])
                            ->columnSpanFull()
                            ->helperText('Upload PDF brochures, manuals, or documentation'),
                    ]),

                Forms\Components\Section::make('Status')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Whether this product is available/visible'),
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Featured')
                            ->helperText('Show this product on homepage'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->getStateUsing(fn($record) => $record->getFirstMediaUrl('images'))
                    ->size(50)
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('model_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
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
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->boolean(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
