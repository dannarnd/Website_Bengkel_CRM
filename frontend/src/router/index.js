import { createRouter, createWebHistory } from 'vue-router';
import PublicLayout from '../layouts/PublicLayout.vue';
import AdminLayout from '../layouts/AdminLayout.vue';
import Home from '../views/Home.vue';
import Login from '../views/Login.vue';
import { useAuthStore } from '../stores/auth';

import Dashboard from '../views/admin/Dashboard.vue';
import Sparepart from '../views/admin/Sparepart.vue';
import Pembelian from '../views/admin/Pembelian.vue';
import ChatbotRule from '../views/admin/ChatbotRule.vue';
import ServiceIndex from '../views/admin/ServiceIndex.vue';
import ServiceCreate from '../views/admin/ServiceCreate.vue';
import ServiceManage from '../views/admin/ServiceManage.vue';

const routes = [
    {
        path: '/',
        component: PublicLayout,
        children: [
            { path: '', name: 'Home', component: Home }
        ]
    },
    {
        path: '/login',
        name: 'Login',
        component: Login
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            { path: '', redirect: '/admin/dashboard' },
            { path: 'dashboard', name: 'Dashboard', component: Dashboard },
            { path: 'service', name: 'ServiceIndex', component: ServiceIndex },
            { path: 'service/create', name: 'ServiceCreate', component: ServiceCreate },
            { path: 'service/:id', name: 'ServiceManage', component: ServiceManage },
            { path: 'sparepart', name: 'Sparepart', component: Sparepart },
            { path: 'stock-adjustment', name: 'Pembelian', component: Pembelian },
            { path: 'chatbot-rule', name: 'ChatbotRule', component: ChatbotRule },
            { path: 'pelanggan', name: 'PelangganManage', component: () => import('../views/admin/PelangganManage.vue') },
            { path: 'kendaraan', name: 'KendaraanManage', component: () => import('../views/admin/KendaraanManage.vue') },
            { path: 'distributor', name: 'DistributorManage', component: () => import('../views/admin/DistributorManage.vue') },
            { path: 'users', name: 'KaryawanManage', component: () => import('../views/admin/KaryawanManage.vue') },
        ]
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

// Navigation Guard
router.beforeEach((to, from, next) => {
    const authStore = useAuthStore();
    
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        next({ name: 'Login' });
    } else if (to.name === 'Login' && authStore.isAuthenticated) {
        next('/admin');
    } else {
        next();
    }
});

export default router;
