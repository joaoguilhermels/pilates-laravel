Vue.component('class-professional-room', {
    template: '#class-professional-room-template',

    props: ['classes'],

    data: function() {
        return {
            selectedClassId: '',
            selectedClass: ''
        }
    },

    created () {
        this.classes = JSON.parse(this.classes);

        if (this.classes.length == 1) {
            this.selectedClass = this.classes[0];
        }
    },

    methods: {
        selectClass: function() {
            var self = this;
            this.classes.forEach(function(classType) {
                if (classType.id == self.selectedClassId) {
                    self.selectedClass = classType;
                }
            });
        }
    }
});

var vm = new Vue({
    el: '#app',
});
