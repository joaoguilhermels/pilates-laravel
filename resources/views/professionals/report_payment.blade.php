@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-10 col-md-offset-1">
        <h1>{{ $professional->name }}</h1>
        <a href="{{ action('ProfessionalsController@index') }}">Back to Professionals List</a>
        <hr />

        <div class="table-responsive">
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Client</th>
                <th>Date</th>
                <th>Full Price</th>
                <th>Professional Receives</th>
                <th>Status</th>
                <th>Room</th>
                <th>Class</th>
                <th>Plan</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>{{ $total }}</td>
                <td>{{ $professional_total }}</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
            </tfoot>
            <tbody>
            @foreach($rows as $row)
              <tr>
                <td>
                  {{ $row->client->name }}
                </td>
                <td>
                  {{ $row->start_at }}
                </td>
                <td>
                  {{ $row->price }}
                </td>
                <td>
                  @if($row->classTypeStatus->pay_professional)
                    {{ $row->value_professional_receives }}
                    @if ($row->value_professional_receives > 0)
                      (=
                      {{ $professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value }}
                      @if($professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value_type == 'percentage')
                        %
                      @else
                        {{ $professional->classTypes()->where('id', $row->class_type_id)->first()->pivot->value_type }}
                      @endif
                      )
                    @endif
                  @else
                    0
                  @endif
                </td>
                <td>
                  {{ $row->classTypeStatus->name }}
                </td>
                <td>
                  {{ $row->room->name }}
                </td>
                <td>
                  {{ $row->classType->name }}
                </td>
                <td>
                  {{-- TODO: Include logic to show extra class  --}}
                  @if ($row->trial == true)
                    Trial
                  @else
                    {{ $row->clientPlanDetail != null ? $row->clientPlanDetail->clientPlan->plan->name : "" }}
                  @endif
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>

        <form action="/professionals/{{ $professional->id }}/payments/store" method="POST">
          {{ csrf_field() }}
          <input type="hidden" name="startAt" value="{{ $startAt }}">
          <input type="hidden" name="endAt" value="{{ $endAt }}">
          <div class="form-group">
            <label for="professional">Payment Method: </label>
            <select class="form-control" name="payment_method_id">
              @foreach($paymentMethods as $paymentMethod)
              <option value="{{ $paymentMethod->id }}" {{ (old('paymentMethod') == $paymentMethod->id ? "selected" : "") }}>{{ $paymentMethod->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Bank Account: </label>
            <select class="form-control" name="bank_account_id">
              @foreach($bankAccounts as $bankAccount)
              <option value="{{ $bankAccount->id }}" {{ (old('bankAccount') == $bankAccount->id ? "selected" : "") }}>{{ $bankAccount->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Payment Date: </label>
            <input class="form-control" name="date" type="date" value="{{ old('date') }}" id="end_at">
          </div>
          <div class="form-group">
            <label for="name">Value: </label>
            <input class="form-control" name="value" type="number" min="0" step="any" value="{{ old('value') }}" id="end_at">
          </div>
          <div class="form-group">
            <label for="name">Observation: </label>
            <textarea name="observation" class="form-control" value="{{ old('observation  ') }}" rows="4"></textarea>
          </div>

          <div class="form-group">
            <input class="btn btn-success form-control" type="submit" value="Register Professional Payment">
          </div>
        </form>

          <!-- app -->
        <div id="app">
          <new-post-modal :show.sync="showNewPostModal"></new-post-modal>
          <button @click="showNewPostModal = true">Register Payment</button>
        </div>
        <br>
      </div>
    </div>
  </div>

  <style>
    * {
        box-sizing: border-box;
    }

    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        transition: opacity .3s ease;
    }

    .modal-container {
        width: 60%;
        margin: 40px auto 0;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .33);
        transition: all .3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .text-right {
        text-align: right;
    }

    .form-label {
        display: block;
        margin-bottom: 1em;
    }

    .form-label > .form-control {
        margin-top: 0.5em;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 0.5em 1em;
        line-height: 1.5;
        border: 1px solid #ddd;
    }

    .modal-enter, .modal-leave {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }
  </style>

  <!-- template for the Modal component -->
  <script type="x/template" id="modal-template">
      <div class="modal-mask" @click="close" v-show="show" transition="modal">
          <div class="modal-container" @click.stop>
              <slot></slot>
          </div>
      </div>
  </script>

  <!-- template for the NewPostModal component -->
  <script type="x/template" id="new-post-modal-template">
      <modal :show.sync="show" :on-close="close">
          <div class="modal-header">
              <h3>New Post</h3>
          </div>

          <div class="modal-body">
              <label class="form-label">
                  Title
                  <input v-model="title" class="form-control">
              </label>
              <label class="form-label">
                  Body
                  <textarea v-model="body" rows="5" class="form-control"></textarea>
              </label>
          </div>

          <div class="modal-footer text-right">
              <button class="modal-default-button" @click="savePost()">
                  Save
              </button>
          </div>
      </modal>
  </script>
@stop

@section('script_footer')
  <script type="text/javascript">
    Vue.component('Modal', {
      template: '#modal-template',
      props: ['show', 'onClose'],
      methods: {
        close: function () {
            this.onClose();
        }
      },
      ready: function () {
        document.addEventListener("keydown", (e) => {
          if (this.show && e.keyCode == 27) {
            this.onClose();
          }
        });
      }
    });

    Vue.component('NewPostModal', {
      template: '#new-post-modal-template',
      props: ['show'],
      data: function () {
      	return {
        	title: '',
          body: ''
        };
      },
      methods: {
        close: function () {
          this.show = false;
          this.title = '';
          this.body = '';
        },
        savePost: function () {
          // Insert AJAX call here...
          console.log(this);
          this.close();
        }
      }
    });

    new Vue({
      el: '#app',
      data: {
        showNewPostModal: false,
        showNewCommentModal: false
      }
    });
  </script>

@stop
