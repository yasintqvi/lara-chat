<template>
    <div class="min-h-screen flex flex-col bg-gradient-to-b from-gray-50 to-gray-100">
        <nav class="bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <!-- Logo/Brand -->
                    <div class="flex-shrink-0 flex items-center">
                        <router-link to="/" class="text-white flex items-center space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                            </svg>
                            <span class="text-xl font-bold">MyApp</span>
                        </router-link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-4">
                            <router-link to="/"
                                class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-700 transition duration-150"
                                active-class="bg-blue-700">
                                Home
                            </router-link>
                        </div>
                    </div>

                    <!-- Auth Links -->
                    <div class="ml-4 flex items-center md:ml-6">
                        <template v-if="!isAuthenticated">
                            <router-link to="/register"
                                class="px-3 py-2 rounded-md text-sm font-medium text-white hover:bg-blue-700 transition duration-150">
                                Register
                            </router-link>
                            <router-link to="/login"
                                class="ml-4 px-3 py-2 rounded-md text-sm font-medium bg-white text-blue-600 hover:bg-gray-100 transition duration-150">
                                Login
                            </router-link>
                        </template>
                        <Profile v-else />
                    </div>
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow">
            <!-- Navigation -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <router-view class="transition-all duration-300 ease-in-out"></router-view>
            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                        </svg>
                        <span class="text-lg font-semibold">MyApp</span>
                    </div>
                    <div class="mt-4 md:mt-0 text-sm">
                        <p>&copy; {{ new Date().getFullYear() }} MyApp. All rights reserved.</p>
                    </div>
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        <a href="#" class="text-white hover:text-gray-200">
                            <span class="sr-only">Facebook</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                    clip-rule="evenodd" />
                            </svg>
                        </a>
                        <a href="#" class="text-white hover:text-gray-200">
                            <span class="sr-only">Twitter</span>
                            <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path
                                    d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Profile from './components/Profile.vue';

export default {
    components: {
        Profile,
    },
    computed: {
        ...mapGetters(['isAuthenticated'])
    }
}
</script>