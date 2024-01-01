<template>
    <Head title="History" />
    <div class="container-fluid min-vh-100">

        <AppLayout>
        <div class="container d-flex flex-col">
        History section is under construction
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

export default {
    name: 'History',
    components: { Head, Link, AppLayout },
    data() {
        return {

        };
    },
    mounted() {
        // console.log('entries:', this.entries);
    },
}

</script>
