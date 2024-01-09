<template>
    <Head title="Entries" />
    <div class="container-fluid min-vh-100">

        <AppLayout>
        <div class="container d-flex flex-col">
            <appTable :serverData="entries.data" :links="entries.links">
                <!-- <Entry
                        v-for="item in entries.data"
                        :key="item.id"
                        :item="item"
                    /> -->
            </appTable>
        </div>

        </AppLayout>
    </div>

</template>

<script>
import Entry from '@/Components/Entry.vue';
import appTable from '@/Components/UI/appTable.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

export default {
    name: 'Entries',
    components: { Entry, InputError, PrimaryButton, Head, Link, AppLayout, appTable },
    props: ['entries', 'catalogues'],
    data() {
        return {

        };
    },
    mounted() {
        console.log('entries:', this.entries);
        // console.log('catalogues:', this.$page.props.catalogues.departments);
    },
}

</script>
