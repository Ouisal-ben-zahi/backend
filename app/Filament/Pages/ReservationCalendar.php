<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Reservation;

class ReservationCalendar extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-calendar';
    protected static ?string $title = 'Calendrier des Réservations';
    protected static ?string $navigationLabel = 'Calendrier';
    protected static ?string $navigationGroup = 'Gestion des Réservations';
    protected static string $view = 'filament.pages.reservation-calendar';

    public $events = [];

    public function mount(): void
    {
        $this->events = Reservation::all()->map(function ($reservation) {
            return [
                'title' => $reservation->client_name,
                'start' => $reservation->visit_date,
                'color' => $this->getEventColor($reservation->status),
                'url'   => route('filament.resources.reservations.edit', $reservation),
            ];
        })->toArray();
    }

    private function getEventColor($status)
    {
        return match ($status) {
            'pending'   => '#facc15',
            'confirmed' => '#22c55e',
            'cancelled' => '#ef4444',
            'completed' => '#3b82f6',
            default     => '#9ca3af',
        };
    }
}
