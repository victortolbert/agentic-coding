<script setup lang="ts">
import { X } from '@lucide/vue';
import type { Pin } from '@/types';

type PinCardPin = Pick<Pin, 'id' | 'image_url' | 'note'>;

defineProps<{ pin: PinCardPin; removable?: boolean }>();

defineEmits<{ remove: [pin: PinCardPin] }>();
</script>

<template>
    <figure class="group relative flex flex-col gap-1">
        <img
            :src="pin.image_url"
            :alt="pin.note ?? ''"
            loading="lazy"
            class="h-auto w-full rounded-md bg-muted"
        />
        <figcaption v-if="pin.note" class="text-sm text-muted-foreground">
            {{ pin.note }}
        </figcaption>
        <button
            v-if="removable"
            type="button"
            aria-label="Remove pin"
            class="absolute top-2 right-2 flex size-8 items-center justify-center rounded-full bg-background/90 text-foreground opacity-0 shadow-sm group-hover:opacity-100 focus-visible:opacity-100 motion-safe:transition-opacity motion-safe:duration-150 pointer-coarse:opacity-100"
            @click="$emit('remove', pin)"
        >
            <X class="size-4" />
        </button>
    </figure>
</template>
