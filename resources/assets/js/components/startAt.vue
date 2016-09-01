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
				inline: true
			});
			$.datetimepicker.setLocale('pt-BR');
        },
    }
</script>