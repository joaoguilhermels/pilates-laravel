<template id="calendar-template">
  <div id="fullcalendar"></div>
</template>

<script>
    export default {
        props: ['classes', 'url'],

        data: function() {
            return {
                selectedClassId: '',
                selectedClass: '',
                classesList: []
            }
        },

        methods: {
          scheduleDescription: function() {
            return "Description";
          },
        },

        mounted () {
            $('#fullcalendar').fullCalendar({
                events: {
                    url: this.url,//'/calendar/group/data',
                    color: 'yellow',   // an option!
                    textColor: 'black' // an option!
                },
                allDaySlot: false,
                defaultView: 'agendaWeek', // Add custom option
                weekends: false, // Add custom option
                businessHours: {
                  start: '07:00',
                  end: '20:30',
                  //'dow' => array(1, 2, 3, 4, 5)
                },
                nowIndicator: true,
                minTime: '06:30:00',
                maxTime: '21:00:00',
                contentHeight: 'auto',
                slotEventOverlap: false,
                locale: 'pt-BR',
                eventLimit: false,
                navLinks: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay,listWeek',
                },

                dayClick: function (date, jsEvent, view) {
                    $('#modal').on('show.bs.modal', function (event) {
                        var modal = $(this);
                        modal.find('.modal-title').text("O que você gostaria de agendar?");
                        modal.find('.modal-body').html(
                            "<a href=\"/schedules/create\" class=\"btn btn-info\">Atendimento</a>" +
                            "<a href=\"/schedules/trial/create\" class=\"btn btn-info\">Aula experimental</a>" +
                            "<a href=\"/schedules/reposition/create\" class=\"btn btn-info\">Reposição</a>" +
                            "<a href=\"/schedules/extra/create\" class=\"btn btn-info\">Aula extra</a>" +
                            "<a href=\"\" class=\"btn btn-info\">Prática (sem profissional)</a>"
                        );
                    });

                    $('#modal').modal('show');
                },
                eventClick: function(calEvent, jsEvent, view) {
                    $('#modal').on('show.bs.modal', function (event) {
                        var modal = $(this);
                        modal.find('.modal-title').text(calEvent.title);
                        modal.find('.modal-body').html(
                            "Professional: " + calEvent.professional_name +
                            "<br>Room: " + calEvent.room_name +
                            "<br>Class Type: " + calEvent.class_type_name
                        );
                    });

                    $('#modal').modal('show');
                },
                eventRender: function(event, element) {
                    var ntoday = Math.round(new Date().getTime() / 1000),
                        eventEnd = event.end.unix(),
                        eventStart = event.start.unix();

                    if (eventEnd < ntoday){
                        element.addClass('past-event');
                    }

                    element.qtip({
                        prerender: true,
                        content: {
                            text: '<i class="fa fa-refresh fa-spin" style="font-size:20px"></i>', // The text to use whilst the AJAX request is loading
                            ajax: {
                                url: '/schedules/' + event.start.unix() + '/' + event.room_id + '/group', // URL to the local file
                                type: 'GET', // POST or GET
                            }
                        },
                        position: {
                                at: 'top left',
                                my: 'bottom right',
                                target: 'mouse',
                                viewport: $('#fullcalendar'),
                                adjust: {
                                    mouse: true,
                                    scroll: true
                                },
                            method: 'none shift'
                            },
                            style: {
                            classes: 'qtip-bootstrap qtip-shadow'
                        }
                    });
                    element.find('div.fc-title').html(element.find('div.fc-title').text());
                    element.find('span.fc-title').html(element.find('span.fc-title').text());
                },
            });
        },
    }
</script>