<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import 'flowbite';
import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})

const page = usePage()

const props = defineProps({
    pageTitle: {
        type: String,
    },
    headTitle: {
        type: String,
    },
    verticalCentered: {
        type: Boolean,
        default: false
    },
    horizontalCentered: {
        type: Boolean,
        default: false
    },
    fullCentered: {
        type: Boolean,
        default: false
    },
});

let computedPageTitle = computed(() => props?.pageTitle || page.props.appName)
let computedHeadTitle = computed(() => props?.headTitle || computedPageTitle.value)
</script>

<template>
    <Head :title="computedHeadTitle" />

    <div
        class="px-8 min-h-screen flex flex-col pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900"
        :class="{
            'sm:justify-center': fullCentered || verticalCentered,
            'items-center': fullCentered || horizontalCentered,
        }"
    >
        <div
            class="mt-4"
        >
            <template  v-if="$slots.header" >
                <slot name="header" />
            </template>
            <template v-else>
                <template v-if="computedPageTitle">
                    <Link href="/">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ $page.props.appName }}</h2>
                    </Link>
                </template>
            </template>
        </div>

        <div
            class="w-full mt-6 px-3 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
