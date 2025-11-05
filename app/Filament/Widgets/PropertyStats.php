<?php

namespace App\Filament\Widgets;

use App\Models\Property;
use App\Models\User; // <-- importer le modèle User
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PropertyStats extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make('Total des Propriétés', Property::count())
                ->description('Toutes les propriétés enregistrées')
                ->icon('heroicon-o-home')
                ->color('primary'),

            Card::make('Propriétés Publiées', Property::where('status', 'published')->count())
                ->description('Actuellement visibles en ligne')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Card::make('Propriétés en Brouillon', Property::where('status', 'draft')->count())
                ->description('En attente de publication')
                ->icon('heroicon-o-document')
                ->color('warning'),

            Card::make('En Vente', Property::where('purpose', 'sell')->count())
                ->description('Disponibles à la vente')
                ->icon('heroicon-o-currency-dollar')
                ->color('info'),

            Card::make('En Location', Property::where('purpose', 'rent')->count())
                ->description('Disponibles à la location')
                ->icon('heroicon-o-key')
                ->color('secondary'),

            // 6ᵉ carte : nombre d'utilisateurs
            Card::make('Nombre d’Utilisateurs', User::count())
                ->description('Total des utilisateurs enregistrés')
                ->icon('heroicon-o-users')
                ->color('success'),
        ];
    }
}
