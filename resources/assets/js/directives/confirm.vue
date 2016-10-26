<script>
export default {
    params: ['message'],

    bind: function () {
        this.el.addEventListener(
            'submit', this.onSubmit.bind(this)
        );
    },

    onSubmit: function (e) {

        
        //this.params.message

        e.preventDefault();
    },
}
</script>