<template>
    <div class="flex-1 flex flex-col">
        <div v-if="activeGroup" class="bg-white p-4 border-b border-gray-200 flex items-center">
            <Avatar :image="activeGroup.avatar" :alt="activeGroup.title" />
            <div>
                <h2 class="font-bold">{{ activeGroup.title }}</h2>
                <p class="text-sm text-gray-500">{{ activeGroup.status }}</p>
            </div>
        </div>

        <div ref="messagesContainer" class="flex-1 p-4 overflow-y-auto overflow-x-hidden bg-gray-50 ">
            <div class="space-y-3">
                <Message v-for="message in messages" :key="message.id" :user="user" :message="message" />
            </div>
        </div>
        <div class="bg-white p-4 border-t border-gray-200">
            <form @submit.prevent="sendMessage" class="flex">
                <input v-model="newMessage" type="text" placeholder="Type a message..."
                    class="flex-1 px-4 py-2 rounded-l-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 transition">
                    Send
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import groupService from '@/services/groupService';
import { useToast } from 'vue-toastification';
import Message from "./Message.vue";
import Echo from '@/plugins/echo'
import Avatar from './Avatar.vue';

export default {
    data() {
        return {
            newMessage: '',
            messages: [],
            echoListener: null,
        }
    },

    props: {
        user: {
            type: Object,
            required: true
        },
        activeGroup: {
            type: Object,
            default: null
        }
    },

    components: {
        Message,
        Avatar
    },

    watch: {
        activeGroup(newGroup) {
            if (!newGroup || !newGroup.id) {
                return;
            }

            if (this.echoListener) {
                this.echoListener = null;
            }

            this.loadMessages(newGroup.id);
            this.listenForNewMessages(newGroup.id);
        },
    },

    methods: {
        async loadMessages(groupId) {
            const response = await groupService.getGroupMessages(groupId);
            this.messages = response.data || [];
            this.scrollToBottom();
        },

        async sendMessage() {
            if (!this.newMessage.trim() || !this.activeGroup) return;

            const toast = useToast();
            try {
                await groupService.sendMessage(this.activeGroup.id, this.newMessage);

                this.scrollToBottom();
            } catch (error) {
                toast.error(error.message);
            }

            this.newMessage = '';
        },

        listenForNewMessages(groupId) {
            if (!groupId) {
                return;
            }

            if (this.echoListener) {
                this.echoListener.stopListening();
                this.echoListener = null;
            }

            this.echoListener = Echo.channel(`group.${groupId}`)
                .listen('.message.created', (data) => {
                    this.messages.push({
                        id: data.id,
                        user_id: data.user_id,
                        message: data.message,
                        created_at: data.created_at,
                        user: data.user
                    });
                    this.scrollToBottom();
                })
                .error((error) => {
                    console.error('Pusher error:', error);
                });
        },


        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTo({
                        top: container.scrollHeight,
                        behavior: 'smooth'
                    });
                }
            });
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
    },

    beforeDestroy() {
        if (this.echoListener) {
            this.echoListener.stopListening();
        }
    }
}
</script>
