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
    accordionItems: accordionItem[],
    id ?: String,
    active ?: Boolean,
    alwaysOpen ?: Boolean,
    openFirstItem ?: Boolean,
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
    <div :id="itemId" :data-accordion="getAccordionMode">
        <AccordionItem
            v-for="(accordionItem, index) in getAccordionItems"
            v-key="index"
            :accordionWrapperId="itemId"
            :isFirst="index == 0"
            :isLast="index == getAccordionItems.length - 1"
        >
            <template v-slot:header-icon>
                <HelpIcon />
            </template>

            <template v-slot:header>
                <span v-html="accordionItem.header"></span>
            </template>

            <template v-slot:content>
                <template
                    v-for="(contentItem, contentItemIndex) in accordionItem.content"
                    v-key="contentItemIndex"
                >
                    <p
                        class="text-gray-500 dark:text-gray-400"
                        :class="{
                            'mb-2': contentItemIndex != accordionItem?.content?.length - 1,
                        }"
                        v-html="
                            HTMLHelpers.conformParaph(
                                contentItem,
                                classConformTagList.accordion,
                                true
                            )
                        "
                    >
                    </p>
                </template>
            </template>
        </AccordionItem>

        <!--
        <h2 id="accordion-open-heading-2">
            <button
                type="button"
                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                data-accordion-target="#accordion-open-body-2"
                :aria-expanded="getOpenFirstItem"
                aria-controls="accordion-open-body-2"
            >
                <span class="flex items-center"
                    ><svg
                        class="w-5 h-5 mr-2 shrink-0"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd"
                        ></path></svg
                    >Is there a Figma file available?</span
                >
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
            id="accordion-open-body-2"
            class="hidden"
            aria-labelledby="accordion-open-heading-2"
        >
            <div
                class="p-5 border border-b-0 border-gray-200 dark:border-gray-700"
            >
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    Flowbite is first conceptualized and designed using the
                    Figma software so everything you see in the library has a
                    design equivalent in our Figma file.
                </p>
                <p class="text-gray-500 dark:text-gray-400">
                    Check out the
                    <a
                        href="https://flowbite.com/figma/"
                        class="text-blue-600 dark:text-blue-500 hover:underline"
                        >Figma design system</a
                    >
                    based on the utility classes from Tailwind CSS and
                    components from Flowbite.
                </p>
            </div>
        </div>

        <h2 id="accordion-open-heading-3">
            <button
                type="button"
                class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                data-accordion-target="#accordion-open-body-3"
                :aria-expanded="getOpenFirstItem"
                aria-controls="accordion-open-body-3"
            >
                <span class="flex items-center"
                    ><svg
                        class="w-5 h-5 mr-2 shrink-0"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    What are the differences between Flowbite and Tailwind
                    UI?</span
                >
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
            id="accordion-open-body-3"
            class="hidden"
            aria-labelledby="accordion-open-heading-3"
        >
            <div
                class="p-5 border border-t-0 border-gray-200 dark:border-gray-700"
            >
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    The main difference is that the core components from
                    Flowbite are open source under the MIT license, whereas
                    Tailwind UI is a paid product. Another difference is that
                    Flowbite relies on smaller and standalone components,
                    whereas Tailwind UI offers sections of pages.
                </p>
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    However, we actually recommend using both Flowbite, Flowbite
                    Pro, and even Tailwind UI as there is no technical reason
                    stopping you from using the best of two worlds.
                </p>
                <p class="mb-2 text-gray-500 dark:text-gray-400">
                    Learn more about these technologies:
                </p>
                <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
                    <li>
                        <a
                            href="https://flowbite.com/pro/"
                            class="text-blue-600 dark:text-blue-500 hover:underline"
                            >Flowbite Pro</a
                        >
                    </li>
                    <li>
                        <a
                            href="https://tailwindui.com/"
                            rel="nofollow"
                            class="text-blue-600 dark:text-blue-500 hover:underline"
                            >Tailwind UI</a
                        >
                    </li>
                </ul>
            </div>
        </div>
    --></div>
</template>
