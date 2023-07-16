<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div
        class="px-8 min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900"
    >
        <div
            class="mt-4"
        >
            <Link href="/">
                <h2 class="text-md text-gray-900 dark:text-gray-50">{{ $page.props.appName }}</h2>
            </Link>
        </div>

        <div
            class="w-full mt-6 px-3 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden rounded-lg"
        >
            <slot />
        </div>
    </div>
</template>
