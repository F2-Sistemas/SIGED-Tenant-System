<script setup>
import PublicGuestLayout from "@/Layouts/PublicGuestLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { generateRandomString } from "@resources/js/helpers/string/index";
import CustomSelect from "@/Components/custom-html/CustomSelect.vue";
import { ref } from "vue";
import { computed } from "vue";
import collect from "collect.js";
import { Dropdown, ListGroup, ListGroupItem } from "flowbite-vue";
// import { Accordion, AccordionPanel, AccordionHeader, AccordionContent } from 'flowbite-vue'
import {
    Accordion,
    AccordionPanel,
    AccordionHeader,
    AccordionContent,
} from "flowbite-vue";

const laravelRequest = usePage()?.props?.laravelRequest;
const props = defineProps({
    selectedYear: {
        type: String,
    },
    orcamentoTipos: {
        type: Object,
        required: true,
    },
    orcamentos: {
        type: Object,
        required: true,
    },
    latestYears: {
        type: Object,
        required: true,
    },
    pageTitle: {
        type: String,
    },
    selectedYear: {
        type: String,
    },
    tipoOrcamento: {
        type: String,
    },
});

let selectedYear = ref(props?.selectedYear ?? null);

let tipoOrcamento = ref(props?.tipoOrcamento || "todos");

const orcamentosTipoList = computed(() =>
    props?.orcamentoTipos.map((item) => ({ ...item, value: item.key }))
);

const activeTipoOrcamento = computed(() =>
    collect(orcamentosTipoList.value)?.firstWhere(
        "key",
        "==",
        tipoOrcamento.value
    )
);

let orcamentoSearchFilter = ref(laravelRequest?.query?.search || "");

const activeQuery = computed(
    () =>
        collect({
            search: orcamentoSearchFilter.value,
        }).filter((item) => !!item)?.items || {}
);

let updateMessage = (event) => (tipoOrcamento.value = event?.value || "todos");

let latestYears = ref(props?.latestYears || []);
let orcamentos = ref(props?.orcamentos || []);
</script>

<template>
    <PublicGuestLayout :pageTitle="pageTitle">
        <template #header>
            <Link href="/">
                <h2
                    class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight text-center"
                >
                    {{ pageTitle || $page.props.appName }}
                </h2>
            </Link>
        </template>

        <div class="py-4">
            <div class="max-w-7xl mx-auto px-2 space-y-6">
                <div
                    class="p-0 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden"
                >
                    <div
                        class="flex mx-0 mb-4 space-x-4 text-xl border-b border-gray-300"
                    >
                        <template v-for="year in latestYears" :key="index">
                            <Link
                                :href="
                                    route('tenants.public.orcamentos.index', [
                                        year,
                                        activeTipoOrcamento?.value,
                                        activeQuery,
                                    ])
                                "
                                class="text-gray-600 dark:text-gray-100 cursor-pointer hover:text-indigo-600 py-2 px-1"
                                :class="{
                                    'text-indigo-600 dark:text-indigo-600 border-b-4 border-indigo-600 bg-gray-50 pr-2':
                                        selectedYear == year,
                                }"
                                @click="selectedYear = year"
                                >{{ year }}
                            </Link>
                        </template>
                    </div>
                </div>
            </div>

            <div
                class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6 text-gray-800 dark:text-gray-200"
            >
                <div class="text-gray-800 dark:text-gray-200 mb-4">
                    <h2 class="text-xl">Filtros aplicados:</h2>
                    <div>
                        <p>
                            Tipo orçamento:
                            <span
                                class="text-gray-800 dark:text-gray-200 uppercase"
                            >
                                {{ tipoOrcamento }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6">
                <div class="grid grid-cols-10 gap-2">
                    <div class="col-span-5 md:col-span-4">
                        <CustomSelect
                            class="cursor-pointer"
                            labelClass="text-gray-800 dark:text-gray-300"
                            emptyOption="Todos"
                            :value="tipoOrcamento"
                            label="Filtrar por tipo de orçamento"
                            @updated-value="updateMessage"
                            :options="orcamentosTipoList"
                        />
                    </div>

                    <div class="col-span-5 md:col-span-6">
                        <div class="grid grid-cols-12 gap-1 py-1 w-full">
                            <div class="col-span-11 mr-0">
                                <label
                                    class="text-gray-800 dark:text-gray-300"
                                    for="orcamentoSearchFilter"
                                >
                                    Filtar itens que contenham:
                                    <span
                                        class="italic text-sm font-medium text-slate-700 bg-slate-100 rounded-md py-0 px-2 dark:text-gray-500 transition-opacity duration-[1.5s] delay-500"
                                        v-if="orcamentoSearchFilter"
                                    >
                                        "{{ orcamentoSearchFilter }}"
                                    </span>
                                </label>

                                <input
                                    class="px-4 py-3 w-full rounded-md text-gray-800 bg-gray-100 border-transparent active:border-gray-500 active:bg-white active:ring-0 text-sm dark:bg-gray-700 dark:active:bg-gray-900 dark:text-gray-50"
                                    type="text"
                                    name="search"
                                    placeholder="Pesquise por textos, títulos etc"
                                    id="orcamentoSearchFilter"
                                    v-model="orcamentoSearchFilter"
                                />
                            </div>

                            <div
                                class="col-span-1 pt-4 _-ml-6 text-center px-0 mx-0"
                                v-show="orcamentoSearchFilter"
                            >
                                <div class="pt-2 _-ml-3 mt-1">
                                    <button
                                        class="inline-flex px-2 py-2 pt-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 outline-none active:outline-none focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                        type="button"
                                        @click="orcamentoSearchFilter = ''"
                                    >
                                        <span
                                            class="text-center md:pl-1 pt-1 w-full"
                                            >X</span
                                        >
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6">
                <dropdown text="Click me" placement="bottom">
                    <list-group>
                        <list-group-item>Item #1</list-group-item>
                        <list-group-item>Item #2</list-group-item>
                        <list-group-item>Item #3</list-group-item>
                    </list-group>
                </dropdown>
            </div>
            -->

            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6 my-4">
                <Accordion always-open v-if="orcamentos && orcamentos.length">
                    <template v-for="orcamento in orcamentos" v-key="index">
                        <AccordionPanel>
                            <AccordionHeader>header</AccordionHeader>
                            <AccordionContent>
                                <div>
                                    <p
                                        class="mb-2 text-gray-500 dark:text-gray-400"
                                    >
                                        Flowbite is an open-source library of
                                        interactive components built on top of
                                        Tailwind CSS including buttons,
                                        dropdowns, modals, navbars, and more.
                                    </p>
                                    <p class="text-gray-500 dark:text-gray-400">
                                        Check out this guide to learn how to
                                        <a
                                            href="/docs/getting-started/introduction/"
                                            class="text-blue-600 dark:text-blue-500 hover:underline"
                                            >get started</a
                                        >
                                        and start developing websites even
                                        faster with components on top of
                                        Tailwind CSS.
                                    </p>
                                </div>
                            </AccordionContent>
                        </AccordionPanel>
                    </template>
                </Accordion>
                <template v-else>
                    <div>
                        <h4
                            class="font-semibold text-1xl text-gray-800 dark:text-gray-400 leading-tight text-center"
                        >
                            Sem registro
                        </h4>
                    </div>
                </template>
            </div>
        </div>
    </PublicGuestLayout>
</template>
