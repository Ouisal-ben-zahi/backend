<x-filament::page class="filament-dashboard-page">
    <x-filament::widgets
        :widgets="[
          \App\Filament\Widgets\PropertyStats::class,
          \App\Filament\Widgets\ReservationCalendar::class,
            \App\Filament\Widgets\PropertyChart::class,

        ]"
        :columns="$this->getColumns()"
    />
</x-filament::page>
