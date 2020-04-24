<template>
	<ul class="tabs-menu">
		<slot></slot>
	</ul>	<!-- /.tabs-menu -->
</template>

<script>
	export default {
		data() {
			return {
				name: null,
				linkClass: null,
				menuItem: document.getElementsByClassName('tabs-menu__item'),
				menuContent: document.getElementsByClassName('tabs-content')
			}
		},
		methods: {
			onClick() {
				let menuItem = this.menuItem,
					menuContent = this.menuContent,
					tempItemsList = []

				for (let i = 0; i < menuItem.length; i ++) {
					menuItem[i].addEventListener('click', function(e) {
						e.preventDefault()
						// remove 'active' classes from other items
						for (let i = 0; i < menuItem.length; i ++) {
							menuItem[i].classList.remove('is-active') 
						}
						// add 'active' to clicked element
						this.classList.add('is-active')

						// remove 'active' classes from other contents
						for (let i = 0; i < menuContent.length; i ++) {
							menuContent[i].classList.remove('is-active') 
						}
						// check if content exist, then get relevant content 'id' via item's 'data-id'
						if (document.getElementById(this.getAttribute('data-id'))) {
							let content = document.getElementById(this.getAttribute('data-id'))
							content.classList.add('is-active')
						}
						else {
							console.log('something went wrong, checkout tabs-content script')
						}
					})
				}
			},
			init() {
				this.onClick()
			}
		},
		mounted() {
			this.init()
		}
	}
</script>

<style>

	.tabs-menu__item > a {
		cursor: pointer;
	}

	.tabs-content {
		display: none;
	}

	.tabs-content.is-active {
		display: block;
	}
</style>