import VueRouter from 'vue-router'
import Layout from './views/Layout.vue'

const general = () => import(/* webpackChunkName:"general" */'./views/general.vue').then(m => m.default || m)
const client = () => import(/* webpackChunkName:"client" */'./views/client.vue').then(m => m.default || m)
const sign = () => import(/* webpackChunkName:"sign" */'./views/sign.vue').then(m => m.default || m)
const thanks = () => import(/* webpackChunkName:"thanks" */'./views/thanks.vue').then(m => m.default || m)

const routes = [
    {
        path: '/fax/general',
        component: Layout,
        children :[
            {
                name: 'general',
                path: '/fax/general/',
                component: general,
            },
            {
                name: 'client',
                path: '/fax/client/',
                component: client,
            },
            {
                name: 'sign',
                path: '/fax/sign/',
                component: sign,
            },
        ]
    },
    {
        name: 'thanks',
        path: '/fax/thanks/',
        component: thanks,
    },
]

const router = new VueRouter({
    mode: 'history',
    routes
});

router.beforeEach((to, from, next) => {
    return next()
});

export default router;