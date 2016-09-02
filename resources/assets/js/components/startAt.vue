<template id="start-at">
	<div class="form-group">
		<label for="start_at">Date:</label>
		<input id="datetimepicker" name="start_at" type="text">
	</div>
</template>
<script>
    export default {
        ready () {
			var newDate = new Date();
			var dateString =
			  newDate.getFullYear() +"/"+
			  ("0" + (newDate.getMonth()+1)).slice(-2) +"/"+
			  ("0" + newDate.getDate()).slice(-2) + " " +
			  ("0" + newDate.getHours()).slice(-2) + ":" +
			  ("0" + newDate.getMinutes()).slice(-2) + ":" +
			  "00";
			$('#datetimepicker').val(dateString);

			$('#datetimepicker').datetimepicker({
				format: 'Y-m-d H:i:s',
				startDate: newDate,
				inline: true,
				dayOfWeekStart: 1,
				onGenerate: function(ct) {
					$(this).find('.xdsoft_date.xdsoft_weekend').remove();
					$('.xdsoft_calendar table thead tr th').filter(':nth-child(6), :nth-child(7)').remove();
				}
			});
			$.datetimepicker.setLocale('pt-BR');
        },
    }
</script>