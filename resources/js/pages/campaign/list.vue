<template>
    <div>
        <h1>Campaigns</h1>
        <router-link :to="{name : 'campaign.create'}">Create New Campaign</router-link>
        <b-row v-if="campaigns.length">
            <b-col md="3">
                <b-form-input
                    v-model="filter"
                    type="search"
                    id="filterInput"
                    placeholder="Type to Search"
                ></b-form-input>
            </b-col>
        </b-row>
        <b-row v-if="campaigns.length">
            <b-col>
                <b-table
                    striped
                    hover
                    outlined
                    :items="campaigns"
                    :filter="filter"
                    :per-page="perPage"
                    :current-page="currentPage"
                    :fields="fields"
                >

                    <template v-slot:cell(actions)="data">
                        <CampaignCreatives :campaign="data.item"></CampaignCreatives>
                        <b-button
                            @click="$router.push({name: 'campaign.edit',params: {id: data.item.id}})"
                            variant="info"
                        >Edit</b-button>
                    </template>
                </b-table>
                <b-pagination
                    v-model="currentPage"
                    :total-rows="rows"
                    :per-page="perPage"
                    aria-controls="my-table"
                ></b-pagination>
            </b-col>
        </b-row>
        <b-row v-else>
            <b-col>No campaign found</b-col>
        </b-row>
    </div>
</template>

<script>
import moment from "moment";
import CampaignCreatives from '../../components/common/CampaignCreatives'
export default {
    name: "list",
    components: {
        CampaignCreatives
    },
    data() {
        return {
            campaigns : {},
            fields : ["name",'from','to','daily_budget','total_budget','created_at','actions'],
            filter : '',
            perPage : 10,
            currentPage : 1,
            modal: {
                title: '',
                creatives: []
            }
        };
    },
    async created(){
        this.getList()
        this.showFlashMessage()
    },
    methods: {
        async getList(){
            const response = await this.callApi(
                'get',
                '/api/campaign/index'
            );
            if(response.status == 200) {
                this.campaigns = response.data.map(campaign => {
                    return {
                        id: campaign.id,
                        name: campaign.name,
                        from: moment(campaign.from).format("Do MMMM YYYY"),
                        to: moment(campaign.to).format("Do MMMM YYYY"),
                        daily_budget: '$'+parseFloat(campaign.daily_budget).toFixed(2),
                        total_budget: '$'+parseFloat(campaign.total_budget).toFixed(2),
                        created_at: moment(campaign.created_at).format("Do MMMM YYYY, h:mm:ss a"),
                        creatives: campaign.creatives,
                    }
                })
            }
        }
    },
    computed: {
        rows() {
            return this.campaigns.length;
        }
    },
}
</script>
