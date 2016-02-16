<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Classes</h3>
  </div>
  <div class="panel-body">
    Classes given by this professional.
  </div>
  <div class="list-group">
  @foreach ($professional->classTypes as $classType)
    <a href="{{ action('ClassTypesController@edit', [$classType->id]) }}" class="list-group-item">{{$classType->name}}</a>
  @endforeach
  </div>
</div>