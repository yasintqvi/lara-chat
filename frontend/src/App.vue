<template>
    <main class="flex-grow">
        <div class="mx-auto px-4">
            <router-view class="transition-all duration-300 ease-in-out"></router-view>
        </div>
    </main>
</template>

<script>
import authService from '@/services/authService.js';

export default {
    created() {
        this.checkAuth();
    },

    methods: {
        async checkAuth() {
            const token = localStorage.getItem("auth_token");
            if (token) {
                const response = await authService.getUser();
                this.$store.dispatch('login', response.data);
            }
        }
    }
}
</script>