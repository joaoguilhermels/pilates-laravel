@section('script_footer')
  <script src="//cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.2/jquery.qtip.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/fullcalendar.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.9.1/lang/pt-br.js"></script>
  {!! $calendar->script() !!}
@stop
