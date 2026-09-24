<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { create, index } from '@/routes/boards';
import type { Board } from '@/types';

defineOptions({
    layout: {
        breadcrumbs: [{ title: 'Boards', href: index() }],
    },
});

defineProps<{ boards: Board[] }>();
</script>

<template>
    <Head title="Boards" />

    <div class="flex flex-col gap-6 p-4">
        <div class="flex items-start justify-between">
            <Heading
                title="Boards"
                description="Reference, one board per project"
            />
            <Button as-child>
                <Link :href="create()">New board</Link>
            </Button>
        </div>

        <p v-if="boards.length === 0" class="text-sm text-muted-foreground">
            No boards yet.
        </p>

        <ul v-else class="grid gap-4 md:grid-cols-3">
            <li
                v-for="board in boards"
                :key="board.id"
                class="rounded-xl border border-sidebar-border/70 p-4 dark:border-sidebar-border"
            >
                <p class="font-medium">{{ board.title }}</p>
                <p class="text-sm text-muted-foreground">
                    {{ board.pins_count }} pins
                </p>
            </li>
        </ul>
    </div>
</template>
