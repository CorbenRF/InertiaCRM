<template>
    <Head title="Catalogues" />
    <div class="container-fluid min-vh-100">

        <AppLayout>
        <div class="container d-flex flex-column">
        <div class="catalogue__select">
            <multiSelect
          v-model="this.currentCatalogue"
          :label="`Выберите Каталог`"
          :readOnly="false"
          :name="`catalogue`"
          :catalogue="this.cataloguesList"
          :catalogueRuName="`Каталог`"
          :catalogueName="`cataloguesList`"
          item="cataloguesList"
          :taggable="false"
        >
        </multiSelect>
        </div>


        <div class="table-responsive-md">
            <table class="table table-hover">
        <thead class="table-head">
          <tr>
            <th scope="col" class="column col-2 col-title">
              <span>ID</span>

            </th>
            <th scope="col" class="column col-10 col-title">
              <span>Запись</span>
            </th>
          </tr>

          <!-- search fields -->

        </thead>
        <tbody class="table-body">
          <tr class="table__entry" v-for="row in currentData" :key="row.id" >
            <td>{{ row.id }}</td>
            <td>
              <form class="input-group" @submit.prevent="console.log(`edit success: ${row.name}`)">
              <input class="form-control" type="text" :disabled="row.id !== this.entryToEdit.id" v-model="row.name">
              <span class="input-group-text" v-if="row.id !== this.entryToEdit.id" @click.capture="editCatalogueEntry(row)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg>
              </span>
              <span class="input-group-text" v-else @click="confirmCatalogueEntryEdit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                    <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.235.235 0 0 1 .02-.022z"/>
                </svg>
              </span>
              <span class="input-group-text" @click="askToDeleteEntry(row)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                </svg>
              </span>
            </form>
            </td>
          </tr>

          <tr v-if="isNewEntryVisible">
            <td colspan="2">
                <form class="input-group" @submit.prevent="createNewCatalogueEntry">
                    <input class="form-control" type="text" v-model="this.entryToCreate" placeholder="Введите новую запись...">
                    <span class="input-group-text" v-if="this.entryToCreate" @click.capture="createNewCatalogueEntry">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-square" viewBox="0 0 16 16">
                            <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                            <path d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425z"/>
                        </svg>
                    </span>
                </form>
            </td>
          </tr>

          <tr v-show="this.currentCatalogue">
            <td colspan="2" class="table__btn-new">
            <div style="display:flex; justify-content: center;">
                <button type="button" class="input-group-text btn btn-primary" style="width:fit-content" @click="this.isNewEntryVisible = !this.isNewEntryVisible">
                    Создать новую запись в каталоге {{ this.currentCatalogue.name }}
                </button>
            </div>
            </td>
          </tr>
        </tbody>
      </table>
        </div>
        <pagination v-if="catalogue" :links="catalogue.links" />
    </div>
            <!-- <pagination :links="entries.links" /> -->
        </AppLayout>
        <dialogueModal v-if="showDelDialogue" @answer="getAnswer" @close="this.showDelDialogue = false">
            <div class="dialogue__modal">
            <p class="dialogue__modal-msg"
                >Вы уверены, что хотите удалить запись каталога:
                <span class="dialogue__modal-bold">№ {{ entryToDelete.id }}</span> -
                <span class="dialogue__modal-bold">{{ entryToDelete.name }}</span>
                каталога:
                <span class="dialogue__modal-bold">{{ currentCatalogue.name }}?</span>

            </p>
            <p class="dialogue__modal-msg">
                <i>УДАЛЕНИЕ ЗАПИСИ КАТАЛОГА ЭТО НЕОБРАТИМЫЙ ПРОЦЕСС И ПРИВЕДЕТ К НЕМЕДЛЕННОМУ УДАЛЕНИЮ <b>ВСЕХ СВЯЗАННЫХ ЗАЯВОК!</b></i>
            </p>
            <p class="dialogue__modal-msg">
                <i>ПОЖАЛУЙСТА УБЕДИТЕСЬ, ЧТО ДАННАЯ ЗАПИСЬ КАТАЛОГА <b>НЕ ИСПОЛЬЗУЕТСЯ</b> В ДЕЙСТВУЮЩИХ ЗАЯВКАХ!</i>
            </p>
            </div>
        </dialogueModal>
    </div>

</template>

<script>
// import InputError from '@/Components/InputError.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import multiSelect from '@/components/UI/multiSelect.vue';
import dialogueModal from '@/components/UI/dialogueModal.vue';

export default {
    name: 'Catalogues',
    components: { Head, Link, AppLayout, multiSelect, Pagination, dialogueModal },
    props: ['catalogue', 'cataloguesList'],
    data() {
        return {
            showEdit: false,
            showDelDialogue: false,
            isNewEntryVisible: false,
            entryToEdit: '',
            entryToDelete: '',
            entryToCreate: '',
            currentCatalogue: new URLSearchParams(window.location.search).has('catalogue') ?
            {
                id: new URLSearchParams(window.location.search).get('catalogue'),
                name: this.cataloguesList.find((element) => element.id == new URLSearchParams(window.location.search).get('catalogue')).name,
            } : '',
        };
    },
    computed: {
        currentData() {
            return this.catalogue ? this.catalogue.data : [];
        },
    },
    methods: {
        editCatalogueEntry(entry) {
            this.showEdit = true;
            this.entryToEdit = entry;
        },
        confirmCatalogueEntryEdit() {
            console.log('sending data to server: ', 'id: ', this.entryToEdit.id, 'name: ',  this.entryToEdit.name);
            this.$inertia.put(`/${this.currentCatalogue.id}/${this.entryToEdit.id}`, this.entryToEdit); // need to put directly to specific catalogue
            this.showEdit = false;
            this.entryToEdit = '';
        },
        closeModal() {
            this.showEdit = false;
        },
        askToDeleteEntry(entry) {
            this.showDelDialogue = true;
            this.entryToDelete = entry;
        },
        getAnswer(val) {
            if(val) {
                console.log('deleting entry from server: ', 'id: ', this.entryToDelete.id, 'name: ',  this.entryToDelete.name);
                this.$inertia.delete(`/${this.currentCatalogue.id}/${this.entryToDelete.id}`, this.entryToDelete);
            }
            this.showDelDialogue = false;
            this.entryToDelete = '';
        },
        async createNewCatalogueEntry() {
            console.log('new entry: ', this.entryToCreate, 'created in ', this.currentCatalogue);

            const tag = {
            name: this.entryToCreate,
            id: 0,
            };
            // this.innerLoading = true;


            const result = axios.post(`${this.currentCatalogue.id}`, tag)
            .then((response) => {
                console.log('result of inertia posting is: ', response.data);
                router.reload();
            });

            this.entryToCreate = '';
            this.isNewEntryVisible = false;
        },
    },
    mounted() {
        console.log('catalogue:', this.catalogue);
        console.log('List of catalogues:', this.cataloguesList);
    },
    watch: {
        currentCatalogue(newCurrentCatalogue, oldCurrentCatalogue) {
            if (newCurrentCatalogue != oldCurrentCatalogue) {
                console.log('watching change: ', newCurrentCatalogue);
                router.reload({ only: ['catalogue'], data: { catalogue: newCurrentCatalogue.id, 'page': '', },  });
            }
        },
    },
}

</script>

<style lang="scss">
    .catalogue {
        &__select {
            display: block;
            min-width: 50%;
        }
    }
    .table {
        &__btn-new {
            & > button {
                // margin: 0 auto !important;
                text-align: justify;
            }
        }
    }
</style>
