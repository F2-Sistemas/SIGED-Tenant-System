<script setup>
import { computed, ref } from "vue";
import { generateRandomString } from "@resources/js/helpers/string/index";

const props = defineProps({
    accordionWrapperId: {
        type: String,
        required: true
    },
    id: {
        type: String,
    },
    ariaExpanded: {
        type: Boolean,
        default: false
    },
    isFirst: {
        type: Boolean,
        default: false
    },
    isLast: {
        type: Boolean,
        default: false
    },
});

let prefix = 'flowbite-accordion-';

const itemId = computed(() => {
    return prefix + (props.id || generateRandomString(15));
});

// const accordionId = computed(() => itemId.value);
let getExpanded = ref(props.ariaExpanded)
</script>

<template>
    <h2
        :id="`${prefix}-header-${itemId}`"
    >
        <button
            type="button"
            class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:none dark:focus:none dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700"

            :class="{
                'rounded-t-xl': isFirst,
            }"
            :data-accordion-target="`#${itemId}`"
            :aria-expanded="getExpanded"
            @click="getExpanded = !getExpanded"
            :aria-controls="itemId"
        >
            <span class="flex items-center">
                <slot name="header-icon"></slot>
                <slot name="header"></slot>
            </span>
            <svg
                data-accordion-icon
                class="w-3 h-3 rotate-180 shrink-0"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 10 6"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5 5 1 1 5"
                />
            </svg>
        </button>
    </h2>

    <div
        :id="itemId"
        class="hidden"
        :aria-labelledby="itemId"
    >
        <div
            class="p-5 border border-gray-200 dark:border-gray-700 dark:bg-gray-900"
        >
            <slot name="content"></slot>
            <!--
            <p class="mb-2 text-gray-500 dark:text-gray-400">
                Flowbite is an open-source library of interactive components
                built on top of Tailwind CSS including buttons, dropdowns,
                modals, navbars, and more.
            </p>
            <p class="text-gray-500 dark:text-gray-400">
                Check out this guide to learn how to
                <a
                    href="/docs/getting-started/introduction/"
                    class="text-blue-600 dark:text-blue-500 hover:underline"
                    >get started</a
                >
                and start developing websites even faster with components on top
                of Tailwind CSS.
            </p>
            -->
        </div>
    </div>
</template>
