<template>
    <Head title="History" />
    <div class="container-fluid min-vh-100">

        <AppLayout>
        <div class="container d-flex flex-col">
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
          <tr class="table__entry">
            <td></td>
            <td></td>
          </tr>

          <tr>
            <td></td>
          </tr>

        </tbody>
      </table>
    </div>

        <!-- <pagination v-if="history" :links="history.links" /> -->
    </div>
        </AppLayout>
    </div>

</template>

<script>
// import InputError from '@/Components/InputError.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

export default {
    name: 'History',
    components: { Head, Link, AppLayout, Pagination },
    props: ['history'],
    data() {
        return {

        };
    },
    mounted() {
        // console.log('entries:', this.entries);
    },
}

</script>
