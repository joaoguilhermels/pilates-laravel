<template id="class-professional-room-status-template">
  <div>
    <div class="form-group">
      <label for="class_type_id">Class: </label>
      <select name="class_type_id" class="form-control" v-model="selectedClassId" v-on:change="selectClass" v-if="classesList.length > 1">
        <option value=""></option>
        <option v-for="classType in classesList" :value="classType.id">{{ classType.name }}</option>
      </select>
      <div v-else>
        {{ classesList[0].name }}
        <input type="hidden" name="class_type_id" :value="classesList[0].id" v-model="selectedClassId">
      </div>
    </div>
    <div class="form-group" v-if="selectedClass">
      <label for="professional_id">Professional: </label>
      <select name="professional_id" class="form-control" v-if="selectedClass.professionals.length > 1">
        <option value=""></option>
        <option v-for="professional in selectedClass.professionals" :value="professional.id">{{ professional.name }}</option>
      </select>
      <div v-else>
        {{ selectedClass.professionals[0].name }}
        <input type="hidden" name="professional_id" :value="selectedClass.professionals[0].id">
      </div>
    </div>
    <div class="form-group" v-if="selectedClass">
      <label for="room_id">Room: </label>
      <select name="room_id" class="form-control" v-if="selectedClass.rooms.length > 1">
        <option value=""></option>
        <option v-for="room in selectedClass.rooms" :value="room.id">{{ room.name }}</option>
      </select>
      <div v-else>
        {{ selectedClass.rooms[0].name }}
        <input type="hidden" name="room_id" :value="selectedClass.rooms[0].id">
      </div>
    </div>
    <div class="form-group" v-if="selectedClass">
      <label for="status_id">Status: </label>
      <select name="status_id" class="form-control" v-if="selectedClass.statuses.length > 1">
        <option value=""></option>
        <option v-for="status in selectedClass.statuses" :value="status.id">{{ status.name }}</option>
      </select>
      <div v-else>
        {{ selectedClass.statuses[0].name }}
        <input type="hidden" name="status_id" :value="selectedClass.statuses[0].id">
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
                selectedClass: '',
                classesList: []
            }
        },

        mounted () {
            this.classesList = JSON.parse(this.classes);

            if (this.classesList.length == 1) {
                this.selectedClass = this.classesList[0];
            }
        },

        methods: {
            selectClass: function() {
                var self = this;
                this.classesList.forEach(function(classType) {
                    if (classType.id == self.selectedClassId) {
                        self.selectedClass = classType;
                    }
                });
            }
        }
    }
</script>
