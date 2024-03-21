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
                                    <details v-if="Object.entries(row.old_values).length > 0">
                                        <summary>Развернуть</summary>
                                            <table border="1">
                                                <tr v-for="[key, value] of Object.entries(row.old_values)" :key="key">
                                                    <td>{{ this.db_legend(key) }}</td>
                                                    <td>{{ value }}</td>
                                                </tr>
                                            </table>
                                    </details>
                                </td>
                                <td>
                                    <details v-if="Object.entries(row.new_values).length > 0">
                                        <summary>Развернуть</summary>
                                            <table border="1">
                                                <tr v-for="[key, value] of Object.entries(row.new_values)" :key="key">
                                                    <td>{{ this.db_legend(key) }}</td>
                                                    <td>{{ value }}</td>
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

        };
    },
    computed: {
        currentData() {
            return this.history ? this.history.data : [];
        },
    },
    methods: {
        getUserName(custom_id) {
            const find_result = this.users.find(element => element.id === custom_id);
            return find_result ? find_result.name : null;
            // return null;
        },
        db_legend(col_name) {
            switch (col_name) {
                case 'client_entry_num':
                    return 'Номер заявки';
                case 'date_received':
                    return 'Дата получения';
                case 'date_startby':
                    return 'Дата начала по заявке';
                case 'date_actual_start':
                    return 'Фактическая дата начала';
                case 'date_end':
                    return 'Дата окончания';
                case 'department_id':
                    return 'УИК';
                case 'client_name_id':
                    return 'Заказчик';
                case 'vendor_name_id':
                    return 'Поставщик';
                case 'subvendor_name_id':
                    return 'Субпоставщик';
                case 'status_id':
                    return 'Статус';
                case 'curator_id':
                    return 'Куратор';
                case 'inspector_id':
                    return 'Инспектор';
                case 'expired':
                    return 'Просрочена';
                case 'comments':
                    return 'Комментарии';
                case 'inspection_lvl':
                    return 'Уровень инспекции';
                default:
                    return col_name;
            }
        },
    },
    mounted() {
        // console.log('entries:', this.entries);
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
