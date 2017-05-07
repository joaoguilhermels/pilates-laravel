@section('script_footer')
  <script src="//cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.3/jquery.qtip.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/locale/pt-br.js"></script>
  {!! $calendar->script() !!}
@stop
