<x-filament::page>
    <h1>Calendrier des Réservations</h1>
    <div id="calendar"></div>

    @push('scripts')
    <!-- FullCalendar CSS & JS -->
    <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.7/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.7/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.7/main.min.js'></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events),
            eventClick: function(info) {
                if(info.event.url) {
                    window.location.href = info.event.url;
                    info.jsEvent.preventDefault();
                }
            }
        });
        calendar.render();
    });
    </script>

    <style>
    #calendar {
        max-width: 1000px;
        margin: 40px auto;
    }
    </style>
    @endpush
</x-filament::page>
