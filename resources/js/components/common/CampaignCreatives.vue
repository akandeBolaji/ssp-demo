<template>
    <div>
        <b-button
            @click="viewCreatives()"
            variant="success"
        >Creatives</b-button>
        <b-modal ref="creativeModal" hide-footer>
            <template #modal-title>
                Creatives for {{ title }}
            </template>
            <div class="d-block text-center">
                <img v-for="creative in creatives" :src="'../storage/'+creative.img_path" :key="creative.id" width="100%">
            </div>
        </b-modal>
    </div>
</template>

<script>
export default {
    name: "CampaignCreatives",
    data() {
        return {
            title: '',
            creatives: '',
        }
    },
    props: [
        "campaign"
    ],
    methods: {
        viewCreatives(){
            this.title = this.campaign.name
            this.creatives = this.campaign.creatives
            this.$refs['creativeModal'].show();
        }
    }
}
</script>
