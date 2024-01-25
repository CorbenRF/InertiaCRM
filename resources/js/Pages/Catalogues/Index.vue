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
              {{ row.name }}
            </td>
          </tr>
        </tbody>
      </table>
        </div>
        <pagination v-if="catalogue.links" :links="catalogue.links" />
    </div>
            <!-- <pagination :links="entries.links" /> -->
        </AppLayout>
    </div>

</template>

<script>
// import InputError from '@/Components/InputError.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
// import Pagination from '@/Components/Pagination.vue';
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
