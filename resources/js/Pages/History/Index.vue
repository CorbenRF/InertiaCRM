<template>
    <Head title="History" />
    <div class="container-fluid min-vh-100">
        <AppLayout>
            <div class="container d-flex flex-column">
                <div class="table-responsive-md">
                    <table class="table table-hover">
                        <thead class="table-head">
                            <tr>
                                <th scope="col" class="column col-2 col-title">
                                <span>Дата изменения</span>
                                </th>
                                <th scope="col" class="column col-1 col-title">
                                <span>Событие</span>
                                </th>
                                <th scope="col" class="column col-1 col-title">
                                <span>ID Заявки</span>
                                </th>
                                <th scope="col" class="column col-2 col-title">
                                <span>Автор изменения</span>
                                </th>
                                <th scope="col" class="column col-3 col-title">
                                <span>Старое значение</span>
                                </th>
                                <th scope="col" class="column col-3 col-title">
                                <span>Новое значение</span>
                                </th>
                            </tr>
                        </thead>

                        <tbody class="table-body">
                            <tr class="table__entry" v-for="row in currentData" :key="row.id">
                                <td>{{ makeStringDateTime(row.timestamp) }}</td>
                                <td>{{ row.event }}</td>
                                <td>{{ row.auditable_item_id }}</td>
                                <td>{{ this.getUserName(row.user_id) }}</td>
                                <td>
                                    <details v-if="Object.entries(row.old_values).length > 0 && this.loadingFinished">
                                        <summary>Развернуть</summary>
                                            <table border="1">
                                                <tr v-for="[key, value] of Object.entries(row.old_values)" :key="key">
                                                    <td>{{ this.db_legend(key, value).title }}</td>
                                                    <td>{{ this.db_legend(key, value).value }}</td>
                                                </tr>
                                            </table>
                                    </details>
                                </td>
                                <td>
                                    <details v-if="Object.entries(row.new_values).length > 0 && this.loadingFinished">
                                        <summary>Развернуть</summary>
                                            <table border="1">
                                                <tr v-for="[key, value] of Object.entries(row.new_values)" :key="key">
                                                    <td>{{ this.db_legend(key, value).title }}</td>
                                                    <td>{{ this.db_legend(key, value).value }}</td>
                                                </tr>
                                            </table>
                                    </details>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <Pagination v-if="history" :links="history.links" />
                </div>

            </div>
        </AppLayout>
    </div>
</template>

<script>
// import InputError from '@/Components/InputError.vue';
// import PrimaryButton from '@/Components/PrimaryButton.vue';
import axios from 'axios';
import Pagination from '@/Components/Pagination.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import dateFunc from '@/mixins/dateFunc.vue';

export default {
    name: 'History',
    components: { Head, Link, AppLayout, Pagination },
    props: ['history', 'users'],
    mixins: [dateFunc],
    data() {
        return {
            loadingFinished: false,
            cataloguesData: '',
        };
    },
    computed: {
        currentData() {
            return this.history ? this.history.data : [];
        },
    },
    methods: {
        fetchCatalogues() {
            this.loadingFinished = false;
            axios.get(this.route('catalogues.get'))
            .then((response) => {
                this.cataloguesData = response.data.catalogues;
                this.loadingFinished = true;
                console.log(response.data.catalogues);
            });
        },
        getUserName(custom_id) {
            const find_result = this.users.find(element => element.id === custom_id);
            return find_result ? find_result.name : null;
            // return null;
        },
        db_legend(col_name, col_value) {
            switch (col_name) {
                case 'client_entry_num':
                    return { title: 'Номер заявки', value: col_value };
                case 'date_received':
                    return { title: 'Дата получения', value: col_value };
                case 'date_startby':
                    return { title: 'Дата начала по заявке', value: col_value };
                case 'date_actual_start':
                    return { title: 'Фактическая дата начала', value: col_value };
                case 'date_end':
                    return { title: 'Дата окончания', value: col_value };
                case 'department_id':
                    return { title: 'УИК', value: this.cataloguesData.departments.find((element) => element.id == col_value).name };
                case 'client_name_id':
                    return { title: 'Заказчик', value: this.cataloguesData.clients.find((element) => element.id == col_value).name };
                case 'vendor_name_id':
                    return { title: 'Поставщик', value: this.cataloguesData.vendors.find((element) => element.id == col_value).name };
                case 'subvendor_name_id':
                    return { title: 'Субпоставщик', value: this.cataloguesData.subvendors.find((element) => element.id == col_value).name };
                case 'status_id':
                    return { title: 'Статус', value: this.cataloguesData.statuses.find((element) => element.id == col_value).name };
                case 'curator_id':
                    return { title: 'Куратор', value: this.cataloguesData.curators.find((element) => element.id == col_value).name };
                case 'inspector_id':
                    return { title: 'Инспектор', value: this.cataloguesData.inspectors.find((element) => element.id == col_value).name };
                case 'expired':
                    return { title: 'Просрочена', value: col_value ? 'Да' : 'Нет' };
                case 'comments':
                    return { title: 'Комментарии', value: col_value };
                case 'inspection_lvl':
                    return { title: 'Ур. инспекции', value: col_value };
                default:
                    return { title: col_name, value: col_value};
            }
        },
    },
    mounted() {
    this.fetchCatalogues();
  },
}

</script>

<style lang="scss">
    table table {
            border: 1px solid #000;
            & td {
                padding: 0.5em;
                border: 1px solid #000;
            }
        }
</style>
