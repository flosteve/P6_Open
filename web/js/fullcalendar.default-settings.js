$(function () {
    $('#calendar-holder').fullCalendar({
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, agendaWeek, agendaDay,'
        },
        locale: 'fr',
        buttonText: {
            year: "Année",
            month: "Mois",
            week: "Semaine",
            day: "Jour",
            list: "Mon planning",
            today: "Aujourd'hui"
        },
        timezone: ('Europe/Paris'),
        businessHours: {
            start: '08:00',
            end: '18:00',
            dow: [1, 2, 3, 4, 5]
        },
        firstDay: 1,
        minTime: '06:00:00',
        maxTime: '22:00:00',
        slotDuration: '01:00:00',
        slotLabelFormat: 'H:mm',
        selectable: true,
        lazyFetching: true,
        editable: true,
        eventDurationEditable: true,
        timeFormat: {
            agenda: 'H:mm',
            '': 'H:mm'
        },
        eventSources: [
            {
                url: '/full-calendar/load',
                type: 'POST',
                dataType: "json",
                success: function (data) {

                },
                error: function(xhr){
                    alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
                }
            }
        ],
        eventRender: function (event, element) {
            moment.locale();

            element.find('.fc-time').html(moment(event.start).format('LT') + "-" + moment(event.end).format('LT'));
        }
    });
});
