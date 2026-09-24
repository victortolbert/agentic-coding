<script setup lang="ts">
import { Form, Head, Link, router, setLayoutProps } from '@inertiajs/vue3';
import BoardPinsController from '@/actions/App/Http/Controllers/BoardPinsController';
import InputError from '@/components/InputError.vue';
import PinCard from '@/components/PinCard.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import BoardsController from '@/actions/App/Http/Controllers/BoardsController';
import { edit, index, show } from '@/routes/boards';
import type { Board, Pin } from '@/types';

const props = defineProps<{ board: Board; pins: Pin[] }>();

setLayoutProps({
    breadcrumbs: [
        { title: 'Boards', href: index() },
        { title: props.board.title, href: show(props.board.id) },
    ],
});

function toggleSharing(): void {
    router.visit(
        props.board.is_public
            ? BoardsController.unshare(props.board.id)
            : BoardsController.share(props.board.id),
        { preserveScroll: true },
    );
}

function removePin(pin: Pin): void {
    router.visit(BoardPinsController.destroy(pin.id), {
        preserveScroll: true,
    });
}
</script>

<template>
    <Head :title="props.board.title" />

    <div class="flex flex-col gap-8 p-4 md:p-8">
        <header class="flex items-start justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-2xl font-semibold tracking-tight">
                    {{ props.board.title }}
                </h1>
                <p v-if="props.board.description" class="text-muted-foreground">
                    {{ props.board.description }}
                </p>
            </div>
            <div class="flex items-center gap-2">
                <Button variant="outline" size="sm" @click="toggleSharing">
                    {{ props.board.is_public ? 'Make private' : 'Share' }}
                </Button>
                <Button variant="ghost" size="sm" as-child>
                    <Link :href="edit(props.board.id)">Edit</Link>
                </Button>
            </div>
        </header>

        <p v-if="props.board.is_public" class="text-sm text-muted-foreground">
            Public link:
            <a
                :href="BoardsController.public.url(props.board.id)"
                class="underline"
                >{{ BoardsController.public.url(props.board.id) }}</a
            >
        </p>

        <Form
            v-bind="BoardPinsController.store.form(props.board.id)"
            class="flex flex-col gap-2"
            reset-on-success
            preserve-scroll
            v-slot="{ errors, processing }"
        >
            <div class="flex flex-wrap gap-4">
                <Input
                    name="image_url"
                    type="url"
                    required
                    placeholder="Image URL"
                    aria-label="Image URL"
                    class="min-w-64 flex-2"
                />
                <Input
                    name="note"
                    maxlength="140"
                    placeholder="What you like about it"
                    aria-label="Note"
                    class="min-w-64 flex-3"
                />
                <Button :disabled="processing">Pin</Button>
            </div>
            <InputError :message="errors.image_url ?? errors.note" />
        </Form>

        <p v-if="pins.length === 0" class="max-w-prose text-muted-foreground">
            Nothing pinned yet. Paste an image URL above: a screenshot, a
            specimen, a product shot. Add a note that says what you liked about
            it.
        </p>

        <TransitionGroup
            v-else
            tag="ul"
            class="columns-2 gap-4 md:columns-3 xl:columns-4"
            enter-active-class="motion-safe:transition motion-safe:duration-200 motion-safe:ease-out"
            enter-from-class="motion-safe:translate-y-2 motion-safe:opacity-0"
        >
            <li
                v-for="pin in pins"
                :key="pin.id"
                class="mb-4 break-inside-avoid"
            >
                <PinCard :pin="pin" removable @remove="removePin" />
            </li>
        </TransitionGroup>
    </div>
</template>
