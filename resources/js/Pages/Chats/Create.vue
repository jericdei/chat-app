<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps<{
    users: User[];
}>();
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
            >
                Create Chat
            </h2>
        </template>

        <p class="mt-16">Select the user you want to chat with.</p>

        <div class="space-y-4 mt-8">
            <Link
                v-for="user in props.users"
                :key="user.id"
                class="block rounded-lg hover:bg-slate-700/20 p-4 cursor-pointer"
                :href="route('chats.show', user.id)"
            >
                <div>
                    <h3 class="font-bold">{{ user.name }}</h3>
                </div>
            </Link>
        </div>
    </AuthenticatedLayout>
</template>
