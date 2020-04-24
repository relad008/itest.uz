<template>
    <div>
        <div class="payment container">

            <i-navigation></i-navigation>
            
            <section class="tariff pb-layout-xs pt-0 b-b animated fadeInUp">

                <div class="row">
                <div class="col-md-4 col-sm-6" v-for="(price, index) in prices" :key="index" :class="{'col-md-push-0 col-sm-push-3' : index === 2}">
                    <div class="tariff__card" :class="{'tariff__card--super' : index === 1}">
                        <div class="tariff__card-super-title" v-if="index === 1">{{ trans('cabinet.payment.card.recommended') }}</div>
                        <div class="tariff__card-header">
                            <h3 class="title-sm font-regular text-normal text-center">{{ price.name }}</h3>
                        </div>  <!-- /.tariff__card-header -->
                        <div class="tariff__card-body">
                            <div class="tariff__card-price-wrap">
                                <p class="tariff__card-price">{{ price.price_format }} <span>{{ trans('cabinet.payment.card.soum_month') }}</span></p>
                            </div>
                            <div class="tariff__card-item">
                                <i class="icon-check"></i>
                                <p>
                                    <span class="font-semibold">{{ price.thematic_count }}</span>
                                    {{ trans('cabinet.payment.card.thematic_tests') }}
                                </p>
                            </div>
                            <div class="tariff__card-item">
                                <i class="icon-check"></i>
                                <p>
                                    <span class="font-semibold">{{ price.direction_count }}</span>
                                    {{ trans('cabinet.payment.card.direction_tests') }}
                                </p>
                            </div>
                            <div class="tariff__card-item tariff__card-item--last">
                                <i v-if="parseInt(price.has_chat)" class="icon-check"></i>
                                <i v-else class="icon-close"></i>
                                <p>
                                    {{ trans('cabinet.payment.card.free_consultation') }} 
                                    <span class="font-semibold">Profi Education</span>
                                </p>
                            </div>
                            <div class="text-center">
                                <router-link :to="'/pay/' + price.id" class="btn btn--blue">{{ trans('cabinet.payment.card.buy_subscription') }}</router-link>
                            </div>
                        </div>  <!-- /.tariff__card-body -->
                    </div>  <!-- /.tariff__card -->
                </div>

                </div>  <!-- /.row -->

            </section>  <!-- /.tariff -->

            <div class="payment__logos-wrap">
                <p class="font-medium text-lg my-xs py-lg">Способы оплаты</p>

                <div class="payment__logo-wrap">
                    <img :src="logoClick" alt="Click">
                </div>
                <div class="payment__logo-wrap">
                    <img :src="logoPayme" alt="Payme">
                </div>
                <div class="payment__logo-wrap">
                    <img :src="logoPaynet" alt="Paynet">
                </div>
            </div>  <!-- /.payment__logos-wrap -->

        </div>  <!-- /.container -->
    </div>
</template>

<script>
    import { priceList } from '@/api/price'
    export default {
        data () {
            return {
                logoClick: '../images/logo-click.jpeg',
                logoPayme: '../images/logo-payme.svg',
                logoPaynet: '../images/logo-paynet.png'
            }
        },
        computed: {
            prices () {
                return this.$store.getters.prices
            }
        },
        created () {
            if (this.$store.getters.prices.length === 0) {
                this.$store.dispatch('loadPrices')
            }
        }
    }
</script>
