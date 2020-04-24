<template>
    <div>
        <div class="profile container">

            <i-navigation></i-navigation>

            <div class="row animated fadeInUp">
            	<div class="col-lg-3 col-md-4">
					
					<button 
						class="btn btn--brand btn--y-lg mb-xl full-width text-center"
						@click="newTicket = true">
						{{ trans('cabinet.tickets.new_ticket') }}
					</button>
					
                    <ul class="profile__nav">
                        <li class="profile__nav-item" :class="{'is-active' : type == 'all'}">
                            <a href="#" @click.prevent="getTable('all')" class="profile__nav-link">
                                <i class="icon-file-all icon--lg"></i>
                                {{ trans('cabinet.tickets.tabs.all') }}
                            </a>
                        </li>
                        <li class="profile__nav-item" :class="{'is-active' : type == 'open'}">
                            <a href="#" @click.prevent="getTable('open')" class="profile__nav-link">
                                <i class="icon-file-opened icon--lg"></i>
                                {{ trans('cabinet.tickets.tabs.opened') }}
                            </a>
                        </li>
                        <li class="profile__nav-item" :class="{'is-active' : type == 'expected'}">
                            <a href="#" @click.prevent="getTable('expected')" class="profile__nav-link">
                                <i class="icon-file-expected icon--lg"></i>
                                {{ trans('cabinet.tickets.tabs.expected') }}
                            </a>
                        </li>
                        <li class="profile__nav-item">
                            <a href="#" @click.prevent="getTable('closed')" class="profile__nav-link" :class="{'is-active' : type == 'closed'}">
                                <i class="icon-file-closed icon--lg"></i>
                                {{ trans('cabinet.tickets.tabs.closed') }}
                            </a>
                        </li>
                    </ul>
            	</div>	<!-- /.col-md-3 -->
            	<div class="col-lg-9 col-md-8">

					<div class="tickets">
						
						<template v-if="!newTicket">
                            <div class="table-wrap">
                                <table class="table tickets__table">
                                    <thead>
                                        <tr>
                                            <th class="table-h">ID</th>
                                            <th class="table-h">{{ trans('cabinet.tickets.table.topic') }}</th>
                                            <th class="table-h">{{ trans('cabinet.tickets.table.date') }}</th>
                                            <th class="table-h">{{ trans('cabinet.tickets.table.status') }}</th>
                                            <th class="table-h">{{ trans('cabinet.tickets.table.answers') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in items" :key="index" @click.prevent="openTicket(item.id)">
                                            <td class="table-col">{{ item.id }}</td>
                                            <td class="table-col">{{ item.theme }}</td>
                                            <td class="table-col">{{ item.created_at }}</td>
                                            <td class="table-col">{{ parseInt(item.status) ? 'Открытый' : 'Закрытый' }}</td>
                                            <td class="table-col">{{ item.messages_count }}</td>
                                        </tr>
                                    </tbody>
                                </table>  <!-- /.table -->
                                <div class="clr-block">
                                    <div class="clr-block">
                                        <i-pagination
                                            :pagination="pagination"
                                            @paginate="getTable()"
                                        ></i-pagination>
                                    </div>
                                </div>
                            </div>	<!-- /.table-wrap -->
			            </template>	<!-- /.!newTicket -->

			            <template v-if="newTicket">
			            	<div class="tickets__card">
			            		<div class="tickets__card-header">{{ trans('cabinet.tickets.new_ticket') }}</div>
			            		<div class="tickets__card-body">
                                    <form @submit.prevent="create">
                                        <md-field>
                                            <label>{{ trans('cabinet.tickets.topic') }}</label>
                                            <md-input v-model="createForm.theme"></md-input>
                                        </md-field>
                                        <md-field>
                                            <label>{{ trans('cabinet.tickets.message') }}</label>
                                            <md-textarea v-model="createForm.message" class="md-input" md-autogrow></md-textarea>
                                        </md-field>
                                        <div class="mb-lg">
                                            <button type="submit" class="btn btn--brand mr-lg mb-md-400-full-size">{{ trans('cabinet.btn.send') }}</button>
                                            <a href="#" class="btn btn--blue mb-md-400-full-size" @click.prevent="newTicket = false">{{ trans('cabinet.btn.cancel') }}</a>
                                        </div>
                                    </form>
				            		<p class="text-sm text-gray">
				            			<b>{{ trans('cabinet.tickets.info_1') }}</b> 
				            			{{ trans('cabinet.tickets.info_2') }}<br> 
				            			{{ trans('cabinet.tickets.info_3') }}
				            		</p>
				            	</div>	<!-- /.tickets__card-body -->
			            	</div>	<!-- /.tickets__card -->
			            </template>	<!-- /.newTicket -->

		            </div>	<!-- /.profile__tabs-content -->

            	</div>	<!-- /.col-md-7 -->
            </div>	<!-- /.row -->
        </div>	<!-- /.profile .container -->

    </div>
</template>

<script>
	import Tabs from '../components/tabs/tabs.vue'
	import TabsMenu from '../components/tabs/tabs-menu.vue'
    import TabsContent from '../components/tabs/tabs-content.vue'
    import { ticketList, ticketCreate, ticketMessages } from '@/api/ticket'

    export default {
        data() {
            return {
                createForm: {
                    theme: '',
                    message: ''
                },
                type: 'all',
            	newTicket: false,
                sendMessage: null,
                items: [],
				pagination: {
					perPage: 20
                }
            }
        },

        components: {
        	'mb-tabs': Tabs,
        	'mb-tabs-menu': TabsMenu,
        	'mb-tabs-content': TabsContent
        },

        created() {
			this.getTable()
		},

        methods: {
			getTable (type) {
                type = type || 'all'
                this.type = type
				let currentPage = this.pagination.currentPage || 1
				let perPage = this.pagination.perPage || 20
				
				ticketList(type, currentPage, perPage).then( res => {
					let d = res.data
					this.items = d.data;
					this.pagination = {
						items: d.data.length,
						currentPage: d.current_page,
						total: d.total,
						perPage: d.per_page,
						nextPageUrl: d.next_page_url,
						prevPageUrl: d.prev_page_url
					}
				})
            },
            
            create () {
                ticketCreate(this.createForm).then( res => {
                    if (res.data.status) {
                        this.$notify({
							group: 'cabinet',
							text: res.data.message,
							type: 'alert-success',
							duration: 4000
                        })
                        
                        this.createForm = {
                            theme: '',
                            message: ''
                        }

                        this.openTicket(res.data.id)
                    }
                })
			},
			
			openTicket(id) {
				this.$router.push('/tickets/' + id)
			}
		}
    }
</script>