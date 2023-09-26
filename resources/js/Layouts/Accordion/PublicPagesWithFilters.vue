<script setup>
import PublicGuestLayout from "@/Layouts/PublicGuestLayout.vue";
import { range } from "@resources/js/helpers/string/index";
import {
    generateRandomString,
    _toString,
    _toArray,
} from "@resources/js/helpers/string/index";
import { Head, Link, usePage } from "@inertiajs/vue3";
import CustomSelect from "@/Components/custom-html/CustomSelect.vue";
import { ref, computed } from "vue";
import collect from "collect.js";
import HTMLHelpers from "@resources/js/helpers/html-helpers/index";

const laravelRequest = usePage()?.props?.laravelRequest;
const props = defineProps({
    selectedYear: {
        type: String,
    },
    yearList: {
        type: Object,
    },
    pageTitle: {
        type: String,
    },
    selectedYear: {
        type: String,
    },
    toSearch: {
        type: String,
    },
});
let getToSearch = ref(props?.toSearch ?? null);

// const activeQuery = computed(
//     () =>
//         collect({
//             search: getToSearch.value,
//         }).filter((item) => !!item)?.items || {}
// );

let currentYeart = parseInt((new Date()).getFullYear());

let selectedYear = ref(props?.selectedYear ?? currentYeart);
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
            <div
                class="max-w-7xl mx-auto px-2 space-y-6"
            >
                <div
                    v-if="yearList"
                    class="p-0 bg-white dark:bg-gray-800 shadow sm:rounded-lg overflow-hidden flex mx-0 mb-4 space-x-4 text-xl border-b border-gray-300"
                >
                    <template
                        v-for="year in yearList" :key="index"
                    >
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

                <slot />
            </div>
        </div>
    </PublicGuestLayout>
</template>
