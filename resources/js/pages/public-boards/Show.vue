<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import PinCard from '@/components/PinCard.vue';
import type { Board, Pin } from '@/types';

defineProps<{
    board: Pick<Board, 'title' | 'description'>;
    pins: Pick<Pin, 'id' | 'image_url' | 'note'>[];
}>();
</script>

<template>
    <Head :title="board.title" />

    <main class="mx-auto flex max-w-7xl flex-col gap-8 p-4 md:p-8">
        <header class="flex flex-col gap-1">
            <h1 class="text-2xl font-semibold tracking-tight">
                {{ board.title }}
            </h1>
            <p v-if="board.description" class="text-muted-foreground">
                {{ board.description }}
            </p>
        </header>

        <ul class="columns-2 gap-4 md:columns-3 xl:columns-4">
            <li
                v-for="pin in pins"
                :key="pin.id"
                class="mb-4 break-inside-avoid"
            >
                <PinCard :pin="pin" />
            </li>
        </ul>
    </main>
</template>
