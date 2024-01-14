<template>
    <div>
      <VueDatePicker
        :model-value="pickerDate" @update:model-value="handleDate"
        range
        locale="ru"
        cancelText="отменить"
        selectText="выбрать"
        :enable-time-picker="false"
        :format="format"
      />
    </div>
  </template>

  <script>
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

  export default {
    components: { VueDatePicker },
    props: ['modelValue'],
    emits: ['update:modelValue'],
    data() {
        return {
            pickerDate: this.modelValue,
            format: ([date1, date2]) => {
                if(date1 && date2) {
                    const day1 = date1.getDate();
    const month1 = date1.getMonth() + 1;
    const year1 = date1.getFullYear();

    const day2 = date2.getDate();
    const month2 = date2.getMonth() + 1;
    const year2 = date2.getFullYear();
    return `Выбранная дата ${day1}/${month1}/${year1} - ${day2}/${month2}/${year2}`;
                }

  },
        }
    },
    methods: {
        handleDate(modelData) {
            console.log('modeldata is: ', modelData[0]);
            this.pickerDate = modelData;
            this.$emit('update:modelValue', modelData);
        },
    },
  }
  </script>
