<template>
    <div v-if="image" class="w-10 h-10 rounded-full flex-shrink-0 mr-3">
        <img :src="image" class="w-full h-full object-cover" alt="Group">
    </div>
    <div v-else class="w-10 h-10 rounded-full mr-3 flex items-center justify-center flex-shrink-0"
        :style="{ backgroundColor: stringToColor(alt), color: 'white' }">
        <span class="font-medium text-sm">{{ getInitials(alt) }}</span>
    </div>
</template>

<script>

export default {
    props: {
        image: {
            required: true,
        },
        alt: {
            type: String,
            required: true,
        }
    },
    methods: {
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
}

</script>