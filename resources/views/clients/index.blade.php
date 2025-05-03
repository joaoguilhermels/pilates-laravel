@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>
      Clients
      &nbsp;&nbsp;&nbsp;
      <a href="{{ route('clients.create') }}" class="btn btn-success"><i class="fa fa-plus"></i> Add New Client</a>
    </h1>

    <hr />

    @if ($clients->total() == 0)
      <h2>There are no clients yet. You can <a href="{{ route('clients.create') }}">add one here.</a></h2>
    @else
      <div class="well well-sm">
        <form action="{{ route('clients.index') }}" method="GET" class="form-inline">
          <fieldset>
            <div class="form-group">
              <label class="sr-only" for="name">Name</label>
              <input type="text" name="name" value="{{ $name }}" class="form-control" placeholder="Name">
            </div>
            <div class="form-group">
              <button type="submit" value="search" class="btn btn-default"><i class="fa fa-search"></i> Search</button>
            </div>
          </fieldset>
        </form>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Name</th>
              <th>E-mail</th>
              <th class="text-center">Reposições</th>
              <th>Plans</th>
              <th></th>
              <th></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            @forelse ($clients as $client)
              <tr>
                <td>
                  <a href="{{ route('clients.show', $client) }}">{{ $client->name }}</a>
                  @if (!empty($client->phone))
                    <br><small>{{ $client->phone }}</small>
                  @endif
                </td>
                <td>{{ $client->email }}</td>
                <td class="text-center">
                  @if($client->schedules->count() > 0)
                    {{ $client->schedules->count() }} aula(s) desmarcada(s)
                    <ul class="list">
                      @foreach($client->schedules as $schedule)
                        <li><a href="{{ route('schedules.edit', $schedule) }}">{{ $schedule->start_at }}</a></li>
                      @endforeach
                    </ul>
                  @else
                    0
                  @endif
                </td>
                <td>
                  {{ count($client->clientPlans) }}
                </td>
                <td>
                  <a href="{{ route('clients.plans.create', $client) }}">Create Plan</a>
                </td>
                <td>
                  <a href="{{ route('clients.edit', $client) }}">
                    <i class="fa fa-pencil"></i> Edit
                  </a>
                </td>
                <td>
                  <form action="{{ route('clients.destroy', $client) }}" method="POST" data-confirm="Are you sure you want to delete this client?">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-link"><i class="fa fa-remove"></i> Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7">No results found</td>
              </tr>
            @endforelse
          </tbody>
        </table>

        <div class="text-center">
          {{ $clients->links() }}
        </div>
      </div>
    @endif
  </div>
@endsection
