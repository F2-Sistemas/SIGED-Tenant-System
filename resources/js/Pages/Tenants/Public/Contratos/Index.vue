<script setup>
import PublicPagesWithFilters from "@/Layouts/Accordion/PublicPagesWithFilters.vue";
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
import { range } from "@resources/js/helpers/string/index";
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
    props?.orcamentoTipos?.map((item) => ({ ...item, value: item.key }))
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
    return JSON.parse(JSON.stringify(data));
};

let orcamentos = computed(() => {
    let orcamentos = props?.orcamentos || [];
    let mappedOrcamentos = {};
    orcamentos.map((item) => {
        if (
            !mappedOrcamentos[item.tipoValue] ||
            !("items" in (mappedOrcamentos[`${item.tipoValue}`] ?? {}))
        ) {
            // console.log('item:', JSON.parse(JSON.stringify(item)));
            console.log("item:", _toArray(item));
            mappedOrcamentos[item.tipoValue] = {
                key: item.tipoValue,
                label: [
                    item.tipoTranslatedValue,
                    item.exercicio ? item.exercicio : "",
                ].join(" | "),
                items: [],
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
    let tipos = collect(orcamentosTipoList.value).pluck("key").toArray();

    let items = orcamentos.value;

    if (tipos.includes(tipoOrcamento.value)) {
        console.log(tipos.includes(tipoOrcamento.value));
        items = items.filter((item) => item.key == tipoOrcamento.value);
    }

    return items.filter((item) => {
        let div = document.createElement("div");
        div.innerHTML = [
            // item.tipoTranslatedValue,
            // item.tipoValue,
            // item.exercicio,
            item.key,
            item.label,
        ]
            .join(" ")
            .trim();

        // console.log('div.innerHTML', div.innerHTML, `|${div.innerHTML}|`, div.innerHTML.length, item);
        console.clear();
        let localItems = item.items;
        console.log("antes do filtro", localItems);
        localItems;
        console.log("depois do filtro", localItems);
        let allContent = (item.tipoValue + " " + div.textContent).toLowerCase();
        let includesText = allContent.includes(searchBy);
        let contains =
            includesText ||
            item.tipoValue === searchBy ||
            (item.tags || []).includes(searchBy);
        return contains;
    });
});

let orcamentoWrapperId = generateRandomString(15);

let getAccordionMode = ref(() => {
    // return "collapse";
    return "open";
});

let fakeItem1 = ref(range(0, 4)?.reverse());
let fakeItem2 = ref(range(0, 6)?.reverse());
console.log(_toArray(props?.latestYears));
</script>

<template>
    <PublicPagesWithFilters
        :yearList="latestYears"
        :selectedYear="selectedYear"
    >
        <div
            :id="`orcamentoWrapperId`"
            :data-accordion="`open`"
            class="max-w-7xl mx-auto sm:px-2 lg:px-4 mb-4"
        >
            <AccordionItem
                v-for="(fakeMonthItem, fakeMonthItem_index) in fakeItem1"
            >
                <template v-slot:header> Titulo </template>
                <template v-slot:content>
                    <h4
                        :class="[
                            'grid items-start grid-cols-10 gap-2 gap-x-2',
                            'px-2 py-3 text-md text-center tracking-wider',
                            'divide-x divide-solid',
                            'border border-1 border-x-0 border-t-0 border-gray-400 dark:border-gray-400',
                        ]"
                    >
                        Algo
                    </h4>
                    <div
                        v-for="(fakeItem, fakeItem_index) in fakeItem2"
                        :class="[
                            'px-2',
                            'py-1',
                            { 'pt-2': fakeItem_index == 0 }, // se é o primeiro item
                            { 'pb-2': fakeItem_index == (fakeItem2.length -1) }, // se é o último item
                            'bg-gray-50',
                            'dark:bg-gray-900',
                        ]"
                    >
                        <BasicAccordion
                            :id="`details_aaa_${fakeItem_index}`"
                            :contentClass="['p-2']"
                            :openFirstItem="true"
                        >
                            <template v-slot:header>Descrição</template>

                            <template v-slot:content>
                                <div class="py-1">
                                    <p>algo no sub item</p>
                                </div>
                            </template>
                        </BasicAccordion>
                    </div>
                </template>
            </AccordionItem>
        </div>
    </PublicPagesWithFilters>
</template>
