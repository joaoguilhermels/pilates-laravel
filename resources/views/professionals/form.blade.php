<?php
  //dd(get_defined_vars());
?>
<div class="form-group">
  {!! Form::label('name', 'Name: ') !!}
  {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('phone', 'Phone: ') !!}
  {!! Form::text('phone', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
  {!! Form::label('email', 'E-mail: ') !!}
  {!! Form::email('email', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
  {!! Form::label('class_type_list', 'Classes given by the professional: ') !!}
  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <td>Class</td>
          <td>Value</td>
          <td>Type</td>
        </tr>
      </thead>
      <tbody>
        @foreach($classTypes as $id => $classType)
        <tr>
          <td>
            {!! Form::checkbox('class_type_list[]', $id, $classTypes) !!}
            {!! Form::label('class_type_list[]', $classType) !!}
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="form-group">
  {!! Form::submit($submitButtonText, ['class' => 'btn btn-primary form-control']) !!}
</div>