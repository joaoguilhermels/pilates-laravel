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
                  <input type="checkbox" :value="class_type.id" :name="classTypeIdName(class_type.id)" :checked="selectedId(class_type.id)" v-model="checked[class_type.id]">
                  {{ class_type.name }}
                </label>
              </div>
            </td>
            <td class="form-inline">
              <div class="form-group" v-if="checked[class_type.id]">
                <input type="number" min="0" step="any" :name="classTypeIdValue(class_type.id)" class="form-control" :value="selectedValue(class_type.id)">
                <select :name="classTypeIdValueType(class_type.id)" class="form-control" :selected="selectedValueType(class_type.id)">
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

        data: function() {
            return {
                checked: []
            }
        },

        methods: {
          classTypeIdName: function(id) {
            return "class_type_list[" + id + "][class_type_id]";
          },
          classTypeIdValue: function(id) {
            return "class_type_list[" + id + "][value]";
          },
          classTypeIdValueType: function(id) {
            return "class_type_list[" + id + "][value_type]";
          },
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
          },
          classChecked: function(class_type_id) {

          }
        }
    }
</script>