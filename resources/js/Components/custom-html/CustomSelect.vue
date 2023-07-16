<script setup lang="ts">
import { computed, ref } from "vue";
import { generateRandomString } from '@resources/js/helpers/string/index'

type Options = {
    value: string
    label: string
    selected?: boolean
}

interface Props {
    options: Options[],
    disabled?: boolean,
    required?: boolean,
    readonly?: boolean,
    label?: string,
    value?: string,
    labelClass?: string|object,
    emptyOption?: boolean|string,
    id?: string,
}

const props = withDefaults(defineProps<Props>(), {
    disabled: false,
    required: false,
    readonly: false,
    emptyOption: 'Select an option',
    value: '',
});

let itemValue = ref(props?.value)

const emit = defineEmits(['updatedValue'])

function updatedValue() {
  emit('updatedValue', itemValue)
}

const itemId = props.id || generateRandomString(15);
</script>

<template>
    <div
        class="py-1 w-full"
        :class="class"
    >
        <label
            v-if="$slots.default || label"
            :for="itemId"
            :class="labelClass"
        >
            <slot v-if="$slots.default" />
            <template v-else>
                <template v-if="label">{{ label }}</template>
            </template>
        </label>
        <select
            :disabled="disabled"
            :required="required"
            :readonly="readonly"
            v-model="itemValue"
            :id="itemId"
            @change="updatedValue"
            class="px-4 py-3 w-full rounded-md text-gray-800 bg-gray-100 border-transparent active:border-gray-500 active:bg-white active:ring-0 text-sm dark:bg-gray-700 dark:active:bg-gray-900"
            :class="[
                'dark:text-gray-50'
            ]"
        >
            <option
                v-if="emptyOption && emptyOption != true"
                value=""
            > {{ emptyOption }}
            </option>

            <option
                v-for="(optionItem, index) in options"
                :value="optionItem.value"
                :optionItem-index="index"
                :selected="optionItem.selected || itemValue == optionItem.value"
            > {{ optionItem.label }}
            </option>
        </select>
    </div>
</template>
@/helpers/string/index
