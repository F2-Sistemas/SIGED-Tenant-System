<script setup>
import { computed, ref } from "vue";
import { generateRandomString } from "@resources/js/helpers/string/index";
import PlusAndMinusIcons from "@resources/js/Components/icons/generic/PlusAndMinusIcons.vue";

const props = defineProps({
    accordionWrapperId: {
        type: String,
        required: true
    },
    id: {
        type: String,
    },
    class: {
        type: String,
    },
    cornerSize: {
        type: String,
        default: 'md' //sm|md|xl
    },
    accordionMode: {
        type: String,
        default: 'collapse'
    },
    alwaysOpen: {
        type: Boolean,
        default: false
    },
    ariaExpanded: {
        type: Boolean,
        default: false
    },
    roundedTop: {
        type: Boolean,
        default: true
    },
    roundedBottom: {
        type: Boolean,
        default: true
    },
    headerClass: [String, Number, Object],
    isFirst: {
        type: Boolean,
        default: false
    },
    isLast: {
        type: Boolean,
        default: false
    },
});

const getAccordionMode = computed(() => {
    if (props.alwaysOpen) {
        return "open";
    }

    return ['open', 'collapse'].includes(props.accordionMode) ? props.accordionMode : 'collapse';
});

const itemId = computed(() => {
    let prefix = 'flowbite-accordion-';
    return prefix + (props.id || generateRandomString(15));
});

// const accordionId = computed(() => itemId.value);
let getExpanded = ref(props.ariaExpanded)
</script>

<template>
    <div
        :class="class"
        :data-accordion="getAccordionMode"
    >
        <button
            type="button"
            :id="`${prefix}-header-${itemId}`"
            :class="[
                'flex items-center justify-between w-full font-medium',
                'border border-gray-200 focus:none dark:focus:none dark:border-gray-700',
                'text-left text-gray-500 dark:text-gray-400',
                'hover:bg-gray-100 dark:hover:bg-gray-700',
                ...(
                    roundedBottom ? [
                        (isFirst || roundedTop) ? `rounded-t-${cornerSize}` : '',
                        !getExpanded ? `rounded-b-${cornerSize}` : 'rounded-b-0',
                        ] : []
                ),
                {
                    'border-b-0': getExpanded,
                    'bg-gray-200 dark:bg-gray-800': getExpanded,
                },
                'px-3 py-2',
                headerClass,
            ]"

            :data-accordion-target="`#${itemId}`"
            :aria-expanded="getExpanded"
            @click="getExpanded = !getExpanded"
            :aria-controls="itemId"
        >
            <span class="flex items-center">
                <slot v-if="$slots.headerIcon" name="headerIcon"></slot>
                <template v-else>
                    <span class="pr-3 text-gray-900 dark:text-white">
                        <PlusAndMinusIcons
                            :icon="getExpanded ? 'minus' : 'plus'"
                        />
                    </span>
                </template>
                <slot name="header"></slot>
            </span>
            <svg
                data-accordion-icon
                class="w-3 h-3 shrink-0"
                :class="{
                    'rotate-180': getExpanded,
                }"
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

        <div
            :id="itemId"
            class="hidden"
            :class="[
                'border border-1 border-gray-200 focus:none dark:focus:none dark:border-gray-700',
                'dark:text-gray-400',
            ]"
            :aria-labelledby="itemId"
        >
            <slot name="content"></slot>
        </div>
    </div>
</template>
