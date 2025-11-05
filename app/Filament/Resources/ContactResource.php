<?php
namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;
    protected static ?string $navigationIcon = 'heroicon-o-mail';
    protected static ?string $navigationLabel = 'Contacts';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Support / Contact';

    /**
     * Pas de formulaire pour création/modification, uniquement consultation.
     */
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    /**
     * Tableau des contacts avec action "Répondre" et suppression du bouton "New Contact".
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('prenom')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('sujet')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Date'),
            ])
            ->actions([
                Tables\Actions\Action::make('repondre')
                    ->label('Répondre')
                    ->icon('heroicon-o-mail')
                    ->url(fn (Contact $record) => 
                        'https://mail.google.com/mail/?view=cm&fs=1&to=' 
                        . $record->email 
                        . '&su=' . urlencode('Réponse à votre message')
                        . '&bcc=ouissalbenzahi@gmail.com'
                    )
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(), // <-- ajoute le bouton "Supprimer"
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(), // <-- permet suppression en masse
            ])
            ->headerActions([]); // supprime le bouton "New Contact"
    }

    /**
     * Pas de relations spécifiques pour cette resource.
     */
    public static function getRelations(): array
    {
        return [];
    }

    /**
     * Seule la page index est disponible.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
        ];
    }
}
