<template>
    <div>
        <div class="container">

            <i-navigation></i-navigation>
			
			<div class="history animated fadeInUp">
				<div class="table-wrap history-table-wrap mb-layout-xs">
		            <table class="table history__table">
						<thead>
						    <tr>
						    	<th class="table-h history__table-h">{{ trans('cabinet.history.data') }}</th>
						    	<th class="table-h history__table-h">{{ trans('cabinet.history.amount') }}</th>
						    	<th class="table-h history__table-h">{{ trans('cabinet.history.action') }}</th>
						    	<th class="table-h history__table-h">{{ trans('cabinet.history.details') }}</th>
						    </tr>
						</thead>
						<tbody>
						    <tr v-for="(item, index) in items" :key="index">
						    	<td class="table-col history__table-col">{{ item.created_at }}</td>
						    	<td class="table-col history__table-col" :class="{'text-success': item.sum > 0, 'text-danger' : item.sum <= 0}"><strong>{{ item.sum.toLocaleString('ru-RU') }}</strong> сум</td>
						    	<td class="table-col history__table-col">
									{{ item.price ? item.price.name_ru : '-' }}	
								</td>
						    	<td class="table-col history__table-col">
									<span v-if="item.type == 'paynet'">
										{{ trans('cabinet.payment.by_paynet') }}
									</span>
									<span v-else-if="item.type == 'payme'">
										{{ trans('cabinet.payment.by_payme') }}
									</span>
									<span v-else-if="item.type == 'price'">
										{{ trans('cabinet.payment.by_click') }}
									</span>
									<span v-else>
										-
									</span>
								</td>
						    </tr>
						</tbody>
					</table>  <!-- /.table -->
					<div class="clr-block">
						<i-pagination
							:pagination="pagination"
							@paginate="getTable()"
						></i-pagination>
					</div>
				</div>	<!-- /.table-wrap -->
			</div>	<!-- /.history -->

        </div>	<!-- /.container -->
    </div>
</template>

<script>
	import { accountList } from '@/api/account'
    export default {

        data() {
            return {
				items: [],
				pagination: {
					perPage: 20
				}
            }
		},
		
        created() {
			this.getTable()
		},
		
		methods: {
			getTable () {
				
				let currentPage = this.pagination.currentPage || 1
				let perPage = this.pagination.perPage || 20
				
				accountList(currentPage, perPage).then( res => {
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
			}
		}
    }
</script>