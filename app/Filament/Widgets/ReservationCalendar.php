<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class ReservationCalendar extends BaseWidget
{
    protected static ?string $heading = 'Réservations du jour';
    protected int|string|array $columnSpan = 'full';

    /**
     * Récupère uniquement les réservations du jour
     */
    protected function getTableQuery(): Builder
    {
        return Reservation::query()
            ->whereDate('visit_date', Carbon::today())
            ->orderBy('visit_date', 'asc');
    }

    /**
     * Colonnes à afficher dans le tableau du widget
     */
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('property.title')
                ->label('Propriété')
                ->searchable()
                ->sortable(),

            Tables\Columns\TextColumn::make('client_name')
                ->label('Client')
                ->searchable(),

            Tables\Columns\TextColumn::make('client_phone')
                ->label('Téléphone')
                ->toggleable(),

            Tables\Columns\TextColumn::make('visit_date')
                ->label('Heure de visite')
                ->dateTime('H:i')
                ->sortable(),

            Tables\Columns\BadgeColumn::make('status')
                ->label('Statut')
                ->colors([
                    'warning' => 'pending',
                    'success' => 'confirmed',
                    'danger' => 'cancelled',
                    'gray' => 'completed',
                ])
                ->formatStateUsing(fn(string $state): string => match ($state) {
                    'pending' => 'En attente',
                    'confirmed' => 'Confirmée',
                    'cancelled' => 'Annulée',
                    'completed' => 'Terminée',
                    default => ucfirst($state),
                }),
        ];
    }

    /**
     * Optionnel : message si aucune réservation
     */
    protected function getTableEmptyStateHeading(): ?string
    {
        return 'Aucune réservation pour aujourd’hui';
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return 'Il n’y a pas de visites prévues pour la journée.';
    }
}
