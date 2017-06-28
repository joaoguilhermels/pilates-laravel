@extends('layouts/admin/admin')

@include('calendar.partials.stylesheet')

@section('content')

<div class="container-fluid" id="app">
    {{-- <h1>Agenda</h1> --}}

    {{-- {!! $calendar->calendar() !!} --}}
    <calendar url="/calendar/data"></calendar>
    <br><br>
        
    <modal>
        <h4 slot="modal-title">O que você gostaria de agendar?</h4>
        <div class="modal-body" slot="modal-body">
            <a href="/schedules/create" class="btn btn-info">Atendimento</a>
            @if ($has_available_trial_class)
            <a href="/schedules/trial/create" class="btn btn-info">Aula experimental</a>
            @endif
            <a href="/schedules/reposition/create" class="btn btn-info">Reposição</a>
            <a href="/schedules/extra/create" class="btn btn-info">Aula extra</a>
            <a href="" class="btn btn-info">Prática (sem profissional)</a>
        </div>
    </modal>
</div>
@stop

@include('calendar.partials.script')
