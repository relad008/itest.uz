<template>
    <div>
        <div class="profile container">

            <i-navigation></i-navigation>

            <div class="row animated fadeInUp">
            	<div class="col-lg-3 col-md-4">
                    
                    <div class="p-xl blocks-shadow rounded bg-white">
                        <p class="font-semibold mb-lg">{{ theme }}</p>
                        <div class="tickets__info mb-md">
                            <i class="icon-file-expected"></i>
                            <div>
                                <p class="text-sm">{{ trans('cabinet.tickets.last_message') }}</p>
                                <p class="text text-black">{{ lastMessage }}</p>
                            </div>
                        </div>
                        <div class="tickets__info">
                            <i class="icon-clock"></i>
                            <div>
                                <p class="text-sm">{{ trans('cabinet.tickets.created_date') }}</p>
                                <p class="text text-black">{{ createdAt }}</p>
                            </div>
                        </div>
                    </div>

                    <router-link 
                        to="/tickets"
                        class="btn btn--brand btn--y-lg mt-xl mb-sm full-width text-center"
                    >
                        Назад
                    </router-link>

                    <a 
                        class="btn btn--danger btn--y-lg full-width text-center"
                        @click.prevent="closeTicket">
                        {{ trans('cabinet.tickets.close') }}
                    </a>


            	</div>	<!-- /.col-md-3 -->
            	<div class="col-lg-9 col-md-8">

					<div class="tickets">

                        <div class="tickets__chat">
                            <div class="tickets__chat-content js-message-display">
                                <div class="tickets__chat-fixed-wrap">

                                    <div v-for="(item, i) in messages" :key="i" class="tickets__chat-answer" :class="{ 'tickets__chat-answer--my' : loadedUser && item.user_id == loadedUser.id, 'tickets__chat-answer--others' : loadedUser && item.user_id != loadedUser.id}">
                                        <p class="tickets__chat-answer-date">{{ item.user.name || 'Deleted' }} - {{ item.created_at }}</p>
                                        <p class="tickets__chat-answer-text">{{ item.message }}</p>
                                    </div>

                                </div>	<!-- /.tickets__chat-fixed-wrap -->
                            </div>	<!-- /.tickets__chat-content -->
                            <div class="tickets__chat-footer">
                                <div class="form-group mb-0">
                                    <form @submit.prevent="sendMessage">
                                        <div class="input-group">
                                            <md-field>
                                                <label>{{ trans('cabinet.tickets.message') }}</label>
                                                <md-input v-model="message"></md-input>
                                            </md-field>
                                            <div class="input-group-btn-wrap">
                                                <button class="btn btn--brand">{{ trans('cabinet.btn.send') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>	<!-- /.tickets__chat -->

		            </div>	<!-- /.profile__tabs-content -->

            	</div>	<!-- /.col-md-7 -->
            </div>	<!-- /.row -->
        </div>	<!-- /.profile .container -->

    </div>
</template>

<script>
    import { ticketMessages, ticketSend, ticketClose } from '@/api/ticket'

    export default {
        data() {
            return {
                theme: '',
                lastMessage: '',
                createdAt: '',

            	message: null,
                messages: [],
                lastMessagePage: 1,
            }
        },

        computed: {
			loadedUser() {
				return this.$store.getters.user;
			}
		},

        created() {
			this.openTicket(this.$route.params.id)
		},

        methods: {

            openTicket(id) {
                this.lastMessagePage = 1
                this.messages = []
                ticketMessages(id, this.lastMessagePage).then( res => {
                    let data = res.data
                    this.theme = data.theme
                    this.lastMessage = data.last_message
                    this.createdAt = data.created_at
                    this.messages = data.messages.data.reverse();
                    this.$nextTick(() => {
                        this.scrollToEnd()
                    })
                    
                })
            },

            sendMessage() {
                ticketSend({
                    ticket_id: this.$route.params.id,
                    message  : this.message,
                }).then( res => {
                    if (parseInt(res.data.status)) {
                        this.message = ''
                        this.messages.push(res.data.message)
                        this.$nextTick(() => {
                            this.scrollToEnd()
                        })
                    }
                })
            },

            scrollToEnd () {    	
                var container = this.$el.querySelector(".js-message-display");
                container.scrollTop = container.scrollHeight;
            },

            closeTicket() {
                ticketClose({
                    id: this.$route.params.id
                }).then((res) => {
                    if (res.data.status) {
                        this.$router.push('/tickets')
                    }
                })
            }
		}
    }
</script>