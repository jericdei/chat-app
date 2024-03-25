<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import Button from "primevue/button";
import { useConfirm } from "primevue/useconfirm";

const props = defineProps<{
    chats: Chat[];
}>();

const confirm = useConfirm();

function createChat() {
    router.get(route("chats.create"));
}

function deleteChat(chatId: number) {
    confirm.require({
        message: "Are you sure you want to delete this chat?",
        header: "Delete Confirmation",
        icon: "ri-error-warning-line",
        acceptClass: "p-button-danger",
        accept: () => {
            router.delete(route("chats.destroy", chatId));
        },
    });
}
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
            <div class="flex justify-end">
                <Button
                    label="Create new chat"
                    icon="ri-edit-box-line"
                    @click="createChat"
                />
            </div>

            <div v-if="props.chats.length === 0">
                <p class="text-center">
                    No chats yet.
                    <Link class="underline" :href="route('chats.create')"
                        >Create one.</Link
                    >
                </p>
            </div>

            <div v-else>
                <div class="space-y-4 mt-8">
                    <div
                        v-for="chat in props.chats"
                        :key="chat.id"
                        class="group rounded-lg hover:bg-slate-700/20"
                    >
                        <div class="flex justify-between items-center">
                            <Link
                                :href="route('chats.show', chat.receiver?.id)"
                                class="w-full h-full block p-4 cursor-pointer"
                            >
                                <h3 class="font-bold">
                                    {{ chat.receiver?.name }}
                                </h3>
                                <small
                                    v-if="chat.latest_message"
                                    class="mt-2"
                                    >{{
                                        `${
                                            chat.latest_message?.sender
                                                ?.name ===
                                            $page.props.auth.user.name
                                                ? "You"
                                                : chat.latest_message?.sender
                                                      ?.name
                                        }: ${chat.latest_message?.value}`
                                    }}</small
                                >
                            </Link>

                            <div class="px-4">
                                <Button
                                    icon="ri-delete-bin-line"
                                    severity="danger"
                                    text
                                    @click="deleteChat(chat.id)"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="hidden group-hover:block"></div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
