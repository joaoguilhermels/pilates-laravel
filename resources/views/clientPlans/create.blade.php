@extends('layouts/app')


@section('content')
  <div class="container">
	  <h1>Associate a New Plan for {{ $client->name }}</h1>
	  <hr />
	  
	  @include('errors.list')

	  <form action="{{ action(ClientPlansController@store, [$client->id]) }}" method="POST">
	  	{{ csrf_field() }}
	    @include('clientPlans.form', ['submitButtonText' => 'Add New Plan for this Client'])
  	</form>
  </div>
@stop

@section('script_footer')
    <script src="/js/clientPlan/clientPlan.js"></script>
@stop