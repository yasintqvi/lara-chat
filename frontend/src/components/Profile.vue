<template>
    <div class="relative">
        <Avatar @click="toggleDropdown" :image="user.avatar" :alt="user.name" class="w-8 h-8 cursor-pointer" />

        <!-- Dropdown menu -->
        <div v-show="showDropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
            <div class="px-4 py-2 text-sm text-gray-700 border-b">
                Signed in as <span class="font-medium">{{ user.name }}</span>
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
import Avatar from './Avatar.vue';


export default {
    data() {
        return {
            showDropdown: false
        };
    },
    computed: {
        ...mapGetters(['user']),
    },
    components: {
        Avatar
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