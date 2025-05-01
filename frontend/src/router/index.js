import { createRouter, createWebHistory } from 'vue-router';
import LoginPage from '@/components/Login.vue';
import ChatPage from '@/components/Chat.vue';
import RegisterPage from '@/components/Register.vue';
import store from '../store';

function isAuthenticated() {
    return store.getters.isAuthenticated
}

const routes = [
    {
        path: '/',
        name: 'home',
        component: ChatPage,
    },
    {
        path: '/login',
        name: 'login',
        component: LoginPage,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next({ name: 'home' });
            } else {
                next();
            }
        },
    },
    {
        path: '/register',
        name: 'register',
        component: RegisterPage,
        beforeEnter: (to, from, next) => {
            if (isAuthenticated()) {
                next({ name: 'home' });
            } else {
                next();
            }
        },
    },
];

const router = createRouter({
    history: createWebHistory(import.meta.env.VITE_APP_BASE_URL),
    routes,
});

export default router;
