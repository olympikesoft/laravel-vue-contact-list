import { createRouter, createWebHistory } from 'vue-router';
import ContactList from '@/components/ContactList.vue';
import ContactForm from '@/components/ContactForm.vue';
import ContactDetails from '@/components/ContactDetails.vue';

const routes = [
    { path: '/', component: ContactList },
    { path: '/contacts/new', component: ContactForm },
    { path: '/contacts/:id', component: ContactDetails },
    { path: '/contacts/:id/edit', name: 'editContact', component: ContactForm },
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
