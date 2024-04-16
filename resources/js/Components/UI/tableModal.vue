<!-- eslint-disable -->
<template>
  <transition name="fade">
    <div class="backdrop" @click.self="close">
      <div class="modal-custom container-md">
        <div class="container-fluid gx-0" :class="{ danger: entryData.busy_edit }">
          <div class="row d-flex modal__ribbon" :class="{ danger: this.entryData.busy_edit }">
            <div class="ribbon__key">
              <strong v-if="id">{{ entryData.id }}</strong>
              <strong v-else>*</strong>
            </div>
            <div class="ribbon__text">
              <span v-if="id">
                <strong>{{ currentClientName }}</strong> Заявка №
                <strong>{{ currentEntryNum }}</strong>
                -
                <strong v-if="this.entryData.busy_edit">Занято другим пользователем</strong>
              </span>
              <span v-else>Создание новой заявки</span>
            </div>
            <div class="ribbon__buttons">
              <button
                v-if="id"
                type="button"
                class="btn buttons__edit"
                @click="toggleEdit"
                :class="{ 'btn-danger': !readOnly }"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-pencil-square"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"
                  />
                  <path
                    fill-rule="evenodd"
                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"
                  />
                </svg>
              </button>
              <button
                v-if="id"
                type="button"
                class="btn buttons__delete"
                @click="askToDelete"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-trash3"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"
                  />
                </svg>
              </button>
              <button type="button" class="btn buttons__close" @click="close">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="16"
                  height="16"
                  fill="currentColor"
                  class="bi bi-x"
                  viewBox="0 0 16 16"
                >
                  <path
                    d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>

        <div class="modal__main container">
          <div class="main__header row">
            <div class="grid text-center">
              <div
                class="modal__tab"
                v-for="(tab, index) in tabs"
                @click="setActiveTab(tab)"
                :class="{ activeTab: activeTab === tab, 'g-col-6': activeTab === tab }"
              >
                {{ tab }}
              </div>
            </div>
          </div>
          <div class="main__content row">
            <commonView
              v-if="activeTab === 'Общее'"
              :data="entryData"
              :read-only="readOnly"
              :key="componentKey"
              @toggleReadOnly="this.readOnly = !this.readOnly"
              @update="forceUpdate"
            />
            <venueView v-if="activeTab === 'ПП'" />
            <goodsView v-if="activeTab === 'МТР'" />
          </div>
        </div>
      </div>
      <dialogueModal v-if="confirmVisible" @answer="getAnswer" @close="this.confirmVisible = false">
        <div class="dialogue__modal">
          <span class="dialogue__modal-msg"
            >Вы уверены, что хотите удалить запись:
            <span class="dialogue__modal-bold">№ {{ entryData.id }}</span> -
            <span class="dialogue__modal-bold">{{ entryData.client_entry_num }}</span>
            от
            <span class="dialogue__modal-bold">{{ makeStringDate(entryData.date_received) }}</span>
          </span>
        </div>
      </dialogueModal>
    </div>
  </transition>
</template>

<script>
/* eslint-disable */
import axios from 'axios';
import serverFunc from '@/mixins/serverFunc.vue';
import dateFunc from '@/mixins/dateFunc.vue';
import dialogueModal from './dialogueModal.vue';
import commonView from '../ModalViews/commonView.vue';
import goodsView from '../ModalViews/goodsView.vue';
import venueView from '../ModalViews/venueView.vue';

