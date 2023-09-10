<script setup>
import { computed } from "vue";
import { generateRandomString } from "@resources/js/helpers/string/index";

const props = defineProps({
    id: String,
    icon: String,
    class: String,
    headerClass: [String, Number, Object],
    size: [Number|String],
});

const itemId = computed(() => {
    return (props.id || generateRandomString(15));
});

const getSelectedIcon = computed(() => {
    if (!(['plus', 'minus'].includes(props?.icon))) {
        return '';
    }

    return props?.icon;
});

const getIconClass = computed(() => {
    return [
        'w-3',
        'h-3',
        'shrink-0',
    ];
});

const selectedIconIs = (expected = null) => {
    if (!expected) {
        return false;
    }

    return getSelectedIcon?.value === expected;
};
</script>

<template>
    <svg
        v-if="getSelectedIcon"
        :id="itemId"
        :class="getIconClass"
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="2"
        stroke="currentColor"
        aria-hidden="true"
    >
        <path
            v-if="selectedIconIs('plus')"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 4v16m8-8H4"
        />

        <path
            v-if="selectedIconIs('minus')"
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M20 12H4"
        />
    </svg>
</template>
