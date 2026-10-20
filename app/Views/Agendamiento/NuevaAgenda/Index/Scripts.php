<script>
    // Función para formatear las fechas (hora:minuto)
    function formatTime(date) {
        const hours = date.getHours().toString().padStart(2, '0'); // Asegura que la hora tenga dos dígitos
        const minutes = date.getMinutes().toString().padStart(2, '0'); // Asegura que los minutos tengan dos dígitos
        return `${hours}:${minutes}`;
    }

    // Esperar que el DOM esté listo
    $(document).ready(function() {
        // Inicializar el calendario de Toast UI
        const calendar = new tui.Calendar('#calendar', {
            defaultView: 'week', // Usar vista semanal
            useCreationPopup: true, // Permitir la creación de eventos con el popup
            useDetailPopup: true, // Permitir la vista detallada de evento
            // Configurar el rango de horas visibles (8 AM a 6 PM)
            startHour: 8, // Inicia a las 8 AM
            endHour: 18, // Termina a las 6 PM

            // Evitar la visualización de eventos "allday" y "milestone"
            template: {
                time(event) {
                    const { start, end, title } = event;
                    return `<span style="color: white;">${formatTime(start)}~${formatTime(end)} ${title}</span>`;
                },
                // No necesitamos plantilla para "allday", no vamos a mostrarlo
                allday: () => '', // Esto asegura que no se muestren los eventos "allday"
            },

            calendars: [
                {
                    id: 'cal1',
                    name: 'Personal',
                    backgroundColor: '#03bd9e',
                },
                {
                    id: 'cal2',
                    name: 'Trabajo',
                    backgroundColor: '#00a9ff',
                },
            ],
        });

        // Opcional: Agregar eventos dinámicamente
        const eventos = [
            {
                id: '1',
                calendarId: 'cal1',
                title: 'Evento Personal 1',
                category: 'time', // Solo eventos de tipo "time"
                start: '2025-03-25T10:00:00',
                end: '2025-03-25T12:00:00',
            },
            {
                id: '2',
                calendarId: 'cal2',
                title: 'Evento de Trabajo 1',
                category: 'time', // Solo eventos de tipo "time"
                start: '2025-03-25T14:00:00',
                end: '2025-03-25T16:00:00',
            },
            {
                id: '3',
                calendarId: 'cal2',
                title: 'Evento fuera del rango',
                category: 'time', // Este evento está fuera del rango visible
                start: '2025-03-25T19:00:00', // Este evento está fuera del rango de 8:00 a 18:00
                end: '2025-03-25T20:00:00',
            },
        ];

        // Crear los eventos en el calendario
        calendar.createEvents(eventos);
    });
</script>