<!-- eslint-disable  -->
<template>
  <div class="container table-wrapper">
    <h1 class="title">Заявки</h1>
    <div class="table-responsive-md">
    <div class="table__resetbtn" v-show="isQueryEmpty">
      <button type="button" class="btn btn-outline-info" @click="resetFilterSort">
        Сбросить фильтры/сортировки
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-filter-square" viewBox="0 0 16 16">
  <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
  <path d="M6 11.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 0 1h-3a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-2-3a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 0 1h-11a.5.5 0 0 1-.5-.5"/>
</svg>
      </button>
    </div>
      <table class="table table-hover" v-if="loadingFinished">
        <thead class="table-head">
          <tr>
            <th scope="col" class="column col-1 col-title">
              <span>Дата заявки</span>
              <button type="button" class="btn col-title" id="orderDateReceived" @click="flipSortOrder('date_received')">
                <svg
                  class="arrow-up"
                  :class="{ down: this.sortParams.date_received === 'desc' }"
                  width="8"
                  height="8"
                  viewBox="0 0 8 8"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M3.49691e-07 4L0.705 4.705L3.5 1.915L3.5 8L4.5 8L4.5 1.915L7.29 4.71L8 4L4 -3.49691e-07L3.49691e-07 4Z"
                    fill="#9873FF"
                  />
                </svg>
              </button>
            </th>
            <th scope="col" class="column col-2 col-title">
              <span>Номер заявки</span>
            </th>
            <th scope="col" class="column col-2 col-title">
              <span>Заказчик</span>
            </th>
            <th scope="col" class="column col-2 col-title">
              <span>Поставщик</span>
            </th>
            <th scope="col" class="column col-2 col-title">
              <span>ПП</span>
            </th>
            <th scope="col" class="column col-1 col-title"><span>Дата начала</span>
              <button type="button" class="btn col-title" id="orderDateStart" @click="flipSortOrder('date_startby')">
                <svg
                  class="arrow-up"
                  :class="{ down: this.sortParams.date_startby === 'desc' }"
                  width="8"
                  height="8"
                  viewBox="0 0 8 8"
                  fill="none"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    d="M3.49691e-07 4L0.705 4.705L3.5 1.915L3.5 8L4.5 8L4.5 1.915L7.29 4.71L8 4L4 -3.49691e-07L3.49691e-07 4Z"
                    fill="#9873FF"
                  />
                </svg>
              </button>
            </th>
            <th scope="col" class="column col-2 col-title"><span>УИК</span></th>
          </tr>

          <!-- search fields -->
          <tr>
            <th scope="col" class="column col-1 col-title">
              <div class="row">
                <DatepickerComp v-model="this.searchParams.searchDateRecieved" dateType="searchDR" />
              </div>
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchClientEntryNum"
                @input="inputSearch(target, 'searchClientEntryNum')"
              />
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchClientName"
                @input="inputSearch(target, 'searchClientName')"
              />
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchVendorName"
                @input="inputSearch(target, 'searchVendorName')"
              />
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchSubvendorName"
                @input="inputSearch(target, 'searchSubvendorName')"
              />
            </th>
            <th scope="col" class="column col-1 col-title">
              <div class="row">
                <DatepickerComp v-model="this.searchParams.searchDateStart" dateType="searchDS" />
              </div>
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchDepartmentName"
                @input="inputSearch(target, 'searchDepartmentName')"
              />
            </th>
          </tr>
        </thead>
        <tbody class="table-body">
          <tr class="table__entry" v-for="row in serverData" :key="row.id" @click="showModal(row)">
            <td>{{ makeStringDate(row.date_received) }}</td>
            <td>{{ row.client_entry_num }}</td>
            <td>
              {{ row.client.name }}
            </td>
            <td>
              {{ row.vendor.name }}
            </td>
            <td>
              {{ row.subvendor.name }}
            </td>
            <td>{{ makeStringDate(row.date_startby) }}</td>
            <td>
              {{ row.department.name }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="text-center visually-hidden spinner-main">
      <div
        class="spinner-border text-info spinner-load-clients"
        style="width: 7rem; height: 7rem"
        role="status"
      >
        <span class="visually-hidden">Загрузка...</span>

      </div>

    </div>
    <pagination :links="links" />
    <tableModal
      v-if="modalVisible"
      :id="modalData.id"
      :entryServerData="modalData"
      :readOnlyDefault="true"
      @close="closeModal"
      @delete="deleteEntry"
    />
  </div>
</template>

<script>
import { router } from '@inertiajs/vue3';
import serverFunc from '@/mixins/serverFunc.vue';
import tableModal from '@/components/UI/tableModal.vue';
import Pagination from '@/Components/Pagination.vue';
import dateFunc from '@/mixins/dateFunc.vue';
import DatepickerComp from './datepickerComp.vue';

export default {
  components: { Pagination, tableModal, DatepickerComp },
  props: ['serverData', 'links'],
  mixins: [dateFunc, serverFunc],
  data() {
    return {
      timeout: null,
      modalData: '',
      loadingFinished: true,
      modalVisible: false,
      componentKey: 0,
      sortParams: {
        date_received: new URLSearchParams(window.location.search).has('date_received') ? new URLSearchParams(window.location.search).get('date_received') : '',
        date_startby: new URLSearchParams(window.location.search).has('date_startby') ? new URLSearchParams(window.location.search).get('date_startby') : '',
      },
      searchParams: {
        searchClientEntryNum: new URLSearchParams(window.location.search).has('searchClientEntryNum') ? new URLSearchParams(window.location.search).get('searchClientEntryNum') : '',
        searchClientName: new URLSearchParams(window.location.search).has('searchClientName') ? new URLSearchParams(window.location.search).get('searchClientName') : '',
        searchVendorName: new URLSearchParams(window.location.search).has('searchVendorName') ? new URLSearchParams(window.location.search).get('searchVendorName') : '',
        searchSubvendorName: new URLSearchParams(window.location.search).has('searchSubvendorName') ? new URLSearchParams(window.location.search).get('searchSubvendorName') : '',
        searchDepartmentName: new URLSearchParams(window.location.search).has('searchDepartmentName') ? new URLSearchParams(window.location.search).get('searchDepartmentName') : '',
        searchDateRecieved: new URLSearchParams(window.location.search).has('searchDRFrom') ? [new URLSearchParams(window.location.search).get('searchDRFrom'), new URLSearchParams(window.location.search).get('searchDRTo')] : ['', ''],
        searchDateStart: new URLSearchParams(window.location.search).has('searchDSFrom') ? [new URLSearchParams(window.location.search).get('searchDSFrom'), new URLSearchParams(window.location.search).get('searchDSTo')] : ['', ''],

      },
    };
  },
  computed: {
    isQueryEmpty() {
      for(let key in this.searchParams) {
        if(this.searchParams[key] !== '') {
          if(Array.isArray(this.searchParams[key])) {
            if(this.searchParams[key][1] != '' && this.searchParams[key][0] != '' ) return true;
          }
          else {
          return true;
          }
        }
      };
      for(let key in this.sortParams) {
        if(this.sortParams[key] !== '') {
          return true;
        }
      };
      return false;
    },
  },
  methods: {
    flipSortOrder(sortBy) {
        this.sortParams[sortBy] === '' ? this.sortParams[sortBy] = 'desc' : this.sortParams[sortBy] = 'asc';
        router.reload({ only: ['entries'], data: { [sortBy]: this.sortParams[sortBy] }, 'page': '', });
    },
    inputSearch(target, fieldName) {
        console.log('input event registered: ', target);
        router.reload({ only: ['entries'], data: { [fieldName]: this.searchParams[fieldName], 'page': '', },  });
    },
    resetFilterSort() {
      router.visit('/entries');
    },
    forceRerender() {
      this.componentKey += 1;
    },
    showModal(data) {
      this.modalVisible = true;
      this.modalData = data;
    },
    closeModal() {
      this.modalVisible = false;
    },
    deleteEntry(entryToDelete) {
      console.log('deleting entry number: ', entryToDelete);
      this.$inertia.delete(`/entries/${entryToDelete}`);
      this.closeModal();
      this.forceRerender();
    },
  },
  mounted() {
    // console.log('is searchParams empty? ', Object.keys(this.searchParams));
  },
};
</script>

<style lang="scss">
.table {
  &__entry {
    cursor: pointer;
  }
  &__resetbtn {
    display: block;
    text-align: center;
  }
}
.table-wrapper {
  min-height: 60vh;
  display: flex;
  flex-direction: column;
}
.down {
    transform: rotate(180deg);
}
</style>
