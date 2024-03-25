<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router, useForm, usePage } from "@inertiajs/vue3";
import Textarea from "primevue/textarea";
import InputGroup from "primevue/inputgroup";
import Button from "primevue/button";
import InputText from "primevue/inputtext";
import { ref } from "vue";
import { useScroll } from "@vueuse/core";
import { onMounted } from "vue";

const props = defineProps<{
    chat: Chat;
}>();

const form = useForm({
    message: "",
});

const chatContainer = ref<HTMLElement | null>(null);

const { y } = useScroll(chatContainer);

window.Echo.channel("messages").listen("MessageSent", (event: Event) => {
    router.reload({
        onSuccess: () => scrollToBottom(),
    });
});

onMounted(() => scrollToBottom());

function scrollToBottom() {
    if (chatContainer.value) {
        y.value = chatContainer.value.scrollHeight;
    }
}

function submit() {
    if (form.message === "") return;

    form.post(
        route("chats.store", {
            chat: props.chat,
        }),
        {
            onSuccess: () => {
                form.reset("message");
                scrollToBottom();
            },
        }
    );
}
</script>

<template>
    <Head title="Chats" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                {{ props.chat.receiver?.name }}
            </h2>
        </template>

        <div class="p-4 mt-4">
            <div
                ref="chatContainer"
                class="dark:text-slate-50 p-8 space-y-4 divide-y max-h-[40rem] overflow-y-auto"
            >
                <div v-if="props.chat.messages?.length === 0">
                    <p class="text-center">No messages yet.</p>
                </div>

                <div v-else class="flex flex-col gap-4">
                    <div
                        v-for="message in props.chat.messages"
                        :key="message.id"
                    >
                        <div
                            class="bg-primary text-white dark:text-black p-4 rounded-lg"
                            :class="
                                message.sender?.id === $page.props.auth.user.id
                                    ? 'float-right rounded-br-none'
                                    : 'float-left rounded-bl-none'
                            "
                        >
                            <small>{{
                                Intl.DateTimeFormat("en-PH", {
                                    year: "numeric",
                                    month: "short",
                                    day: "numeric",
                                    hour: "numeric",
                                    minute: "numeric",
                                }).format(
                                    new Date(message.created_at as string)
                                )
                            }}</small>

                            <p>
                                {{ message.value }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <form class="mt-4" @submit.prevent="submit">
                <InputGroup>
                    <InputText
                        v-model="form.message"
                        placeholder="Type your message"
                    />

                    <Button
                        type="submit"
                        icon="ri-send-plane-2-line"
                        @submit.prevent="submit"
                    />
                </InputGroup>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
