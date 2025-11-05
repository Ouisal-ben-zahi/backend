<x-filament::page>
    <div class="text-center mb-6">
        <p class="text-gray-500 mt-1">Visualisez et gérez vos réservations en un coup d’œil</p>
    </div>

    <div wire:ignore id="calendar" class="rounded-2xl shadow-md bg-white p-4"></div>

    @once
        @push('styles')
            <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
            <style>
                :root {
                    --calendar-primary: #CE9C5E;
                    --calendar-bg: #ffffff;
                    --calendar-border: #e5e7eb;
                }

                #calendar {
                    max-width: 1100px;
                    margin: 0 auto;
                }

                .fc {
                    background: var(--calendar-bg);
                    padding: 1rem;
                    border: 1px solid var(--calendar-border);
                }

                .fc-toolbar-title {
                    font-size: 32px !important;
                    font-weight: 400;
                    color: #1f2937;
                    white-space: normal;
                    text-align: center;
                }

                .fc-button {
                    background: var(--calendar-primary);
                    border: none;
                    padding: 6px 14px;
                    font-weight: 500;
                    color: white;
                    transition: all 0.2s ease-in-out;
                    margin: 2px;
                }

                .fc-button:hover {
                    background: #b57f46;
                    transform: scale(1.03);
                }

                /* MOBILE ULTRA-FRIENDLY : toolbar vertical */
                @media (max-width: 640px) {
                    .fc-header-toolbar {
                        display: flex !important;
                        flex-direction: column !important;
                        align-items: center;
                        gap: 0.5rem;
                    }

                    /* Tous les chunks deviennent full-width */
                    .fc-header-toolbar .fc-toolbar-chunk {
                        width: 100% !important;
                        text-align: center;
                        margin-bottom: 0.5rem;
                    }

                    /* Boutons prev/next/today et boutons de vue en bloc */
                    .fc-header-toolbar .fc-button-group {
                        display: flex !important;
                        flex-direction: column !important;
                        width: 100%;
                    }

                    .fc-header-toolbar .fc-button-group .fc-button {
                        width: 100% !important;
                        margin: 4px 0 !important;
                    }

                    /* Titre centré et ajusté */
                    .fc-toolbar-title {
                        font-size: 1.25rem;
                        margin-bottom: 0.5rem;
                    }
                }
            </style>
        @endpush

        @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.8/locales-all.global.min.js"></script>
            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const calendarEl = document.getElementById("calendar");
                    if (!calendarEl) return;

                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: "dayGridMonth",
                        locale: "fr",
                        height: "auto",
                        firstDay: 1,
                        buttonText: {
                            today: "Aujourd’hui",
                            month: "Mois",
                            week: "Semaine",
                            day: "Jour",
                            list: "Liste"
                        },
                        headerToolbar: {
                            left: "prev,next today",
                            center: "title",
                            right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek"
                        },
                        events: @json($events),
                        eventClick: function(info) {
                            if (info.event.url) {
                                window.open(info.event.url, "_self");
                                info.jsEvent.preventDefault();
                            }
                        },
                        navLinks: true,
                        dayMaxEvents: true
                    });

                    calendar.render();
                });
            </script>
        @endpush
    @endonce
</x-filament::page>
