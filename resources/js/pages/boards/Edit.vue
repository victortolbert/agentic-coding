<script setup lang="ts">
import { Form, Head, setLayoutProps } from '@inertiajs/vue3';
import BoardsController from '@/actions/App/Http/Controllers/BoardsController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { edit, index, show } from '@/routes/boards';
import type { Board } from '@/types';

const props = defineProps<{ board: Board }>();

setLayoutProps({
    breadcrumbs: [
        { title: 'Boards', href: index() },
        { title: props.board.title, href: show(props.board.id) },
        { title: 'Edit', href: edit(props.board.id) },
    ],
});
</script>

<template>
    <Head :title="`Edit ${props.board.title}`" />

    <div class="flex max-w-xl flex-col gap-6 p-4">
        <Heading title="Edit board" />

        <Form
            v-bind="BoardsController.update.form(props.board.id)"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="title">Title</Label>
                <Input
                    id="title"
                    name="title"
                    :default-value="props.board.title"
                    required
                    maxlength="80"
                />
                <InputError :message="errors.title" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input
                    id="description"
                    name="description"
                    :default-value="props.board.description ?? ''"
                    maxlength="500"
                />
                <InputError :message="errors.description" />
            </div>

            <Button :disabled="processing">Save</Button>
        </Form>
    </div>
</template>
