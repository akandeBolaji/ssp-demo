import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

import campaigns from './pages/campaign/list'
import editCampaign from './pages/campaign/edit'
import createNewCampaign from './pages/campaign/create'

const routes = [
    {
        path : '/',
        component : campaigns,
        name : 'campaign.list'
    },

    {
        path : '/campaign/create',
        component : createNewCampaign,
        name : 'campaign.create'
    },

    {
        path : '/campaign/edit/:id',
        component : editCampaign,
        name : 'campaign.edit'
    }
]

export default new Router({
    mode: 'history',
    routes
})
