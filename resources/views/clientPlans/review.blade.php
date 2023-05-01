@extends('layouts/app')

@section('content')
  <div class="container">
    <h1>Review {{ $client->name }}'s New Plan</h1>
    <hr />
    
    @include('errors.list')

    {!! Form::open(array('action' => array('ClientPlansController@store', $client->id))) !!}
      <input type="hidden" name="" value="{{ $client->id }}">
      <input type="hidden" name="classType" value="{{ $client->id }}">
      <input type="hidden" name="plan" value="{{ $plan->id }}">
      <input type="hidden" name="start_date" value="{{ $request['start_date'] }}">
      <div class="form-group">
        <h4>
          <strong>{{ $client->name }}</strong> is subscribing to the <strong>{{ $plan->name }}</strong> plan to do <strong>{{ $classType->name }}</strong>.
          Starting at <strong>{{ $request['start_date'] }}</strong>
        </h4>
      </div>    
      <div id="details" class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">Here are the dates of the classes:</h3>
        </div>
      
        <table class="table">
          @foreach($datesGrouped as $month => $dates)
          <tr class="bg-info">
            <td>
            <?php print $month;?>
            </td>
          </tr>
          @foreach($dates as $date)
          <tr>
            <td>
              <?php print $date; ?>
              <input type="hidden" name="dates[]" value="{{ $date }}">
            </td>
          </tr>
          @endforeach
          @endforeach
        </table>
      </div>
      
      <div class="form-group">
        <input class="btn btn-success form-control" type="submit" value="Add New Plan for this Client">
      </div>

    </form>
  </div>
@stop