<template>
    <div class="relative">
        <!-- Profile button -->
        <button @click="toggleDropdown" class="flex items-center space-x-2 focus:outline-none">
            <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center text-white">
                {{ userInitials }}
            </div>
            <span class="text-white">{{ userName }}</span>
            <svg class="w-4 h-4 text-white transition-transform duration-200"
                :class="{ 'transform rotate-180': showDropdown }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>

        <!-- Dropdown menu -->
        <div v-show="showDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                Signed in as <span class="font-medium">{{ userName }}</span>
            </div>
            <button @click="logout" class="block w-full text-left px-4 py-2 text-sm text-red-700 hover:bg-gray-100">
                Logout
            </button>
        </div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
import authService from '@/services/authService';
import { useToast } from 'vue-toastification';


export default {
    data() {
        return {
            showDropdown: false
        };
    },
    computed: {
        ...mapGetters(['user']),
        userName() {
            return this.user?.name || 'User';
        },
        userInitials() {
            if (!this.user?.name) return 'U';
            return this.user.name
                .split(' ')
                .map(n => n[0])
                .join('')
                .toUpperCase();
        }
    },
    methods: {
        toggleDropdown() {
            this.showDropdown = !this.showDropdown;
        },
        async logout() {

            const toast = useToast();

            try {
                const response = await authService.logout();

                this.$store.dispatch('logout');

                toast.success(response.message);

                this.$router.push('/login');

            } catch (error) {
                toast.error(error.message);
            }
        },
        handleClickOutside(event) {
            if (!this.$el.contains(event.target)) {
                this.showDropdown = false;
            }
        }
    }
};
</script>