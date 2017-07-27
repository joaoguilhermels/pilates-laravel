@extends('layouts/admin/admin')

@section('content')
  {{-- <div class="container"> --}}
    <h1>
      Planos
      &nbsp;&nbsp;&nbsp;
      <a href="{{ action('PlansController@create') }}" class="btn btn-success">Adicionar Novo Plano</a>
    </h1>

    <hr />

    @if (count($plans) == 0)

    <h2>
      Ainda não tem nenhum plano cadastrado. Você pode <a href="{{ action('PlansController@create') }}">adicionar um aqui.</a>
    </h2>

    @else

    <div class="table-responsive">
    <table class="table">
      <thead>
        <tr>
          <th>Atendimento</th>
          <th>Nome</th>
          <th>Preço</th>
          <th>Vezes</th>
          <th>Duração do Plano</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($plans as $plan)
        <tr>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->classType->name }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->name }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->price }} por {{ $plan->price_type }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->times }} por {{ $plan->times_type }}</a></td>
          <td><a href="{{ action('PlansController@show', [$plan->id]) }}">{{ $plan->duration }} {{ $plan->duration_type }}</a></td>
          <td>
            <a href="{{ action('PlansController@edit', [$plan->id]) }}" class="btn pull-left">editar</a>
            <form action="{{ action('PlansController@destroy', [$plan->id]) }}" method="post">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}
              <button type="submit" class="btn btn-link pull-left">apagar</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    </div>
    @endif
  {{-- </div> --}}
@stop
