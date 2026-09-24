<script setup lang="ts">
import { Head, Link, setLayoutProps } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { edit, index, show } from '@/routes/boards';
import type { Board, Pin } from '@/types';

const props = defineProps<{ board: Board; pins: Pin[] }>();

setLayoutProps({
    breadcrumbs: [
        { title: 'Boards', href: index() },
        { title: props.board.title, href: show(props.board.id) },
    ],
});
</script>

<template>
    <Head :title="props.board.title" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-start justify-between">
            <Heading
                :title="props.board.title"
                :description="props.board.description ?? undefined"
            />
            <Button variant="outline" as-child>
                <Link :href="edit(props.board.id)">Edit</Link>
            </Button>
        </div>

        <p v-if="pins.length === 0" class="text-sm text-muted-foreground">
            No pins yet.
        </p>

        <ul v-else class="grid grid-cols-2 gap-4 md:grid-cols-4">
            <li v-for="pin in pins" :key="pin.id" class="flex flex-col gap-2">
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
