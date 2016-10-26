@extends('layouts/app')

@include('calendar.partials.stylesheet')

@section('content')

  <div class="container-fluid" id="app">
    <h1>Agenda</h1>

    {!! $calendar->calendar() !!}
    <br><br>
    <!-- Access Token Modal -->
    <div class="modal fade" id="modal-options" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                    <h4 class="modal-title">
                        What would you like to schedule?
                    </h4>
                </div>

                <div class="modal-body">
                    <a href="/schedules/trial/create" class="btn btn-info">Trial Class</a>
                    <a href="/schedules/reposition/create" class="btn btn-info">Replacement</a>
                    <a href="/schedules/extra/create" class="btn btn-info">Extra Class</a>
                    <a href="" class="btn btn-info">Practice (no professional)</a>
                </div>

                <!-- Modal Actions -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
  </div>
  <schedule-update></schedule-update>

@stop

@include('calendar.partials.script')
