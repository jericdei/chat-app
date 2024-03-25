<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps<{
    chats: Chat[];
}>();
</script>

<template>
    <Head title="Chats" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Chats
            </h2>
        </template>

        <div class="dark:text-slate-50 p-8">
            <div class="space-y-4">
                <Link
                    v-for="chat in props.chats"
                    :key="chat.id"
                    class="block rounded-lg hover:bg-slate-700/20 p-4 cursor-pointer"
                    :href="route('chats.show', chat.receiver?.id)"
                >
                    <div>
                        <h3 class="font-bold">{{ chat.receiver?.name }}</h3>
                        <small v-if="chat.latest_message" class="mt-2">{{
                            `${
                                chat.latest_message?.sender?.name ===
                                $page.props.auth.user.name
                                    ? "You"
                                    : chat.latest_message?.sender?.name
                            }: ${chat.latest_message?.value}`
                        }}</small>
                    </div>
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
