<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { WeatherData, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];
defineProps<{
    weather: WeatherData;
}>();
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <!-- <pre>{{ weather }}</pre> -->
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <h2 class="text-2xl font-bold">{{ weather.main.temp }} °C</h2>
                    <p class="text-lg tracking-wide capitalize opacity-90">{{ weather.weather[0].description }}</p>
                    <p class="text-sm opacity-80">{{ weather.name }}, {{ weather.sys.country }}</p>
                    <div class="mt-5 flex gap-5 text-sm opacity-90">
                        <span>💨 {{ weather.wind.speed }} m/s</span>
                        <span>💧 {{ weather.main.humidity }}%</span>
                    </div>
                    <img class="size-20 absolute top-0 right-0" :src="`https://openweathermap.org/img/wn/${weather.weather[0].icon}@2x.png`" alt="" />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
