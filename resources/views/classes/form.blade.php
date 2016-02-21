<?php
//dd($statuses);
?>
<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('max_number_of_clients', 'Max Number of Clients: ') !!}
  {!! Form::text('max_number_of_clients', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('duration', 'Duration (Mins): ') !!}
  {!! Form::text('duration', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  @if (count($statuses) == 0)
    empty
  @else
    <div class="table-responsive">
      <table class="table">
        <thead>
          <tr>
            <th>Status</th>
            <th>Charge Client?</th>
            <th>Pay Professional?</th>
            <th>Color</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($statuses as $status)
          <tr>
            <td>{!! Form::text('status_name[]', $status->name, ['class' => 'form-control']) !!}</td>
            <td>{!! Form::checkbox('charge_client[]', $status->charge_client, $status->charge_client, ['class' => 'form-control']) !!}</td>
            <td>{!! Form::checkbox('pay_professional[]', $status->pay_professional, $status->pay_professional, ['class' => 'form-control']) !!}</td>
            <td>{!! Form::input('color[]', 'color', $status->color, null, ['class' => 'form-control']) !!}</td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
  @endif
</div>

<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>