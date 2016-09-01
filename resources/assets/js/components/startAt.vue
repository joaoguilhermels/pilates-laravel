<template id="start-at">
	<div class="form-group">
		<label for="start_at">Date:</label>
		<input id="datetimepicker" name="start_at" type="text">
	</div>
</template>
<script>
    export default {
        ready () {
			$('#datetimepicker').datetimepicker({
				format:'Y-m-d H:i:s',
				startDate: new Date(),
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