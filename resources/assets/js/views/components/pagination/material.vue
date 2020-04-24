<template>
    <div class="table-nav">
        <p>{{ trans('cabinet.pagination.show') }}</p>
        <div class="table-nav__s-wrap">
            <select v-model="pagination.perPage" @change="changePerPage">
                <option v-for="n in perPageRange" :value="n" :key="n">{{ n }}</option>
            </select>
            <i class="icon-dropdown-arrow"></i>
        </div>
        <p>{{ trans('cabinet.pagination.records') }}</p>
        <p class="table-nav__quantity">{{ from }}-{{ to }} {{ trans('cabinet.pagination.from') }} {{ pagination.total }}</p>
        <button @click="prevPage" class="table-nav__arrow">
            <i class="icon-arrow-left"></i>
        </button>
        <button @click="nextPage" class="table-nav__arrow">
            <i class="icon-arrow-right"></i>
        </button>
    </div>	<!-- /.table-nav -->
</template>

<script>
    export default {
        props: {
            pagination: {
                type: Object,
                required: true
            }
        },
        watch: {
            pagination (val) {
                this.render()
            }
        },
        data () {
            return {
                from: 0,
                to: 0,
                perPageRange: [ 20, 30, 50 ],
            }
        },
        methods: {
            render () {
                if (this.pagination.currentPage == 1) {
                    this.from = 1
                    this.to = this.pagination.total > this.pagination.perPage ?
                        this.pagination.perPage : this.pagination.items
                        
                } else {
                    this.from = (this.pagination.currentPage - 1)
                               * this.pagination.perPage
                    this.to = this.from + this.pagination.items
                }
            },

            changePerPage () {
				this.$emit('paginate')
            },
            
            nextPage () {
                if (this.pagination.total > this.pagination.perPage * this.pagination.currentPage) {
                    this.pagination.currentPage += 1
                    this.$emit('paginate')
                }
            },

            prevPage () {
                if (this.pagination.currentPage != 1) { 
                    this.pagination.currentPage -= 1
                    this.$emit('paginate')
                }
            }
        }
    }
</script>
