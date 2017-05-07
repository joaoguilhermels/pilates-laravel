<template id="start-at">
	<div class="form-group">
		<input id="datetimepicker" name="start_at" type="text">
	</div>
</template>
<script>
    export default {
    	props: ['date', 'time', 'timepicker'],
        mounted () {
			var newDate = new Date();

			var day = newDate.getDay();
			var isWeekend = (day == 6) || (day == 0);    // 6 = Saturday, 0 = Sunday

			if (isWeekend) {
				newDate.setDate(newDate.getDate() + 1);
				newDate.setHours(newDate.getHours());
			}

			var day = newDate.getDay();
			var isWeekend = (day == 6) || (day == 0);    // 6 = Saturday, 0 = Sunday

			if (isWeekend) {
				newDate.setDate(newDate.getDate() + 1);
				newDate.setHours(newDate.getHours());
			}

			if (this.date !== undefined && this.time !== undefined) {
				var dateString = this.date + " " + this.time;
			}
			else {
				var dateString =
				  newDate.getFullYear() + "-" +
				  ("0" + (newDate.getMonth()+1)).slice(-2) + "-" +
				  ("0" + newDate.getDate()).slice(-2) + " " +
				  ("0" + newDate.getHours()).slice(-2) + ":" +
				  "00:00";
			}

			$('#datetimepicker').val(dateString);

			$('#datetimepicker').datetimepicker({
				format: 'Y-m-d H:i:00',
				formatDate: 'Y-m-d',
				defaultDate: this.date || newDate.getDate(),
				formatTime: 'H:i:00',
				defaultTime: this.time || newDate.getHours() + ":00:00",
				step: 15,
				inline: true,
				dayOfWeekStart: 1,
				timepicker: this.timepicker && true,
				scrollMonth: false,
				onGenerate: function(ct) {
					$(this).find('.xdsoft_date.xdsoft_weekend').remove();
					$('.xdsoft_calendar table thead tr th').filter(':nth-child(6), :nth-child(7)').remove();
				}
			});

			$.datetimepicker.setLocale('pt-BR');
        },
    }
</script>