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
            </form>
            </td>
          </tr>
        </tbody>
      </table>
        </div>
        <pagination v-if="catalogue" :links="catalogue.links" />
    </div>
            <!-- <pagination :links="entries.links" /> -->
        </AppLayout>
    </div>

</template>

<script>
// import InputError from '@/Components/InputError.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from '@/Components/Pagination.vue';
import multiSelect from '@/components/UI/multiSelect.vue';

export default {
    name: 'Catalogues',
    components: { Head, Link, AppLayout, multiSelect, Pagination },
    props: ['catalogue', 'cataloguesList'],
    data() {
        return {
            showEdit: false,
            entryToEdit: '',
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
</style>
