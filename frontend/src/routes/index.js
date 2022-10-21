import Vue from 'vue'
import VueRouter from 'vue-router'
Vue.use(VueRouter)
import postList from '../pages/post/list'

const routes = [
    {
        path: '/',
        name: 'postList',
        componemt : postList
    }
]

const router = new VueRouter({
    mode: "history",
    routes,
})

export default router