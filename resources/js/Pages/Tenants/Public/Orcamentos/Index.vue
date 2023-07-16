<script setup>
import PublicGuestLayout from '@/Layouts/PublicGuestLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head, Link } from '@inertiajs/vue3';
import { generateRandomString } from '@resources/js/helpers/string/index'
import CustomSelect from '@/Components/custom-html/CustomSelect.vue'
import { ref } from 'vue';

const props = defineProps({
    selectedYear: {
        type: String,
    },
    tipoOrcamento: {
        type: String,
    },
});

let selectedYear = ref(props?.selectedYear ?? null)

let tipoOrcamento = ref(props?.tipoOrcamento || 'todos')

const orcamentosTipo = [
    {
        value: 'loa',
        label: 'LOA - Lei Orçamentária Anual',
        selected: tipoOrcamento.value == 'loa',
    },
    {
        value: 'ldo',
        label: 'LDO - Lei de Diretrizes Orçamentária',
        selected: tipoOrcamento.value == 'ldo',
    },
    {
        value: 'ppa',
        label: 'PPA - Plano Pluri Anual',
        selected: tipoOrcamento.value == 'ppa',
    },
];

console.log(orcamentosTipo);

let updateMessage = (event) => tipoOrcamento.value = event?.value || 'todos'

let latestYears = [
    '2023',
    '2022',
    '2021',
    '2020',
    '2019',
    '2018',
]
</script>

<template>
    <Head title="Profile" />

    <PublicGuestLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Profile</h2>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-0 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden">
                    <div>
                        <div class="flex mx-2 mb-4 space-x-4 text-xl border-b border-gray-300">
                            <template
                                v-for="year in latestYears"
                                :key="index"
                            >
                                <Link
                                    :href="route('tenants.public.orcamentos.index', {
                                        selectedYear: year,
                                        tipoOrcamento: tipoOrcamento,
                                    })"
                                    class="text-gray-600 dark:text-gray-100 cursor-pointer hover:text-indigo-600 py-2 px-1"
                                    :class="{'text-indigo-600 dark:text-indigo-600 border-b-4 border-indigo-600 bg-gray-50 pr-2': selectedYear == year}"
                                    @click="selectedYear = year"
                                >{{ year }}
                                </Link>
                            </template>
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="text-white mb-4">
                    <h2
                        class="text-xl text-gray-100 dark:text-gray-500"
                    >Filtros aplicados:</h2>
                    <div>
                        <p>Tipo orçamento:
                            <span class="text-gray-800 dark:text-gray-200 uppercase">
                                {{ tipoOrcamento }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <CustomSelect
                    class="w-full"
                    labelClass="text-gray-800 dark:text-gray-300"
                    emptyOption="Todos"
                    :value="tipoOrcamento"
                    label="Filtrar por tipo de orçamento"
                    @updated-value="updateMessage"
                    :options="orcamentosTipo"
                />
            </div>
        </div>
    </PublicGuestLayout>
</template>
