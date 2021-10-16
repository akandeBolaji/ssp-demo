<template>
    <div>
        <h1>Edit campaign</h1>
        <b-form @submit="onSubmit">
            <b-row>
                <b-col>
                    <b-form-group
                        id="nameGroup"
                        label="Name"
                        label-for="name"
                        :class="{ 'form-group--error': $v.campaign.name.$error }"
                    >
                        <b-form-input
                            id="name"
                            v-model.trim="$v.campaign.name.$model"
                            type="text"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.name">
                            {{ validationErrors.name[0] }}
                        </span>
                        <div class="text-danger" v-if="!$v.campaign.name.required">Name field is required</div>
                        <div class="text-danger" v-if="!$v.campaign.name.maxLength">Name must have maximum {{$v.campaign.name.$params.maxLength.max}} letters.</div>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>
                <b-col>
                    <b-form-group
                        id="FromDateGroup"
                        label="From"
                        label-for="from"
                        :class="{ 'form-group--error': $v.campaign.from.$error }"
                    >
                        <b-form-datepicker
                            id="from"
                            v-model.trim="$v.campaign.from.$model"
                            class="mb-2"
                        ></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.from">
                            {{ validationErrors.from[0] }}
                        </span>
                        <div class="text-danger" v-if="!$v.campaign.from.required">From date field is required</div>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group
                        id="toDateGroup"
                        label="To"
                        label-for="to"
                        :class="{ 'form-group--error': $v.campaign.to.$error }"
                    >
                        <b-form-datepicker
                            id="to"
                            v-model.trim="$v.campaign.to.$model"
                            class="mb-2"
                        ></b-form-datepicker>
                        <span class="text-danger" v-if="validationErrors.to">
                            {{ validationErrors.to[0] }}
                        </span>
                        <div class="text-danger" v-if="!$v.campaign.to.required">To date field is required</div>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-row>

                <b-col>
                    <b-form-group
                        id="totalBudgetGroup"
                        label="Total Budget"
                        label-for="total_budget"
                        :class="{ 'form-group--error': $v.campaign.total_budget.$error }"
                    >
                        <b-form-input
                            type="number"
                            step="0.01"
                            id="total_budget"
                            v-model.trim="$v.campaign.total_budget.$model"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.total_budget">
                            {{ validationErrors.total_budget[0] }}
                        </span>
                        <div class="text-danger" v-if="!$v.campaign.total_budget.required">Total budget field is required</div>
                        <div class="text-danger" v-if="!$v.campaign.total_budget.minValue">Total budget must be greater than 0</div>
                    </b-form-group>
                </b-col>
                <b-col>
                    <b-form-group
                        id="dailyBudgetGroup"
                        label="Daily Budget"
                        label-for="daily_budget"
                        :class="{ 'form-group--error': $v.campaign.daily_budget.$error }"
                    >
                        <b-form-input
                            type="number"
                            step="0.01"
                            id="daily_budget"
                            v-model.trim="$v.campaign.daily_budget.$model"
                        ></b-form-input>
                        <span class="text-danger" v-if="validationErrors.daily_budget">
                            {{ validationErrors.daily_budget[0] }}
                        </span>
                        <div class="text-danger" v-if="!$v.campaign.daily_budget.required">Daily budget field is required</div>
                        <div class="text-danger" v-if="!$v.campaign.daily_budget.minValue">Total budget must be greater than 0</div>
                    </b-form-group>
                </b-col>
            </b-row>
            <b-button type="submit" variant="primary">Update</b-button>
            <b-button @click="$router.push({name:'campaign.list'})" variant="info">Back</b-button>

        </b-form>
    </div>
</template>

<script>
import { required,maxLength,minValue } from 'vuelidate/lib/validators'
export default {
    name: "edit",
    data() {
        return {
            campaignId: '',
            files: [],
            validationErrors: {},
            campaign: {
                name: '',
                from: '',
                to: '',
                total_budget: '',
                daily_budget: ''
            }
        }
    },
    validations: {
        campaign: {
            name: {
                required,
                maxLength: maxLength(255)
            },
            from: {
                required
            },
            to: {
                required
            },
            total_budget: {
                required,
                minValue: minValue(1)
            },
            daily_budget: {
                required,
                minValue: minValue(1)
            }
        }
    },
    created() {
        this.campaignId = this.$route.params.id
        this.getCampaign()
    },
    methods: {
        async getCampaign(){
            const response = await this.callApi(
                'get',
                '/api/campaign/'+this.campaignId
            );
            if(response.status == 200){
                this.campaign = response.data
            }
        },
        async onSubmit(event) {
            event.preventDefault()
            this.$v.campaign.$touch();
            // if its still pending or an error is returned do not submit
            if (this.$v.campaign.$error) return;
            const response = await this.callApi(
                'put',
                '/api/campaign/'+this.campaignId,
                this.campaign
            );
            switch (response.status){
                case 204:
                    this.form = {}
                    this.setFlashMessage(
                        'success',
                        'Campaign',
                        'Updated successfully'
                    )
                    this.$router.push({name: "campaign.list"})
                    break
                case 422:
                    this.validationErrors = response.data.errors
                    break
                default:
                    this.setFlashMessage(
                        'error',
                        'Campaign Edit',
                        response.data
                    )
                    this.showFlashMessage()
            }
        }
    }
}
</script>
