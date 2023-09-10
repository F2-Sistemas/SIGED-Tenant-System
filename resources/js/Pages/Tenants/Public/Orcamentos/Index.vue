<script setup>
import PublicGuestLayout from "@/Layouts/PublicGuestLayout.vue";
import DeleteUserForm from "./Partials/DeleteUserForm.vue";
import UpdatePasswordForm from "./Partials/UpdatePasswordForm.vue";
import UpdateProfileInformationForm from "./Partials/UpdateProfileInformationForm.vue";
import { generateRandomString } from "@resources/js/helpers/string/index";
import { Head, Link, usePage } from "@inertiajs/vue3";
import CustomSelect from "@/Components/custom-html/CustomSelect.vue";
import { ref, computed } from "vue";
import collect from "collect.js";
import { Dropdown, ListGroup, ListGroupItem } from "flowbite-vue";
import URLHelpers, { URLParam } from "@resources/js/helpers/url-helpers/index";
import HTMLHelpers from "@resources/js/helpers/html-helpers/index";
import CustomAccordion from "@resources/js/Components/flowbite/accordion/CustomAccordion.vue";
import BasicAccordion from "@resources/js/Components/flowbite/accordion/BasicAccordion.vue";
import AccordionItem from "@resources/js/Components/flowbite/accordion/AccordionItem/AccordionItem.vue";
import HelpIcon from "@resources/js/Components/icons/generic/HelpIcon.vue";
// import { Accordion, AccordionPanel, AccordionHeader, AccordionContent } from 'flowbite-vue'
import {
    Accordion,
    AccordionPanel,
    AccordionHeader,
    AccordionContent,
} from "flowbite-vue";

// selectedYear
// tipoOrcamento

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

let tipoOrcamento = ref(props?.tipoOrcamento || "");

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

let updateMessage = function (event) {
    let value = (tipoOrcamento.value = event?.value || "");

    let lastPath = URLHelpers.paths.lastPath();

    if (!value || value === "" || lastPath === value) {
        URLHelpers.params.remove("tipoOrcamento");
        return;
    }

    URLHelpers.params.set("tipoOrcamento", value);
};

let latestYears = ref(props?.latestYears || []);
// let orcamentos = ref(props?.orcamentos || []);

const _toArray = (data) => {
    return (JSON.parse(JSON.stringify(data)));
}

let orcamentos = computed(() => {
    let orcamentos = (props?.orcamentos || []);
    let mappedOrcamentos = {};
    orcamentos.map(item =>{
        if (!(mappedOrcamentos[item.tipoValue]) || !('items' in (mappedOrcamentos[`${item.tipoValue}`] ?? {}))) {
            // console.log('item:', JSON.parse(JSON.stringify(item)));
            console.log('item:', _toArray(item));
            mappedOrcamentos[item.tipoValue] = {
                key: item.tipoValue,
                label: [item.tipoTranslatedValue, item.exercicio ? item.exercicio : ''].join(' | '),
                items: []
            };
        }

        mappedOrcamentos[item.tipoValue].items.push(item);
    });

    mappedOrcamentos = Object.values(mappedOrcamentos);
    console.log(mappedOrcamentos);

    return mappedOrcamentos;
});

console.log(JSON.parse(JSON.stringify(orcamentos.value)));

const classConformTagList = {
    all: {},
    accordion: {
        a: {
            classList: "text-blue-600 dark:text-blue-500 hover:underline",
            target: "_self",
        },
    },
};

let openFirstItem = selectedYear.value == 2020;

let strippedText = `Check out this guide to learn how to <a href="/docs/getting-started/introduction/">get started</a>
and start developing websites even faster with components on top of Tailwind CSS.`;

/* *
let orcamentos = ref([
    {
        header: "Item #1",
        content: [
            'Paragraph #1 of item #2 123',
            'Paragraph #2 of item #2 456 <a href="#some-here">link</a>',
            'Paragraph #3 of item #2 789',
        ],
        tags: ['tag1', 'algo1'],
    },
    {
        header: "Item #2",
        content: [
            'Paragraph #1 of item #2 123',
            'Paragraph #2 of item #2 456 <a href="#some-here">link</a>. Conteudo continua.',
            'Paragraph #2 of item #2 456 <a href="#some-here">link</a>. Conteudo continua.',
            'Paragraph #2 of item #2 456 <a href="#some-here">link</a>. Conteudo continua.',
            'Paragraph #2 of item #2 456 <a href="#some-here">link</a>. Conteudo continua.',
        ],
        tags: ['tag2', 'algo2'],
    },
    {
        header: "Item #3",
        content: [
            'Paragraph #1 of item #3 123',
            'Paragraph #2 of item #3 456 <a href="#some-here">link</a>. Conteudo continua.',
            'Paragraph #2 of item #3 456 <a href="#some-here">link</a>. Conteudo continua.',
            'Paragraph #2 of item #3 456 <a href="#some-here">link</a>. Conteudo continua.',
            'Paragraph #2 of item #3 456 <a href="#some-here">link</a>. Conteudo continua.',
        ],
        tags: ['tag3', 'algo3'],
        tipo: 'ldo',
    },
]);
/**/

