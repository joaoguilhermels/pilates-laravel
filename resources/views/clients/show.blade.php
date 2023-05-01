@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>{{ $client->name }}</h1>
    <a href="{{ action('ClientsController@index') }}">Back to Clients List</a>
    <br><br>

    <ul class="nav nav-tabs">
      <li class="active"><a data-toggle="tab" href="#info">Informações</a></li>
      <li><a data-toggle="tab" href="#planos">Planos</a></li>
    </ul>
    
    <div class="tab-content">
      <div id="info" class="tab-pane fade in active">
        <h3>Informações do Cliente </h3>
        <div class="row">
          <div class="col-md-12">
            <dl class="dl-horizontal">
              <dt>Phone:</dt>
              <dd>{{ $client->phone }}</dd>
            </dl>
            <dl class="dl-horizontal">
              <dt>E-mail:</dt>
              <dd>{{ $client->email }}</dd>
            </dl>
            <dl class="dl-horizontal">
              <dt>Observation:</dt>
              <dd>{{ $client->description }}</dd>
            </dl>        
            <a href="{{ action('ClientsController@edit', [$client->id]) }}" class="btn btn-block btn-success">Edit This Client</a>
          </div>
        </div>

      </div>
      @include('clients.partials.plans')
    </div>
  </div>
@stop