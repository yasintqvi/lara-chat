<template>
    <div v-if="!user" class="min-h-[80vh] flex items-center justify-center bg-gray-50">
        <div class="text-center p-8 max-w-md mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to ChatApp</h1>
            <button @click="redirectToLogin"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 shadow-md transform hover:scale-105">
                Start Chat
            </button>
        </div>
    </div>

    <div v-else class="flex h-[80vh] bg-gray-100">
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="flex-1 overflow-y-auto p-2">
                <h2 class="text-lg font-semibold px-2 py-1 text-gray-700">Your Conversations</h2>
                <div v-for="group in groups" :key="group.id" @click="selectgroup(group)"
                    class="flex items-center p-2 hover:bg-gray-100 rounded-lg cursor-pointer transition"
                    :class="{ 'bg-blue-50 border border-blue-100': activeGroup?.id === group.id }">
                    <div class="relative">
                        <Avatar :image="group.avatar" :alt="group.title" />

                        <span v-if="group.unread"
                            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                            {{ group.unread }}
                        </span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate">{{ group.title }}</p>
                        <p class="text-sm text-gray-500 truncate">{{ group.lastMessage || 'No messages yet' }}</p>
                    </div>
                    <span v-if="group.lastMessageTime" class="text-xs text-gray-400 ml-2 whitespace-nowrap">
                        {{ formatTimeShort(group.lastMessageTime) }}
                    </span>
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
import Avatar from './Avatar.vue';

export default {
    data() {
        return {
            user: null,
            activeGroup: null,
            groups: [],
        }
    },
    components: {
        Messages,
        Avatar
    },
    methods: {
        redirectToLogin() {
            this.$router.push('/login');
        },
        selectgroup(group) {
            this.activeGroup = group;
        },
        formatTimeShort(timeString) {
            const time = new Date(timeString);
            return time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },
        getInitials(name) {
            if (!name) return '';
            const parts = name.split(' ');
            let initials = parts[0].charAt(0).toUpperCase();
            if (parts.length > 1) {
                initials += parts[parts.length - 1].charAt(0).toUpperCase();
            }
            return initials.substring(0, 2);
        },
        stringToColor(str) {
            let hash = 0;
            for (let i = 0; i < str.length; i++) {
                hash = str.charCodeAt(i) + ((hash << 5) - hash);
            }
            const hue = Math.abs(hash % 360);
            return `hsl(${hue}, 60%, 50%)`;
        },
        async getCurrentUser() {
            try {
                const response = await authService.getUser();
                if (response?.data) {
                    this.$store.dispatch('login', response.data);
                    this.user = response.data;
                }
            } catch (error) {
                console.error("Failed to load user:", error);
            }
        },
        async getUserGroups() {
            try {
                const response = await groupService.getUserGroups();
                if (response?.data) {
                    this.groups = response.data;
                }
            } catch (error) {
                console.error('Failed to get groups:', error);
            }
        },
    },
    created() {
        this.getCurrentUser();
        this.getUserGroups();
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
    border-radius: 3px;
}

::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>