<script>
export default {
    params: ['complete'],

    bind: function () {
        this.el.addEventListener(
            'submit', this.onSubmit.bind(this)
        );
    },

    onSubmit: function (e) {
        var requestType = this.getRequestType();

        this.vm
            .$http[requestType](this.el.action)
            .then(this.onComplete.bind(this))
            .catch(this.onError.bind(this));

        e.preventDefault();
    },

    onComplete: function () {
        if (this.params.complete) {
            console.log(this);
            alert(this.params.complete); // Use pretty flash message instead.
        }
    },

    onError: function (response) {
        alert(response.data.message); // Use pretty flash message instead.
    },

    getRequestType: function () {
        var method = this.el.querySelector('input[name="_method"]');

        return (method ? method.value : this.el.method).toLowerCase();
    },
}
</script>