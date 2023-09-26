<script setup>
import PublicGuestLayout from "@/Layouts/PublicGuestLayout.vue";
import { Head, Link, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import collect from "collect.js";
import URLHelpers, { URLParam } from "@resources/js/helpers/url-helpers/index";

const laravelRequest = usePage()?.props?.laravelRequest;
const props = defineProps({
    selectedYear: {
        type: String,
    },
    contracts: {
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
});

let selectedYear = ref(props?.selectedYear ?? null);

let querySearch = ref(laravelRequest?.query?.search || "");

let latestYears = ref(props?.latestYears || []);

const _toArray = (data) => {
    return JSON.parse(JSON.stringify(data));
};
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

        <pre
            v-html="JSON.stringify(contracts, null, 4)"
            :class="[
                'text-gray-500',
                'dark:text-white',
            ]"
        ></pre>
    </PublicGuestLayout>
</template>
