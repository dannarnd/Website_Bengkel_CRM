import { defineStore } from 'pinia';
import api from '../utils/axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        token: localStorage.getItem('auth_token') || null,
        user: null,
    }),
    getters: {
        isAuthenticated: (state) => !!state.token,
    },
    actions: {
        async login(credentials) {
            try {
                // Laravel Sanctum membutuhkan CSRF cookie sebelum login untuk keamanan SPA stateful, 
                // namun karena kita menggunakan Bearer token stateless API, kita langsung tembak endpoint login.
                const response = await api.post('/login', credentials);
                this.token = response.data.token;
                this.user = response.data.user;
                localStorage.setItem('auth_token', this.token);
                return { success: true };
            } catch (error) {
                return { success: false, message: error.response?.data?.message || 'Login failed' };
            }
        },
        async logout() {
            try {
                await api.post('/logout');
            } catch (e) {
                console.error(e);
            } finally {
                this.token = null;
                this.user = null;
                localStorage.removeItem('auth_token');
            }
        },
        async fetchUser() {
            if (!this.token) return;
            try {
                const response = await api.get('/me');
                this.user = response.data;
            } catch (error) {
                this.logout();
            }
        }
    }
});
