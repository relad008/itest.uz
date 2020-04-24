<template>
    <div class="cab-nav-wrap">
        <div class="title-wrap clr-block">
            <div class="title-wrap__start">
                <h2 class="title">{{ title }}</h2>
                <p class="subtitle">{{ subtitle }}</p>
            </div>  <!-- /.title-wrap__start -->
            <div class="title-wrap__end">
                <p class="title-wrap__payment">
                    <i class="icon-money"></i>
                    {{ trans('cabinet.header.your_balance') }}: <span class="font-medium" v-if="user">{{ user.balance.toLocaleString('ru-RU') }} {{ trans('cabinet.soum') }}</span>
                </p>
                <router-link to="/payment" class="btn btn--brand">{{ trans('cabinet.btn.pay_tests') }}</router-link>
            </div>  <!-- /.title-wrap__end -->
        </div>  <!-- /.title-wrap -->
        <div class="cab-nav">
            <router-link to="/" class="cab-nav__link" :class="{ active: routeName == 'Dashboard' }"><span>{{ trans('cabinet.header.stats') }}</span></router-link>
            <router-link to="/direction-select" class="cab-nav__link" :class="{ active: routeName == 'Demo' }"><span>{{ trans('cabinet.header.direction_test') }}</span></router-link>
            <router-link to="/thematic" class="cab-nav__link" :class="{ active: routeName == 'Thematic' }"><span>{{ trans('cabinet.header.thematic_test') }}</span></router-link>
            <router-link to="/history" class="cab-nav__link" :class="{ active: routeName == 'History' }"><span>{{ trans('cabinet.header.history') }}</span></router-link>
            <router-link to="/profile" class="cab-nav__link" :class="{ active: routeName == 'Profile' }"><span>{{ trans('cabinet.header.profile') }}</span></router-link>
            <router-link to="/tickets" class="cab-nav__link" :class="{ active: (routeName == 'Tickets' || routeName == 'TicketInner') }"><span>{{ trans('cabinet.header.tickets') }}</span></router-link>
        </div>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'
	export default {
		data() {
			return {
                routeName: null,
                title: null,
                subtitle: null,
                balance: 0
			}
        },
        computed: {
            ...mapGetters(['user']),
        },
        mounted() {
            let currentRoute = this.$router.currentRoute
            this.routeName = currentRoute.name
            this.title = currentRoute.meta.title
            this.subtitle = currentRoute.meta.subtitle
        }
	}
</script>