export default {
  components: {
    dialogueModal,
    commonView,
    goodsView,
    venueView,
  },
  mixins: [serverFunc, dateFunc],
  props: ['id', 'readOnlyDefault', 'entryServerData'],
  data() {
    return {
      entryData: '',
      copyDataNonReactive: '', // this copy of server response doesnt change w/ reactive components
      tabs: ['Общее', 'МТР', 'ПП', 'Заявка', 'Инспектор', 'История', 'Комментарии'],
      activeTab: 'Общее',
      readOnly: this.readOnlyDefault,
      componentKey: 0,
      confirmVisible: false,
      confirmAnswer: null,
      currentClientName: '',
      currentEntryNum: '',
      isEntryBusy: 0,
    };
  },

  methods: {
    async askToDelete() {
      const isEntryBusy = await this.busyCheck();
        console.log('check if busy: ', isEntryBusy);
      if(!isEntryBusy) {
        this.confirmVisible = true;
      } else {
        console.log('entry in use by another user');
      }

    },
    getAnswer(val) {
      this.confirmAnswer = val;
      this.confirmVisible = false;
      this.delete();
    },
    organiseData(obj) {
      //this is a check for passed object being empty, used in if-condition lower
      const isObjectEmpty = (objectName) => {
        return (
          objectName && Object.keys(objectName).length === 0 && objectName.constructor === Object
        );
      };

      let newObj = {
        id: null,
        date_received: '',
        date_startby: '',
        date_actual_start: '',
        date_end: '',
        busy_edit: 0,
        expired: 0,
        client_entry_num: '',
        inspection_lvl: null,
      };
      if (!isObjectEmpty(obj)) {
        console.log('filling object entry with data from server');
        newObj = {
          id: obj.id,
          date_received: obj.date_received,
          date_startby: obj.date_startby,
          date_actual_start: obj.date_actual_start,
          date_end: obj.date_end,
          department: {
            id: obj.department_id,
            name: obj.department_name,
          },
          client: {
            id: obj.client_id,
            name: obj.client_name,
          },
          vendor: {
            id: obj.vendor_id,
            name: obj.vendor_name,
          },
          subvendor: {
            id: obj.subvendor_id,
            name: obj.subvendor_name,
          },
          status: {
            id: obj.status_id,
            name: obj.status_name,
          },
          curator: {
            id: obj.curator_id,
            name: obj.curator_name,
            // department_id: obj.curatorDeptId,
          },
          inspector: {
            id: obj.inspector_id,
            name: obj.inspector_name,
            // department_id: obj.inspectorDeptId,
          },
          busy_edit: obj.busy_edit,
          expired: obj.expired,
          client_entry_num: obj.client_entry_num,
          inspection_lvl: obj.inspection_lvl,
        };
      }
      console.log('resulting object is: ', newObj);
      return newObj;
    },
    close() {
      this.forceRerender();
      this.$emit('close');
      this.activeTab = 'Общее';
    },
    delete() {
      if (this.confirmAnswer) this.$emit('delete', this.id);
    },
    setActiveTab(strName) {
      if (this.activeTab !== strName) {
        this.activeTab = strName;
      }
    },
    forceRerender() {
      this.componentKey += 1;
      this.entryData = this.copyDataNonReactive;
    },
    async forceUpdate() {
      const idToFetch = this.id ? this.id : this.entryData.id;
    //   const res = await this.fetchEntry('entries', idToFetch);
      this.copyDataNonReactive = { ...this.entryData };
      this.currentClientName = this.entryData.client.name;
      this.currentEntryNum = this.entryData.client_entry_num;
    },
    async busyCheck() {
        // this.loadingFinished = false;
            const response = await axios.get(`entries/${this.entryServerData.id}/isbusy`);
            if(response.status == 200) {
                return response.data.isbusy;
            } else {
                console.log(response);
            }

    },
    async toggleEdit() {
        // const isEntryBusy = await this.busyCheck();
        // console.log('check if busy: ', isEntryBusy);
    if(!this.isEntryBusy) { // flawed logic because entry is busy by myself and i cant un-busy it because it's busy
        if (!this.readOnly) {
            this.$inertia.post(`/entries/makebusy`, { id: this.entryServerData.id, busy: 0});
            console.log('entry become not-busy - success');
            this.readOnly = !this.readOnly;
            this.forceRerender();
            console.log('forcing update');

      } else {
        console.log('toggling readOnly');
      this.$inertia.post(`/entries/makebusy`, { id: this.entryServerData.id, busy: 1});
        console.log('entry become busy - success');
        this.readOnly = !this.readOnly;


      }

    } else {
        console.log('entry is busy being edited by another user');
    };

    },
  },
  async created() {
    this.isEntryBusy = await this.busyCheck(); // checks busy_edit only once upon model creation
    console.log('check if busy: ', this.isEntryBusy);
    if (this.id) {
    //   const res = await this.fetchEntry('entries', this.id);
    // this.entryData = this.organiseData(this.entryServerData);
      this.entryData = this.entryServerData;
      this.copyDataNonReactive = { ...this.entryData };
      this.currentClientName = this.entryData.client.name;
      this.currentEntryNum = this.entryData.client_entry_num;
    } else {
      this.entryData = this.organiseData({});
    }
  },
};
</script>

<style lang="scss">
.modal-custom {
  position: relative;
  padding: 0 !important;
  height: 80vh;
  border: 1px blue solid;
  border-radius: 40px;
  // background-color: rgba($color: #555, $alpha: 0.2);
  z-index: 500;
  background: #ffffff;
  box-shadow: 2px 2px 20px 1px;
  overflow-x: auto;
  display: flex;
  flex-direction: column;
  .btn-close {
    align-self: flex-end;
  }
  & .container-fluid {
    padding: 0;
  }
}

.modal {
  &__ribbon {
    min-height: 3rem;
    padding: 0 !important;
    background-color: burlywood;
    justify-content: space-between;
    & > * {
      width: max-content;
      padding: 10px;
    }
  }

  &__main {
    height: 100%;
    padding-top: 2em;
    padding-bottom: 2em;
    padding-right: 2em !important;
    padding-left: 2em !important;
  }
  &__tab {
    padding: 1em;
    border: 1px solid #000;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
  }
}

.ribbon {
  &__key {
    padding-right: 1rem;
    padding-left: 1.5rem;
    border-right: 1px solid #000;
  }
  &__buttons {
    padding: 0;
    border-left: 1px solid #000;
    & .bi {
      width: 2em;
      height: 2em;
    }
    & > * {
      height: 100%;
    }
  }
}

.buttons {
  &__delete {
    border-radius: 0 !important;
    border-right: 1px solid #000 !important;
    border-left: 1px solid #000 !important;
  }
}

.main {
  &__header {
    height: max-content;
    width: 100%;
    & .container .row {
      margin-bottom: 1rem;
    }
  }
  &__content {
    width: 100%;
  }
}

.backdrop {
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.3);
  display: flex;
  justify-content: center;
  align-items: center;
}

.danger {
  background-color: var(--bs-orange);
}

.activeTab {
  background-color: burlywood;
  border-width: 3px;
  transition: background-color 0.5s ease-in;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s;
}

.fade-enter,
.fade-leave-active {
  opacity: 0;
}
</style>
