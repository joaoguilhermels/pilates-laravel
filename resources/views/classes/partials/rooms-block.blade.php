<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Rooms</h3>
  </div>
  <div class="panel-body">
    Rooms where this class can be given.
  </div>
  <div class="list-group">
  @foreach ($classType->rooms as $room)
    <a href="{{ action('RoomsController@edit', [$room->id]) }}" class="list-group-item">{{$room->name}}</a>
  @endforeach
  </div>
</div>