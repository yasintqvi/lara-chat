<template>
    <!-- Unauthenticated - Show only Start Chat button -->
    <div v-if="!user" class="min-h-[80vh] flex items-center justify-center bg-gray-50">
        <div class="text-center p-8 max-w-md mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to ChatApp</h1>
            <button @click="redirectToLogin"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 shadow-md transform hover:scale-105">
                Start Chat
            </button>
        </div>
    </div>

    <!-- Authenticated - Show full chat interface -->
    <div v-else class="flex h-[80vh] bg-gray-100">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 p-4">
            <h2 class="text-xl font-bold mb-4">Groups</h2>
            <div v-for="group in groups" :key="group.id" @click="selectgroup(group)"
                class="flex items-center p-2 hover:bg-gray-100 rounded cursor-pointer"
                :class="{ 'bg-blue-50': activeGroup?.id === group.id }">
                <img :src="group.avatar" class="w-10 h-10 rounded-full mr-3" alt="Profile">
                <div>
                    <p class="font-medium">{{ group.title }}</p>
                    <p class="text-sm text-gray-500">{{ group.status }}</p>
                </div>
            </div>
        </div>

        <Messages :user="user" :active-group="activeGroup" />

    </div>
</template>

<script>
import authService from '@/services/authService';
import groupService from '@/services/groupService';
import Messages from './Messages.vue';

export default {
    data() {
        return {
            user: null,
            activeGroup: null,
            groups: [],
        }
    },
    components: {
        Messages
    },
    methods: {
        redirectToLogin() {
            this.$router.push('/login');
        },
        selectgroup(group) {
            this.activeGroup = group
        },
        async getCurrentUser() {
            try {
                const response = await authService.getUser()
                if (response?.data) {
                    this.$store.dispatch('login', response.data)
                    this.user = response.data
                }
            } catch (error) {
                console.error("Failed to load user:", error);
            }
        },
        async getUserGroups() {
            try {
                const response = await groupService.getUserGroups()
                if (response?.data) {
                    this.groups = response.data
                }

            } catch (error) {
                console.error('Failed to get groups:', error)
            }
        },
    },
    created() {
        this.getCurrentUser()

        this.getUserGroups()
    }
}
</script>

<style scoped>
/* Custom scrollbar */
::-webkit-scrollbar {
    width: 6px;
}

::-webkit-scrollbar-track {
    background: #f1f1f1;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>