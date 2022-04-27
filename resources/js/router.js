import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

// project pages
import Categories from './components/pages/Categories'
import SubCategories from './components/pages/SubCategories'
import Items from './components/pages/Items'

const routes = [


    // projects routes....
    {
        path: "/",
        redirect: "/categories"
    },
    {
        path: '/categories',
        component: Categories,
        name: "Category",
    },
    {
        path: '/:categoryId/SubCategories',
        component: SubCategories,
        name: "SubCategory",
    },
    {
        path: '/:categoryId/SubCategories/:subCategoryId/Items',
        component: Items,
        name: "Items"
    },
]

export default new Router({
    mode: 'history',
    routes
})