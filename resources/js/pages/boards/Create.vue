<script setup lang="ts">
import { Form, Head } from '@inertiajs/vue3';
import BoardsController from '@/actions/App/Http/Controllers/BoardsController';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { create, index } from '@/routes/boards';

defineOptions({
    layout: {
        breadcrumbs: [
            { title: 'Boards', href: index() },
            { title: 'New board', href: create() },
        ],
    },
});
</script>

<template>
    <Head title="New board" />

    <div class="flex max-w-xl flex-col gap-6 p-4">
        <Heading title="New board" />

        <Form
            v-bind="BoardsController.store.form()"
            class="space-y-6"
            v-slot="{ errors, processing }"
        >
            <div class="grid gap-2">
                <Label for="title">Title</Label>
                <Input id="title" name="title" required maxlength="80" />
                <InputError :message="errors.title" />
            </div>

            <div class="grid gap-2">
                <Label for="description">Description</Label>
                <Input id="description" name="description" maxlength="500" />
                <InputError :message="errors.description" />
            </div>

            <Button :disabled="processing">Create board</Button>
        </Form>
    </div>
</template>
