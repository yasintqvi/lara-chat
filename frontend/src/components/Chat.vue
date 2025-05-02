<template>
    <div v-if="!isAuthenticated" class="flex h-[100vh] items-center justify-center bg-gray-50">
        <div class="text-center p-8 max-w-md mx-auto">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Welcome to ChatApp</h1>
            <button @click="redirectToLogin"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-lg text-lg transition duration-200 shadow-md transform hover:scale-105">
                Start Chat
            </button>
        </div>
    </div>

    <div v-else class="flex h-[100vh] bg-gray-100">
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <div class="flex-1 overflow-y-auto p-2">
                <div class="flex justify-between items-center my-2">
                    <h2 class="text-lg font-semibold px-2 py-1 text-gray-700">Chats</h2>
                    <Profile />
                </div>
                <div v-for="group in groups" :key="group.id" @click="selectGroup(group)"
                    class="flex items-center p-2 hover:bg-gray-100 rounded-lg cursor-pointer transition"
                    :class="{ 'bg-blue-50 border border-blue-100': activeGroup?.id === group.id }">
                    <div class="relative">
                        <Avatar :image="group.avatar" :alt="group.title" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium truncate">{{ group.title }}</p>
                    </div>
                </div>
            </div>
        </div>

        <Messages :user="user" :active-group="activeGroup" />
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import groupService from '@/services/groupService';
import Messages from './Messages.vue';
import Avatar from './Avatar.vue';
import Profile from './Profile.vue';
import NoChatSelected from './NoChatSelected.vue';

export default {
    data() {
        return {
            activeGroup: null,
            groups: [],
        }
    },
    computed: {
        ...mapGetters(['isAuthenticated', 'user'])
    },
    components: {
        Messages,
        Profile,
        Avatar,
        NoChatSelected
    },
    methods: {
        redirectToLogin() {
            this.$router.push('/login');
        },
        selectGroup(group) {
            this.activeGroup = group;
        },
        formatTimeShort(timeString) {
            const time = new Date(timeString);
            return time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
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
        this.getUserGroups();
    }
}
</script>