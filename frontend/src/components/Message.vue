<template>
    <div class="flex items-start" :class="{ 'flex-row-reverse': message.user_id === user.id }">
        <img :src="user.avatar" class="w-8 h-8 rounded-full mt-1 mr-3" :class="{ 'ml-3': message.user_id === user.id }"
            alt="Profile">
        <div v-if="message.user_id === user.id">
            <div class="flex items-baseline flex-row-reverse">
                <span class="font-medium ml-2">You</span>
                <span class="text-xs text-gray-500">{{ formatTime(message.created_at) }}</span>
            </div>
            <div class="mt-1 p-3 rounded-lg shadow-sm bg-blue-100 ml-auto max-w-[80%]">
                {{ message.message }}
            </div>
        </div>
        <div v-else>
            <div class="flex items-baseline">
                <span class="font-medium mr-2">{{ message.user.name }}</span>
                <span class="text-xs text-gray-500">{{ formatTime(message.created_at) }}</span>
            </div>
            <div class="mt-1 p-3 rounded-lg shadow-sm bg-white max-w-[80%]">
                {{ message.message }}
            </div>
        </div>
    </div>
</template>

<script>
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
    methods: {
        formatTime(timeString) {
            const time = new Date(timeString);
            return time.toLocaleDateString() + ' ' + time.toLocaleTimeString()
        },
    }
}
</script>
