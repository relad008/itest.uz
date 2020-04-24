<template>
    <div>
        <div class="payment container">

            <i-navigation></i-navigation>
            
            <div class="animated fadeInUp">
                <div class="clr-block pb-lg b-b">
                    <p class="font-medium text-lg float-left">{{ trans('cabinet.payment.refill_budget') }}</p>
                    <router-link to="/payment" class="link text float-right pt-xs">
                        <i class="icon-arrow-left text-sm mr-xs"></i>
                        {{ trans('cabinet.payment.back_to_subscription_choose') }}
                    </router-link>
                </div>

                <div class="payment__info">
                    <p class="pb-sm">
                        <i class="icon-subscribe mr-sm"></i>
                        <span class="mr-xs">{{ trans('cabinet.payment.subscription_type') }}: <span class="font-medium">{{ price.name || '' }}</span></span>
                        <router-link to="/payment">
                            <i class="icon-edit edit"></i>
                        </router-link>
                    </p>
                    <p>
                        <i class="icon-money mr-sm"></i>
                        <span>{{ trans('cabinet.payment.to_pay') }} <span class="font-medium">{{ price.price_format || '' }} {{ trans('cabinet.soum') }}</span></span>
                    </p>
                </div>  <!-- /.payment__info -->
                
                <div class="payment__card-wrap">
                    <div class="row">

                        <div class="col-md-4 col-sm-6">
                            <div class="payment__card">
                                <img :src="logoClick" class="payment__card-thumb" alt="Click">
                                <p class="font-medium text-lg pb-lg mb-xs">{{ trans('cabinet.payment.to_pay_via_click') }}</p>
                                <p class="pb-lg mb-xs">{{ trans('cabinet.payment.click_number_binding') }}</p>
                                <div class="form-group mb-lg">
                                    <md-field>
                                        <label class="label">{{ trans('cabinet.payment.tel_number') }}</label>
                                        <md-input v-model="phone"></md-input>
                                    </md-field>
                                </div>
                                <p class="pb-lg">{{ trans('cabinet.payment.click_button') }}</p>
                                <button v-if="showClickSend" @click.stop="onSendClickInvoice" class="btn btn--blue mb-lg">{{ trans('cabinet.payment.fill_by_click') }}</button>
                                <p>{{ trans('cabinet.payment.click_instructions') }}</p>
                            </div>  <!-- /.payment__card -->
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="payment__card">
                                <img :src="logoPayme" class="payment__card-thumb" alt="Payme">
                                <p class="font-medium text-lg pb-lg mb-xs">{{ trans('cabinet.payment.to_pay_via_payme') }}</p>
                                <p class="pb-xl">
                                    {{ trans('cabinet.payment.payme_instructions_1') }}<br>
                                    {{ trans('cabinet.payment.payme_instructions_2') }}<br>
                                    {{ trans('cabinet.payment.payme_instructions_3') }}
                                </p>
                                <p class="pb-lg">{{ trans('cabinet.payment.click_button') }}</p>
                                <form id="form-payme" method="POST" action="https://checkout.paycom.uz/" class="ng-pristine ng-valid">
                                    <input type="hidden" name="merchant" value="58ac189bce775bff41f43154">
                                    <input type="hidden" name="account[phone]" :value="user.phone">
                                    <input type="hidden" name="amount" :value="parseInt(price.price)*100">
                                    <input type="hidden" name="lang" value="ru">
                                    <button class="btn btn--brand">{{ trans('cabinet.payment.pay_payme') }}</button>
                                </form>
                            </div>  <!-- /.payment__card -->
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <div class="payment__card">
                                <img :src="logoPaynet" class="payment__card-thumb" alt="Paynet">
                                <p class="font-medium text-lg pb-lg mb-xs">{{ trans('cabinet.payment.to_pay_via_paynet') }}:</p>
                                <p class="pb-lg">{{ trans('cabinet.payment.operator') }} itest.uz,</p>
                                <p class="pb-lg">{{ trans('cabinet.payment.user_id') }} <span class="font-semibold">{{ user.phone }}</span> <br> {{ trans('cabinet.payment.min_price') }} <br> {{ trans('cabinet.payment.to') }} 1 000 000 {{ trans('cabinet.soum') }}</p>
                                <p class="pb-xl">{{ trans('cabinet.payment.click_button') }}</p>
                                <button class="btn btn--brand" @click.stop="onBuyFromAccount">{{ trans('cabinet.payment.take_from_balance') }}</button>
                            </div>  <!-- /.payment__card -->
                        </div>

                    </div>  <!-- /.row -->
                </div>  <!-- /.payment__card-wrap -->
            </div>

        </div>  <!-- /.container -->
    </div>
</template>

<script>
    import { sendClickInvoice, buyFromAccount } from '@/api/pay'

    export default {
        data() {
            return {
                phone: '',
                showClickSend: true,
                logoClick: '../images/logo-click.jpeg',
                logoPayme: '../images/logo-payme.svg',
                logoPaynet: '../images/logo-paynet.png'
            }
        },
        computed: {
            price () {
                return this.$store.getters.price(this.$route.params.id)
            },
            
			user() {
				return this.$store.getters.user;
			},
        },
        created () {
            if (this.$store.getters.prices.length === 0) {
                this.$store.dispatch('loadPrices')
            }
        },
        methods: {
            onSendClickInvoice() {
                sendClickInvoice({
                    phone: this.phone,
                    price_id: this.price.id
                }).then(res => {
                    if (res.data.status) {
                        this.showClickSend = false
                        this.$notify({
                            group: 'cabinet',
                            text: 'Cчет отправлен',
                            type: 'alert-success',
                            duration: 4 * 1000
                        })
                    }
                })
            },

            onBuyFromAccount() {
                buyFromAccount({
                    price_id: this.price.id
                }).then(res => {
                    
                    this.$notify({
                        group: 'cabinet',
                        text: res.data.message,
                        type: res.data.status ? 'alert-success' : 'alert-danger',
                        duration: 4 * 1000
                    })

                })
            },
        }
    }
</script>
