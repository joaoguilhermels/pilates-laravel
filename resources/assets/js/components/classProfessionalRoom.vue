<template id="class-professional-room-template">
  <div>
    <div class="form-group">
      <label for="class_type_id">Class: </label>
      <select name="class_type_id" class="form-control" v-model="selectedClassId" v-on:change="selectClass" v-if="classes.length > 1">
        <option value=""></option>
        <option v-for="classType in classes" v-bind:value="classType.id">{{ classType.name }}</option>
      </select>
      <div v-else>
        {{ classes[0].name }}
        <input type="hidden" name="class_type_id" v-bind:value="classes[0].id" v-model="selectedClassId">
      </div>
    </div>
    <div class="form-group" v-if="selectedClass">
      <label for="professional_id">Professional: </label>
      <select name="professional_id" class="form-control" v-if="selectedClass.professionals.length > 1">
        <option value=""></option>
        <option v-for="professional in selectedClass.professionals" v-bind:value="professional.id">{{ professional.name }}</option>
      </select>
      <div v-else>
        {{ selectedClass.professionals[0].name }}
        <input type="hidden" name="professional_id" v-bind:value="selectedClass.professionals[0].id">
      </div>
    </div>
    <div class="form-group" v-if="selectedClass">
      <label for="room_id">Room: </label>
      <select name="room_id" class="form-control" v-if="selectedClass.rooms.length > 1">
        <option value=""></option>
        <option v-for="room in selectedClass.rooms" v-bind:value="room.id">{{ room.name }}</option>
      </select>
      <div v-else>
        {{ selectedClass.rooms[0].name }}
        <input type="hidden" name="room_id" v-bind:value="selectedClass.rooms[0].id">
      </div>
    </div>
  </div>
</template>

<script>
    export default {
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
    }
</script>