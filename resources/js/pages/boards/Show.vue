<script setup lang="ts">
import { Form, Head, Link, router, setLayoutProps } from '@inertiajs/vue3';
import BoardPinsController from '@/actions/App/Http/Controllers/BoardPinsController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit, index, show } from '@/routes/boards';
import type { Board, Pin } from '@/types';

const props = defineProps<{ board: Board; pins: Pin[] }>();

setLayoutProps({
    breadcrumbs: [
        { title: 'Boards', href: index() },
        { title: props.board.title, href: show(props.board.id) },
    ],
});

function removePin(pin: Pin): void {
    router.visit(BoardPinsController.destroy(pin.id), {
        preserveScroll: true,
    });
}
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

        <Form
            v-bind="BoardPinsController.store.form(props.board.id)"
            class="flex flex-wrap items-end gap-4"
            reset-on-success
            preserve-scroll
            v-slot="{ errors, processing }"
        >
            <div class="grid min-w-64 flex-1 gap-2">
                <Label for="image_url">Image URL</Label>
                <Input
                    id="image_url"
                    name="image_url"
                    type="url"
                    required
                    placeholder="https://"
                />
                <InputError :message="errors.image_url" />
            </div>
            <div class="grid min-w-64 flex-1 gap-2">
                <Label for="note">Note</Label>
                <Input id="note" name="note" maxlength="140" />
                <InputError :message="errors.note" />
            </div>
            <Button :disabled="processing">Pin</Button>
        </Form>

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
                <Button
                    variant="ghost"
                    size="sm"
                    class="self-start"
                    @click="removePin(pin)"
                >
                    Remove
                </Button>
            </li>
        </ul>
    </div>
</template>
