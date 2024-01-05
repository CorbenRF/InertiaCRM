<template>
  <!-- eslint-disable -->
  <form class="interface__info" @submit.prevent="submitForm" v-if="this.loadingFinished">
    <div class="info__wrapper grid">
      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="client_entry_num">Входящий номер заявки</label>
        <input
          class="form-control"
          :class="{ 'multiselect--disabled': readOnly }"
          type="text"
          name="client_entry_num"
          id="client_entry_num"
          :readonly="readOnly"
          placeholder="Введите входящий номер заявки"
          v-model="data.client_entry_num"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="client_name_id">Заказчик</label>
        <multiSelect
          v-model="this.data.client"
          :label="`Выберите Заказчика`"
          :readOnly="this.readOnly"
          :name="`client_name_id`"
          :catalogue="cataloguesData.clients"
          :catalogueRuName="`Заказчики`"
          :catalogueName="`clients`"
          item="client"
          :taggable="true"
          @update-data="setDataParam"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="vendor_name_id">Поставщик</label>
        <multiSelect
          v-model="this.data.vendor"
          :label="`Выберите Поставщика`"
          :readOnly="this.readOnly"
          :name="`vendor_name_id`"
          :catalogue="cataloguesData.vendors"
          :catalogueRuName="`Поставщики`"
          :catalogueName="`vendors`"
          item="vendor"
          :taggable="true"
          @update-data="setDataParam"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="subvendor_name_id">ПП</label>
        <multiSelect
          v-model="this.data.subvendor"
          :label="`Выберите ПП`"
          :readOnly="this.readOnly"
          :name="`subvendor_name_id`"
          :catalogue="cataloguesData.subvendors"
          :catalogueRuName="`Производственные площадки`"
          :catalogueName="`subvendors`"
          item="subvendor"
          :taggable="true"
          @update-data="setDataParam"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="date_received">Дата поступления</label>
        <input
          class="form-control"
          :class="{ 'multiselect--disabled': readOnly }"
          type="date"
          name="date_received"
          id="date_received"
          :readonly="readOnly"
          placeholder="ДД.ММ.ГГГГ"
          :value="makeShortDate(data.date_received)"
          @change="setInputDate($event, 'date_received')"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="date_startby">Дата начала</label>
        <input
          class="form-control"
          :class="{ 'multiselect--disabled': readOnly }"
          type="date"
          name="date_startby"
          id="date_startby"
          :readonly="readOnly"
          placeholder="ДД.ММ.ГГГГ"
          :value="makeShortDate(data.date_startby)"
          @change="setInputDate($event, 'date_startby')"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="date_end">Дата окончания</label>
        <input
          class="form-control"
          :class="{ 'multiselect--disabled': readOnly }"
          type="date"
          name="date_end"
          id="date_end"
          :readonly="readOnly"
          placeholder="ДД.ММ.ГГГГ"
          :value="makeShortDate(data.date_end)"
          @change="setInputDate($event, 'date_end')"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="date_actual_start">Дата начала факт</label>
        <input
          class="form-control"
          :class="{ 'multiselect--disabled': readOnly }"
          type="date"
          name="date_actual_start"
          id="date_actual_start"
          :readonly="readOnly"
          placeholder="ДД.ММ.ГГГГ"
          :value="makeShortDate(data.date_actual_start)"
          @change="setInputDate($event, 'date_actual_start')"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="department_id">УИК</label>
        <multiSelect
          v-model="this.data.department"
          :label="`Выберите УИК`"
          :readOnly="this.readOnly"
          :name="`department_id`"
          :catalogue="cataloguesData.departments"
          :catalogueRuName="`УИК-и`"
          :catalogueName="`departments`"
          item="department"
          :taggable="false"
          @update-data="setDataParam"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="curator_id">Куратор</label>
        <multiSelect
          v-model="this.data.curator"
          :label="`Выберите Куратора`"
          :readOnly="this.readOnly"
          :name="`curator_id`"
          :catalogue="cataloguesData.curators"
          :catalogueRuName="`Кураторы`"
          :catalogueName="`curators`"
          item="curator"
          :taggable="true"
          @update-data="setDataParam"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="inspector_id">Инспектор</label>
        <multiSelect
          v-model="this.data.inspector"
          :label="`Выберите Инспектора`"
          :readOnly="this.readOnly"
          :name="`inspector_id`"
          :catalogue="cataloguesData.inspectors"
          :catalogueRuName="`Инспекторы`"
          :catalogueName="`inspectors`"
          item="inspector"
          :taggable="true"
          @update-data="setDataParam"
        />
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="status_id">Статус</label>
        <multiSelect
          v-model="this.data.status"
          :label="`Выберите Статус`"
          :readOnly="this.readOnly"
          :name="`status_id`"
          :catalogue="cataloguesData.statuses"
          :catalogueRuName="`Статусы`"
          :catalogueName="`statuses`"
          item="status"
          :taggable="false"
          @update-data="setDataParam"
        >
        </multiSelect>
      </div>

      <div class="g-col-6 g-col-lg-4 d-flex flex-column">
        <label class="form-label" for="inspection_lvl">Уровень инспекции</label>
        <multiSelect
          v-model="this.inspection_lvl"
          :label="`Выберите Уровень Инспекции`"
          :readOnly="this.readOnly"
          :name="`inspection_lvl`"
          :catalogue="this.inspection_levels"
          :catalogueRuName="`Уровень Инспекции`"
          :catalogueName="`inspection_levels`"
          item="inspection_lvl"
          :taggable="false"
          @update-data="setDataParam"
        >
        </multiSelect>
      </div>

    </div>
    <button type="submit" class="btn btn-lg btn-success" v-if="!readOnly">
      {{ data.id ? 'Применить' : 'Создать' }}
    </button>
    <div class="interface__error" v-if="serverOutput.length > 0" v-for="item of serverOutput">
      <span>{{ item }}</span>
    </div>
  </form>
  <div class="interface__info" v-else>
    <div class="spinner-border text-primary" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
  </div>
