<template>
    <Head title="Catalogues" />
    <div class="container-fluid min-vh-100">

        <AppLayout>
        <div class="container d-flex flex-col">
        Catalogues section is under construction
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
            <!-- <pagination :links="entries.links" /> -->
        </AppLayout>
    </div>

</template>

<script>
// import InputError from '@/Components/InputError.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
// import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import multiSelect from '@/components/UI/multiSelect.vue';

export default {
    name: 'Catalogues',
    components: { Head, Link, AppLayout, multiSelect },
    props: ['catalogue', 'cataloguesList'],
    data() {
        return {
            currentData: this.catalogue,
            currentCatalogue: this.cataloguesList[0],
        };
    },
    mounted() {
        console.log('catalogue:', this.catalogue);
        console.log('List of catalogues:', this.cataloguesList);
    },
}

</script>
