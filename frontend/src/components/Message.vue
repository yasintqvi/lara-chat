<template>
    <div class="flex items-start" :class="{ 'flex-row-reverse': message.user_id === user.id }">
        <Avatar :image="message.user.avatar" :alt="message.user.name" />
        <div v-if="message.user_id === user.id">
            <div class="flex items-baseline flex-row-reverse">
                <span class="font-medium m-2">You</span>
                <span class="text-xs text-gray-500">{{ formatTime(message.created_at) }}</span>
            </div>
            <div class="mt-1 p-3 rounded-lg bg-blue-500 text-white ml-auto text-wrap max-w-[80%] shadow-md">
                {{ message.message }}
            </div>
        </div>
        <div v-else>
            <div class="flex items-baseline">
                <span class="font-medium m-2">{{ message.user.name }}</span>
                <span class="text-xs text-gray-500">{{ formatTime(message.created_at) }}</span>
            </div>
            <div class="mt-1 p-3 rounded-lg bg-gray-100 max-w-[80%] text-wrap shadow-sm">
                {{ message.message }}
            </div>
        </div>
    </div>
</template>

<script>
import Avatar from "./Avatar.vue"

export default {
    props: {
        user: {
            type: Object,
            required: true,
        },
        message: {
            type: Object,
            required: true
        }
    },
    components: {
        Avatar
    },
    methods: {
        formatTime(timeString) {
            const time = new Date(timeString);
            return time.toLocaleDateString() + ' ' + time.toLocaleTimeString()
        },
    }
}
</script>