<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Professionals</h3>
  </div>
  <div class="panel-body">
    List of professionals giving this class.
  </div>
  <div class="list-group">
  @foreach ($classType->professionals as $professional)
    <a href="{{ action('ProfessionalsController@edit', [$professional->id]) }}" class="list-group-item">{{$professional->name}}</a>
  @endforeach
  </div>
</div>