<template>
    <div>
        <h1>Create new campaign</h1>
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
            <b-row>
                <b-col>

                    <b-form-group
                        id="creativeGroup"
                        label="Upload Creatives"
                        label-for="creatives"
                        :class="{ 'form-group--error': $v.campaign.creatives.$error }"
                    >
                        <b-form-file
                            id="creatives"
                            v-model="campaign.creatives"
                            placeholder="Choose files or drop it here..."
                            drop-placeholder="Drop file here..."
                            multiple
                            ref="creatives"
                            @change="grabFile"
                        ></b-form-file>
                        <span class="text-danger" v-if="validationErrors.creatives">
                            {{ validationErrors.creatives[0] }}
                        </span>
                        <div class="text-danger" v-if="!$v.campaign.creatives.required">Minimum 1 creative is mandatory</div>
                    </b-form-group>
                </b-col>
                <b-col v-if="creativeUrlForPreview.length">
                    <span v-for="(image, index) in creativeUrlForPreview" :key="index">
                        <img :src="image" width="20%">
                        <b-button variant="danger" @click="removeCreative(index)">Delete</b-button>
                        <br>
                    </span>
                </b-col>
            </b-row>
            <br>
            <b-button type="submit" variant="primary">Submit</b-button>
            <b-button @click="$router.push({name:'campaign.list'})" variant="info">Back</b-button>

        </b-form>
    </div>
</template>

<script>
import { required, maxLength, minValue } from 'vuelidate/lib/validators'
export default {
    name: "create",
    data() {
        return {
            campaign: {
                name: '',
                from: '',
                to: '',
                total_budget: '',
                daily_budget: '',
                creatives: []
            },
            files: [],
            validationErrors: {},
            creativeUrlForPreview: []
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
            },
            creatives: {
                required
            }
        }
    },
    methods: {
        async onSubmit(event) {
            event.preventDefault()
            this.$v.campaign.$touch();

            if (this.$v.campaign.$error) return;
            var formData = new FormData();

            for(let i=0;i<this.files.length;i++) {
                formData.append('creatives[]', this.files[i])
            }
            if(this.campaign.name != '') {
                formData.append('name',this.campaign.name)
            }
            if(this.campaign.from != '') {
                formData.append('from',this.campaign.from)
            }
            if(this.campaign.to != '') {
                formData.append('to', this.campaign.to)
            }
            if(this.campaign.total_budget != '') {
                formData.append('total_budget', this.campaign.total_budget)
            }
            if(this.campaign.daily_budget != '') {
                formData.append('daily_budget', this.campaign.daily_budget)
            }
            const response = await this.callApi(
                'post',
                '/api/campaign/store',
                formData
                );
            switch (response.status){
                case 201:
                    this.campaign = {}
                    this.setFlashMessage(
                        'success',
                        'Campaign',
                        'Created successfully'
                    )
                    this.$router.push({name: "campaign.list"})
                    break
                case 422:
                    this.validationErrors = response.data.errors
                    break
                default:
                    this.setFlashMessage(
                        'error',
                        'Campaign Create',
                        response.data
                    )
                    this.showFlashMessage()
            }
        },

        grabFile(event) {
            let files = event.target.files;
            for(var i=0;i<files.length;i++){
                this.files.push(files[i])
                this.creativeUrlForPreview.push(URL.createObjectURL(files[i]))
            }
        },

        removeCreative(index) {
            this.files.splice(index,1)
            this.creativeUrlForPreview.splice(index,1)
        }
    }
}
</script>
