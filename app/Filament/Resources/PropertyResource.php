<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Models\Property;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-home';
    protected static ?string $navigationGroup = 'Gestion Immobilière';
    protected static ?string $modelLabel = 'Propriété';
    protected static ?string $pluralModelLabel = 'Propriétés';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informations générales')->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Titre')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('purpose')
                    ->label('Objectif')
                    ->options([
                        'sell' => 'Vente',
                        'rent' => 'Location',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('category')
                    ->label('Catégorie')
                    ->placeholder('Appartement, Maison, Terrain...')
                    ->required(),

                Forms\Components\TextInput::make('price')
                    ->label('Prix')
                    ->numeric()
                    ->required(),

                Forms\Components\TextInput::make('currency')
                    ->default('MAD')
                    ->label('Devise'),

                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(3),
            ])->columns(2),

            Forms\Components\Section::make('Détails techniques')->schema([
                Forms\Components\TextInput::make('bedrooms')->numeric()->label('Chambres'),
                Forms\Components\TextInput::make('bathrooms')->numeric()->label('Salles de bain'),
                Forms\Components\TextInput::make('kitchen')->numeric()->label('Cuisines'),
                Forms\Components\TextInput::make('area_m2')->numeric()->label('Superficie (m²)'),
                Forms\Components\TextInput::make('location')->label('Emplacement'),

                Forms\Components\Select::make('status')
                    ->label('Statut')
                    ->options([
                        'published' => 'Publié',
                        'draft' => 'Brouillon',
                    ])
                    ->default('draft'),

                Forms\Components\TextInput::make('reference_code')
                    ->label('Code Référence')
                    ->unique(ignoreRecord: true)
                    ->required(),
            ])->columns(2),

            Forms\Components\Section::make('Images')->schema([
                Forms\Components\FileUpload::make('images')
                    ->label('Galerie d’images')
                    ->multiple()
                    ->directory('properties')
                    ->image()
                    ->maxFiles(5)
                    ->preserveFilenames() // ✅ évite erreur et garde le nom original
                    ->enableReordering(), // ✅ nouvelle syntaxe Filament v3
                    
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Titre')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('purpose')->label('Objectif')->sortable(),
                Tables\Columns\TextColumn::make('category')->label('Catégorie'),
                Tables\Columns\TextColumn::make('price')->label('Prix')->money('mad', true),
                Tables\Columns\TextColumn::make('location')->label('Emplacement'),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Statut')
                    ->colors([
                        'success' => 'published',
                        'warning' => 'draft',
                    ]),
                Tables\Columns\TextColumn::make('reference_code')->label('Référence')->copyable(),
                Tables\Columns\TextColumn::make('created_at')->label('Créé le')->dateTime('d/m/Y'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('purpose')
                    ->label('Type')
                    ->options([
                        'sell' => 'Vente',
                        'rent' => 'Location',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Statut')
                    ->options([
                        'published' => 'Publié',
                        'draft' => 'Brouillon',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Modifier'),
                Tables\Actions\DeleteAction::make()->label('Supprimer'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('Supprimer la sélection'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}