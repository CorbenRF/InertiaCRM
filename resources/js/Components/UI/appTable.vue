<!-- eslint-disable  -->
<template>
  <div class="container table-wrapper">
    <h1 class="title">Заявки</h1>
    <div class="table-responsive-md">
      <table class="table table-hover" v-if="loadingFinished">
        <thead class="table-head">
          <tr>
            <th scope="col" class="column col-1 col-title">
              <span>Дата заявки</span>
              <button type="button" class="btn col-title" id="filter-id">
                <svg
                  class="arrow-up"
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
            <th scope="col" class="column col-1 col-title"><span>Дата начала</span></th>
            <th scope="col" class="column col-2 col-title"><span>УИК</span></th>
          </tr>
          <!-- search fields -->
          <tr>
            <th scope="col" class="column col-1 col-title">
              <div class="row mb-3">
                <input
                  type="date"
                  class="form-control"
                  v-model="searchParams.searchDateRecieved.from"
                />
              </div>
              <div class="row">
                <!-- get earliest date from server as metadata -->
                <input
                  type="date"
                  class="form-control"
                  v-model="searchParams.searchDateRecieved.to"
                />
              </div>
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchClientEntryNum"
                @input="inputSearch"
              />
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchClientName"
              />
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchVendorName"
              />
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchSubvendorName"
              />
            </th>
            <th scope="col" class="column col-1 col-title">
              <div class="row mb-3">
                <input
                  type="date"
                  class="form-control"
                  v-model="searchParams.searchDateStart.from"
                />
              </div>
              <div class="row">
                <!-- get earliest date from server as metadata -->
                <input type="date" class="form-control" v-model="searchParams.searchDateStart.to" />
              </div>
            </th>
            <th scope="col" class="column col-2 col-title">
              <input
                type="text"
                class="form-control"
                placeholder="Поиск..."
                v-model="searchParams.searchDepName"
              />
            </th>
          </tr>
        </thead>
        <tbody class="table-body">
          <tr class="table__entry" v-for="row in serverData" :key="row.id" @click="showModal(row)">
            <td>{{ makeStringDate(row.date_received) }}</td>
            <td>{{ row.client_entry_num }}</td>
            <td>
              {{ row.clientName }}
            </td>
            <td>
              {{ row.vendorName }}
            </td>
            <td>
              {{ row.subvendorName }}
            </td>
            <td>{{ makeStringDate(row.date_startby) }}</td>
            <td>
              {{ row.depName }}
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
import serverFunc from '@/mixins/serverFunc.vue';
import tableModal from '@/components/UI/tableModal.vue';
import Pagination from '@/Components/Pagination.vue';
import dateFunc from '@/mixins/dateFunc.vue';

export default {
  components: { Pagination, tableModal },
  props: ['serverData', 'links'],
  mixins: [dateFunc, serverFunc],
  data() {
    return {
      timeout: null,
      modalData: '',
      loadingFinished: true,
      modalVisible: false,
      componentKey: 0,
      searchParams: {
        searchClientEntryNum: '',
        searchClientName: '',
        searchVendorName: '',
        searchSubvendorName: '',
        searchDepName: '',
        searchDateRecieved: {
          from: '',
          to: '',
        },
        searchDateStart: {
          from: '',
          to: '',
        },
      },
    };
  },
  methods: {
    inputSearch() {

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
    async deleteEntry(valId) {
      console.log('deleting entry number: ', valId);
      console.log(await this.deleteCatalogueEntry('entries', valId));
      this.closeModal();
      this.forceRerender();
    },
  },
  mounted() {
    // this.$store.dispatch('fetchAPI', { path: '/entries' }).then((this.loadingFinished = true));
  },
};
</script>

<style lang="scss">
.table {
  &__entry {
    cursor: pointer;
  }
}
.table-wrapper {
  min-height: 60vh;
  display: flex;
  flex-direction: column;
}
</style>
