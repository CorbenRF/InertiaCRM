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
      :start-time="startTime"
      utc="preserve"
      timezone="UTC"
    />
  </div>
</template>

<script>
import { router } from '@inertiajs/vue3';
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {
    components: { VueDatePicker },
    props: ['modelValue', 'dateType'],
    emits: ['update:modelValue'],
    data() {
        return {
            pickerDate: this.modelValue,
            startTime: [{ hours: 0, minutes: 0 }, { hours: 23, minutes: 59 }],
            format: ([date1, date2]) => {
                if(date1 && date2) {
                    const day1 = date1.getDate();
    const month1 = date1.getMonth() + 1;
    const year1 = date1.getFullYear();

    const day2 = date2.getDate();
    const month2 = date2.getMonth() + 1;
    const year2 = date2.getFullYear();
        return `${day1}.${month1}.${year1} - ${day2}.${month2}.${year2}`;
                }

            },
        }
    },
    methods: {
        handleDate(modelData) {
            if(modelData) {
                console.log('modeldata is: ', modelData[0]);
            this.pickerDate = modelData;
            this.$emit('update:modelValue', modelData);
            router.reload({ only: ['entries'], data: { [`${this.dateType}From`]: this.pickerDate[0], [`${this.dateType}To`]: this.pickerDate[1] },  });
            } else {
                this.pickerDate = ['', ''];
                this.$emit('update:modelValue', ['', '']);
                router.reload({ only: ['entries'], data: { [`${this.dateType}From`]: null, [`${this.dateType}To`]: null },  });
            }
           },
        // clear() {
        //     console.log('modeldata is: ', modelData);
        //     this.pickerDate = [null, null];
        //     this.$emit('update:modelValue', [null, null]);
        //     router.reload({ only: ['entries'], data: { [`${this.dateType}From`]: null, [`${this.dateType}To`]: null },  });
        // },
    },
  }
</script>

