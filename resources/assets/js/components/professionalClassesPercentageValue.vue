<template id="professional-classes-percentage-value">
  <div class="form-group">
    <label for="class_type_list">Classes given by the professional:</label>
    <div class="table-responsive">
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <td>Class</td>
            <td>Value</td>
          </tr>
        </thead>
        <tbody>
          <tr v-for="class_type in classes">
            <td>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="class_type_list[{{ class_type.id }}][class_type_id]" v-bind:checked="selectedId(class_type.id)">
                  {{ class_type.name }}
                </label>
              </div>
            </td>
            <td class="form-inline">
              <div class="form-group" v-if="">
                <input type="number" min="0" step="any" name="class_type_list[{{ class_type.id }}][value]" class="form-control" v-bind:value="selectedValue(class_type.id)">
                <select name="class_type_list[{{ class_type.id }}][value_type]" class="form-control" v-bind:selected="selectedValueType(class_type.id)">
                  <option value="percentage">%</option>
                  <option value="value_per_client">Per Client</option>
                  <option value="value_per_class">Per Class</option>
                </select>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['classes', 'professional_classes'],

        created () {
            this.classes = JSON.parse(this.classes);
            this.professional_classes = JSON.parse(this.professional_classes);
        },

        methods: {
          checkClass: function(item) {
            return this.professional_classes.filter(function(obj) {
              return obj.id === item;
            });
          },
          selectedId: function(item) {
            var proClass = this.checkClass(item);

            if (proClass.length > 0) {
              return true;
            }
          },
          selectedValue: function(item) {
            var proClass = this.checkClass(item);

            if (proClass.length > 0) {
              return _.first(proClass).pivot.value;
            }
          },
          selectedValueType: function(item) {
            var proClass = this.checkClass(item);

            if (proClass.length > 0) {
              return _.first(proClass).pivot.value_type;
            }
          }
        }
    }
</script>