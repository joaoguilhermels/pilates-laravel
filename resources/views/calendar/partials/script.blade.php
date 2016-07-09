@section('script_footer')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qtip2/3.0.2/jquery.qtip.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/fullcalendar.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/fullcalendar/2.8.0/lang/pt-br.js"></script>
  {!! $calendar->script() !!}
  <!-- template for the modal component -->
  <script type="x/template" id="modal-template">
    <div class="modal-mask" @click="close" v-show="show" transition="modal">

      <div class="modal-wrapper">
        <div class="modal-container" @click.stop>

          <div class="modal-header text-center">
            <h4>What would you like to schedule?</h4>
          </div>

          <div class="modal-body">
            <a href="schedules/trial/create" class="btn btn-info btn-block">Trial Class</a>
            <a href="schedules/reposition/create" class="btn btn-info btn-block">Replacement</a>
            <a href="schedules/extra/create" class="btn btn-info btn-block">Extra Class</a>
            <a href="" class="btn btn-info btn-block">Practice (no professional)</a>
          </div>

        </div>
      </div>
    </div>
  </script>
  <script>
    // register modal component
    Vue.component('modal', {
      template: '#modal-template',
      props: {
        show: {
          type: Boolean,
          required: true,
          twoWay: true
        },
        header: ''
      },
      methods: {
        close: function () {
            this.show = false;
        }
      },
      ready: function () {
        document.addEventListener("keydown", (e) => {
          if (this.show && e.keyCode == 27) {
            this.close();
          }
        });
      }
    })

    // start app
    var vm = new Vue({
      el: '#app',
      data: {
        showModal: false,
        headerTitle: '',
        showExtraClassModal: false,
        headerExtraClassTitle: ''
      },
      methods: {
        showModalNow: function (title) {
          this.showModal = true;
          this.headerTitle = title;
        }
      }
    })
  </script>
@stop