let getOrcamentos = computed(() => {
    // return orcamentos.value;
    let searchBy = String(orcamentoSearchFilter.value).toLowerCase();
    let tipos = collect(orcamentosTipoList.value).pluck('key').toArray();

    let items = orcamentos.value;

    if (tipos.includes(tipoOrcamento.value)) {
        console.log(tipos.includes(tipoOrcamento.value));
        items = items.filter(item => item.key == tipoOrcamento.value);
    }

    return items.filter(item => {
        let div = document.createElement('div');
        div.innerHTML = [
            // item.tipoTranslatedValue,
            // item.tipoValue,
            // item.exercicio,
            item.key,
            item.label,
        ].join(' ').trim();

        // console.log('div.innerHTML', div.innerHTML, `|${div.innerHTML}|`, div.innerHTML.length, item);
        console.clear();
        let localItems = item.items;
        console.log('antes do filtro', localItems);
        localItems
        console.log('depois do filtro', localItems);
        let allContent = (item.tipoValue + ' ' + div.textContent).toLowerCase();
        let includesText = allContent.includes(searchBy);
        let contains =  includesText || item.tipoValue === searchBy || (item.tags || []).includes(searchBy);
        return contains;
    });
});

let orcamentoWrapperId = generateRandomString(15);

let getAccordionMode = ref(() => {
    // return "collapse";
    return "open";
});
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
                v-html="
                    HTMLHelpers.conformParaph(
                        strippedText,
                        classConformTagList.accordion,
                        true
                    )
                "
            ></div>

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
                                {{ tipoOrcamento ? tipoOrcamento : 'Todos' }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6 mb-4">
                <div class="grid grid-cols-10 gap-2">
                    <div class="col-span-5 md:col-span-4">
                        <CustomSelect
                            class="cursor-pointer"
                            :labelClass="`text-gray-800 dark:text-gray-300 tipoOrcamento-${tipoOrcamento}`"
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
                                    Filtrar itens que contenham:
                                    <span
                                        class="italic text-sm font-medium text-slate-700 bg-slate-100 rounded-md mx-0 py-0 px-1 pr-2 dark:text-gray-500 transition-opacity duration-[1.5s] delay-500"
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
                                            >X</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--
            <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6 mb-4">
                <dropdown text="Click me" placement="bottom">
                    <list-group>
                        <list-group-item>Item #1</list-group-item>
                        <list-group-item>Item #2</list-group-item>
                        <list-group-item>Item #3</list-group-item>
                    </list-group>
                </dropdown>
            </div>
            -->

            <div
                :id="orcamentoWrapperId"
                :data-accordion="getAccordionMode"
                class="max-w-7xl mx-auto sm:px-2 lg:px-4 mb-4"
            >
                <AccordionItem
                    v-for="(orcamento, orcamentoIndex) in getOrcamentos"
                    v-key="orcamentoIndex"
                    :accordionWrapperId="orcamentoWrapperIds"
                    :isFirst="orcamentoIndex == 0"
                    :isLast="orcamentoIndex == (getOrcamentos.length - 1)"
                    roundedTop
                    roundedBottom
                    class="mb-2"
                >
                    <!-- <template v-slot:headerIcon>
                        <HelpIcon />
                    </template> -->

                    <template v-slot:header>
                        <span class="uppercase" v-html="orcamento.label"></span>
                    </template>

                    <template v-slot:content>
                        <div
                            :class="[
                                'text-gray-500 bg-gray-50 dark:bg-gray-900 dark:text-white p-2 mt-1',
                            ]"
                        >
                            <template
                                v-for="(orcamentoItemList, orcamentoItemListIndex) in orcamento.items"
                                v-key="orcamentoItemListIndex"
                            >
                                <div
                                    :class="[
                                        'w-full overflow-hidden mb-3',
                                        'border border-gray-200 dark:border-gray-700',
                                        'text-xs font-semibold tracking-wide text-left',
                                        'bg-gray-100 dark:bg-gray-700 dark:text-white',
                                    ]"
                                >
                                    <h4
                                        :class="[
                                            'grid items-start grid-cols-10 gap-2 gap-x-2',
                                            'px-2 py-3 text-md text-center tracking-wider',
                                            'divide-x divide-solid',
                                            'border border-1 border-x-0 border-t-0 border-gray-400 dark:border-gray-400',
                                        ]"
                                    >
                                        <span
                                            class="col-span-1 uppercase"
                                            v-if="orcamentoItemList.tipoValue"
                                        >
                                            {{ orcamentoItemList.tipoValue }}
                                        </span>

                                        <span class="col-span-2">
                                            Exercício: {{
                                                orcamentoItemList?.exercicio
                                                || orcamentoItemList?.ano_vigencia_fim
                                            }}
                                        </span>

                                        <a :href="`#${orcamentoItemList?.ano_vigencia_fim}`" >Anexo</a>

                                        <span class="col-span-4">Publicado no Diário Oficial Nº 104 [TODO]</span>
                                    </h4>

                                    <div
                                        class="px-2 pb-1 pt-2 bg-gray-50 dark:bg-gray-900"
                                        v-for="(orcamentoItemListItem, orcamentoItemListItem_index) in orcamentoItemList.items"
                                        v-key="orcamentoItemListItem_index"
                                    >

                                        <BasicAccordion
                                            :id="`details_${orcamentoItemListIndex}`"
                                            :contentClass="['p-2']"
                                            :openFirstItem="true"
                                        >
                                            <template v-slot:header>Descrição</template>

                                            <template v-slot:content>
                                                <div class="py-1">
                                                    <p v-if="orcamentoItemListItem.content" v-html="orcamentoItemListItem.content"></p>
                                                </div>
                                            </template>
                                        </BasicAccordion>

                                        <template
                                            v-if="Boolean(
                                                    orcamentoItemListItem?.aditional_data
                                                    && Object.keys(orcamentoItemListItem?.aditional_data).length
                                            )"
                                        >
                                            <BasicAccordion
                                                v-if="orcamentoItemList?.items?.length"
                                                class="mt-2 mb-1 p-0"
                                                :contentClass="['p-0']"
                                                :id="`aditional_${orcamentoItemListIndex}`"
                                                :headerClass="[
                                                    //'border border-1 border-gray-400 dark:border-gray-100',
                                                    //'rounded',
                                                    // 'col-span-1 uppercase',
                                                ]"
                                            >
                                                <template v-slot:header>
                                                    Informaçãoes adicionais
                                                </template>

                                                <template v-slot:content>
                                                    <div
                                                        :class="[
                                                            'w-full overflow-hidden',
                                                            //'rounded-md shadow-sm',
                                                            'border-1 border-gray-200 dark:border-gray-700',
                                                            'm-0 px-0',
                                                            'bg-gray-100 dark:bg-gray-600',
                                                        ]"
                                                    >
                                                        <table
                                                            :class="[
                                                                'w-full whitespace-no-wrap',
                                                                'border border-gray-200 dark:border-gray-700',
                                                            ]"
                                                        >
                                                            <tbody
                                                                :class="[
                                                                    'bg-white text-gray-700 divide-y',
                                                                    'dark:bg-gray-800 dark:text-white',
                                                                ]"
                                                            >
                                                                <template
                                                                    v-for="(adi, adiKey) in orcamentoItemListItem?.aditional_data"
                                                                    v-key="adiKey"
                                                                >
                                                                    <tr class="hover:bg-gray-500" >
                                                                        <th
                                                                            class="px-4 py-3 text-left"
                                                                            v-text="adiKey"
                                                                        ></th>
                                                                        <td
                                                                            class="px-4 py-3"
                                                                            v-text="adi"
                                                                        ></td>
                                                                    </tr>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </template>
                                            </BasicAccordion>
                                        </template>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </template>
                </AccordionItem>
                <div
                    v-if="!(getOrcamentos.length)"
                    :class="[
                        'block pt-4 pb-5 mx-auto mb-4 text-gray-500 dark:text-gray-400 text-center',
                        'border border-gray-200 focus:none dark:focus:none dark:border-gray-700',
                        'rounded-xl',
                    ]"
                >Sem itens</div>
            </div>

            <!-- <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6 my-4">
                <Accordion
                    _always-open
                    v-if="orcamentos && orcamentos.length"
                    :open-first-item="false"
                >
                    <AccordionPanel v-for="(orcamento, index) in orcamentos" v-key="index">
                        <AccordionHeader
                            :class="{
                                'border-b-1': index == orcamentos.length -1,
                            }"
                        >header</AccordionHeader>
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
            </div> -->
        </div>
    </PublicGuestLayout>
</template>
