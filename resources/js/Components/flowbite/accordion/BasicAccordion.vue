<script setup lang="ts">
import { ref, computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { generateRandomString } from "@resources/js/helpers/string/index";
import AccordionItem from "@resources/js/Components/flowbite/accordion/AccordionItem/AccordionItem.vue";
import HelpIcon from "@resources/js/Components/icons/generic/HelpIcon.vue";
import URLHelpers, { URLParam } from "@resources/js/helpers/url-helpers/index";
import HTMLHelpers from "@resources/js/helpers/html-helpers/index";

type accordionItem = {
    header: string,
    content: string|string[],
}

const props = defineProps<{
    accordionItems?: accordionItem[],
    id ?: string,
    active ?: Boolean,
    alwaysOpen ?: Boolean,
    openFirstItem ?: Boolean,
    contentClass?: string|string[],
    headerClass?: string|string[],
    roundedBottom ?: Boolean,
}>();

/**
 * @see https://flowbite.com/docs/components/accordion/#default-accordion
 * data-accordion="collapse" show only one active child element
 * data-accordion="open" keep multiple elements open
 */
const getAccordionMode = computed(() => {
    if (props.alwaysOpen) {
        return "open";
    }

    return "collapse";
});

const itemId = computed(() => {
    let prefix = "flowbite-accordion-CustomAccordion-";
    return prefix + (props.id || generateRandomString(15));
});

const getOpenFirstItem = computed(() => {
    return props.openFirstItem ? "true" : "false";
});

let getAccordionItems = computed(() => props.accordionItems);

const classConformTagList = {
    all: {},
    accordion: {
        a: {
            classList: "text-blue-600 dark:text-blue-500 hover:underline",
            target: "_self",
        },
    },
};
</script>

<template>
    <AccordionItem
        v-if="getAccordionItems"
        v-for="(accordionItem, index) in getAccordionItems"
        v-key="index"
        :accordionMode="getAccordionMode"
        :isFirst="index == 0"
        :isLast="index == (getAccordionItems.length - 1)"
        :accordionWrapperId="itemId"
        :headerClass="headerClass"
        roundedBottom
    >
        <template v-if="$slots.headerIcon" v-slot:headerIcon>
            <slot name="headerIcon" ></slot>
        </template>

        <template v-slot:header>
            <div v-if="!$slots.header">{{ accordionItem.header }}</div>
            <slot v-else name="header" ></slot>
        </template>

        <template v-slot:content>
            <div v-if="!$slots.content">{{ accordionItem.content }}</div>
            <div
                v-else
                :class="[
                    'w-full overflow-hidden whitespace-no-wrap',
                    'border border-gray-200 dark:border-gray-700',
                    contentClass,
                ]"
            >
                <slot name="content" ></slot>
            </div>
        </template>
    </AccordionItem>

    <AccordionItem
        v-else
        :accordionMode="getAccordionMode"
        :accordionWrapperId="itemId"
        :headerClass="headerClass"
        roundedBottom
    >
        <template v-if="$slots.headerIcon" v-slot:headerIcon>
            <slot name="headerIcon" ></slot>
        </template>

        <template v-slot:header>
            <slot name="header" ></slot>
        </template>

        <template v-slot:content>
            <div
                v-if="$slots.content"
                :class="[
                    'w-full overflow-hidden whitespace-no-wrap',
                    'border border-gray-200 dark:border-gray-700',
                    contentClass,
                ]"
            >
                <slot name="content" ></slot>
            </div>
        </template>
    </AccordionItem>
</template>