</template>

<script>
/* eslint-disable */
import axios from 'axios';
import dateFunc from '@/mixins/dateFunc.vue';
import serverFunc from '@/mixins/serverFunc.vue';
import multiSelect from '@/components/UI/multiSelect.vue';

export default {
  props: ['data', 'readOnly'],
  components: {
    multiSelect,
  },
  mixins: [dateFunc, serverFunc],
  data() {
    return {
      loadingFinished: false,
      errorVisible: false,
      serverOutput: [],
      validationResult: '',
      cataloguesData: [],
      inspection_levels: [{id: 0, name: '1'},
      {id: 1, name: '2'},
      {id: 2, name: '3'}],
      inspection_lvl: { id: this.data.inspection_lvl -1, name: this.data.inspection_lvl}
    };
  },
  computed: {

  },
  methods: {
    fetchCatalogues() {
      this.loadingFinished = false;
      axios.get(this.route('catalogues.get'))
    .then((response) => {
        this.cataloguesData = response.data.catalogues;
        this.loadingFinished = true;
        console.log(response.data.catalogues);
    });
    },
    deorganiseData(obj) {
      if (obj) {
        const newObj = {
          client_entry_num: obj.client_entry_num,
          date_received: this.makeStandardDate(obj.date_received),
          date_startby: this.makeStandardDate(obj.date_startby),
          date_actual_start: this.makeStandardDate(obj.date_actual_start),
          date_end: this.makeStandardDate(obj.date_end),
          department_id: obj.department ? obj.department.id : null,
          client_name_id: obj.client ? obj.client.id : null,
          vendor_name_id: obj.vendor ? obj.vendor.id : null,
          subvendor_name_id: obj.subvendor ? obj.subvendor.id : null,
          status_id: obj.status ? obj.status.id : 1,
          curator_id: obj.curator ? obj.curator.id : 1,
          inspector_id: obj.inspector ? obj.inspector.id : 1,
          busy_edit: obj.busy_edit,
          expired: obj.expired,
          inspection_lvl: obj.inspection_lvl,
        };
        return newObj;
      }
      return '';
    },
    validateForm(formData) {
      let resultMsg = [];
      if (!formData.client_entry_num || formData.client_entry_num.length > 30) {
        resultMsg.push('Входящий номер заявки должен быть не пустым и не больше 30 символов \n');
      }
      if (!formData.client) {
        resultMsg.push('Выберите из списка или создайте нового Заказчика \n');
      }
      if (!formData.date_received) {
        resultMsg.push('Укажите дату поступления заявки \n');
      }
      if (!formData.date_startby) {
        resultMsg.push('Укажите дату начала инспекции из заявки \n');
      }
      if (!formData.department) {
        resultMsg.push('Выберите УИК из списка \n');
      }
      if (!formData.subvendor) {
        resultMsg.push('Выберите из списка или создайте новую ПП \n');
      }
      if (!formData.vendor) {
        resultMsg.push('Выберите из списка или создайте нового Поставщика \n');
      }
      if (formData.inspection_lvl < 1 || formData.inspection_lvl > 3) {
        resultMsg.push('Укажите уровень инспекции (1-3) \n');
      }

      if (resultMsg.length > 0) return resultMsg;
      else return [];
    },
    async submitForm() {
      this.serverOutput = [];
      const dataToSend = this.data;
      console.log('data to send: ', dataToSend);
      this.validationResult = this.validateForm(dataToSend);
      if (this.data.id) {
        if (this.validationResult.length > 0) {
          this.serverOutput = this.validationResult;
        } else {
            // this.$inertia.form(dataToSend).put(`/entries/${this.data.id}`);
            this.$inertia.put(`/entries/${this.data.id}`, { ...this.data,
                'client_name_id': this.data.client.id,
                'department_id': this.data.department.id,
                'vendor_name_id': this.data.vendor.id,
                'subvendor_name_id': this.data.subvendor.id,
                'status_id': this.data.status.id,
                'curator_id': this.data.curator.id,
                'inspector_id': this.data.inspector.id,
                'date_received': this.makeStandardDate(this.data.date_received),
                'date_startby': this.makeStandardDate(this.data.date_startby),
                'date_actual_start': this.makeStandardDate(this.data.date_actual_start),
                'date_end': this.makeStandardDate(this.data.date_end),
                'inspection_lvl': Number(this.inspection_lvl.name),
            });
        //   this.$emit('update'); might break something
          this.$emit('toggleReadOnly');
        }
      } else {
        if (this.validationResult.length > 0) {
          this.serverOutput = this.validationResult;
        } else {
          const res = await this.postForm('entriesView', dataToSend);
          this.serverOutput.push(res.message);
          this.data.id = res.id;
          this.$emit('update');
          this.$emit('toggleReadOnly');
        }
        // maybe need to add close after 5 sec
      }
    },
    setInputDate(event, title) {
      if (event.target.validity.valid) {
        let transformedDate = `${event.target.value}T12:00:00.000Z`;
        // this.$emit('setDate', { title: title, transformedDate: transformedDate });
        this.data[title] = transformedDate;
      } else console.log('Введена некорректная дата');
    },
    setDataParam(paramName, obj) {
      this.data[paramName] = obj;
    },
  },
  mounted() {
    this.fetchCatalogues();
  },
};
</script>

<style lang="scss">
.info {
  &__wrapper {
    padding: 2rem;
  }
}
</style>
