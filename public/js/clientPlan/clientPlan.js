Vue.config.debug = true

new Vue({
  el: '#app',
  data: {
    selectedPlan: '',
    days: '',
  },
  computed: {
    times: {
      cache: false,
      get: function () {
        var timesArray = [],
            times = $('[name="plan_id"] option:selected').data('times');

        for(var i = 0; i < times; i++) {
          timesArray[i] = times[i];
        }
        
        console.log(timesArray);
        
        return timesArray;
      }
    },
  }
})