<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import type { Board, Pin, User } from '@/types';

defineProps<{ board: Board & { owner: User; pins: Pin[] } }>();
</script>

<template>
    <Head :title="board.title" />

    <div class="mx-auto flex max-w-6xl flex-col gap-6 p-6">
        <div>
            <h1 class="text-2xl font-semibold">{{ board.title }}</h1>
            <p class="text-sm text-muted-foreground">
                Shared by {{ board.owner.name }}
            </p>
        </div>

        <ul class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <li
                v-for="pin in board.pins"
                :key="pin.id"
                class="flex flex-col gap-2"
            >
                <img
                    :src="pin.image_url"
                    :alt="pin.note ?? ''"
                    class="aspect-square w-full rounded-lg object-cover"
                />
                <p v-if="pin.note" class="text-sm">{{ pin.note }}</p>
            </li>
        </ul>
    </div>
</template>
