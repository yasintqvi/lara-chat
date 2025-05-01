<template>
    <div class="min-h-[80vh] bg-gradient-to-br flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white rounded-xl shadow-2xl overflow-hidden">
            <div class="p-8">
                <div class="text-center mb-8">
                    <h1 class="text-3xl font-bold text-gray-800">Create Account</h1>
                    <p class="text-gray-600 mt-2">Join our community today</p>
                </div>

                <form @submit.prevent="register" class="space-y-5">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                        <input v-model="name" type="text" id="name" placeholder="John Doe" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input v-model="email" type="email" id="email" placeholder="you@example.com" required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input v-model="password" type="password" id="password" placeholder="••••••••" required
                            minlength="8"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 characters</p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm
                            Password</label>
                        <input v-model="password_confirmation" type="password" id="password_confirmation"
                            placeholder="••••••••" required minlength="8"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200" />
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="terms" required
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" />
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                            I agree to the <a href="#" class="text-blue-600 hover:text-blue-500">Terms and
                                Conditions</a>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 transition duration-200 shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Create Account
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-600">
                        Already have an account?
                        <router-link to="/login" class="text-blue-600 hover:text-blue-500 font-medium">Sign
                            in</router-link>
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
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };
    },
    methods: {
        async register() {

            const toast = useToast();

            try {
                const userData = {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation
                };

                const response = await authService.register(userData);

                localStorage.setItem('auth_token', response.data.token);

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