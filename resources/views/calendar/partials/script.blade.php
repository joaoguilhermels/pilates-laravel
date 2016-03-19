@section('script_footer')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.2/jquery.qtip.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.6.1/fullcalendar.min.js"></script>
  {!! $calendar->script() !!}
@stop