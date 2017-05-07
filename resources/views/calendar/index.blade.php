@extends('layouts/admin/admin')

@include('calendar.partials.stylesheet')

@section('content')

<div class="container-fluid" id="app">
    {{-- <h1>Agenda</h1> --}}

    {!! $calendar->calendar() !!}
    <br><br>
        
    <modal>
        <h4 slot="modal-title">What would you like to schedule?</h4>
        <div class="modal-body" slot="modal-body">
            <a href="/schedules/trial/create" class="btn btn-info">Trial Class</a>
            <a href="/schedules/reposition/create" class="btn btn-info">Replacement</a>
            <a href="/schedules/extra/create" class="btn btn-info">Extra Class</a>
            <a href="" class="btn btn-info">Practice (no professional)</a>
        </div>
    </modal>
</div>
@stop

@include('calendar.partials.script')
