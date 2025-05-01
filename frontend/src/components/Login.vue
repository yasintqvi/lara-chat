<template>
    <div class="min-h-[80vh] bg-gradient-to-br flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
                    <p class="text-gray-600 mt-2">Sign in to your account</p>
                </div>

                <form @submit.prevent="login" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input v-model="email" type="email" id="email" placeholder="you@example.com" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Forgot password?</a>
                        </div>
                        <input v-model="password" type="password" id="password" placeholder="••••••••" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Sign In
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Don't have an account?
                        <router-link to="/register" class="text-blue-600 hover:text-blue-500 font-medium">Sign
                            up</router-link>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import authService from '@/services/authService.js';
import { useToast } from 'vue-toastification';

export default {
    data() {
        return {
            email: '',
            password: '',
        };
    },
    methods: {
        async login() {

            const toast = useToast();

            try {
                const credentials = { email: this.email, password: this.password };
                const response = await authService.login(credentials);

                localStorage.setItem('auth_token', response.data?.token);
                this.$store.dispatch('login', response.data?.user);

                toast.success(response.message);

                this.$router.push({ name: "home" });

            } catch (error) {
                toast.error(error.message);
            }
        },
    },
};
</script>