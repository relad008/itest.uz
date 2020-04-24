<template>
    <div>
        <div class="profile container">

            <i-navigation></i-navigation>

            <div class="row animated fadeInUp">

            	<div class="col-lg-3 col-md-4">

            		<div class="profile__info">
            			<p class="profile__info-name">{{ user.name }}</p>
            			<p class="profile__info-num"><i class="icon-person"></i> {{ user.phone }}</p>
            		</div>	<!-- /.profile__info -->

            		<mb-tabs class="profile__nav">
				    	<mb-tabs-menu name="general" 
				    					linkClass="profile__nav-link" 
				    					class="profile__nav-item">
				    		<i class="icon-person"></i>
        					{{ trans('cabinet.profile.common_info') }}
				    	</mb-tabs-menu>
						<mb-tabs-menu name="direction" 
										linkClass="profile__nav-link" 
										class="is-active profile__nav-item">
            					<i class="icon-university"></i>
            					{{ trans('cabinet.profile.direction') }}
						</mb-tabs-menu>
						<mb-tabs-menu name="password" 
										linkClass="profile__nav-link" 
										class="profile__nav-item">
        					<i class="icon-lock"></i>
        					{{ trans('cabinet.profile.change_password') }}
						</mb-tabs-menu>
				    </mb-tabs>	<!-- /.profile__nav -->

            	</div>	<!-- /.col-md-3 -->

            	<div class="col-lg-9 col-md-8">
					<div class="profile__tabs-content">
					    <mb-tabs-content id="general">
		            		<div class="profile__card">
								<form @submit.prevent="submitGeneral">
									<md-field>
										<label>{{ trans('cabinet.profile.full_name') }}</label>
										<md-input v-model="user.name"></md-input>
									</md-field>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field>
											<label for="district_id">{{ trans('cabinet.profile.region') }}</label>
											<md-select v-model="user.district_id" @md-selected="updateCities()" name="district_id" md-dense>
												<md-option :value="region.id" v-for="(region, i) in regions.filter((el) => { return el.parent_id == 0})" :key="i">{{ region.name }}</md-option>
											</md-select>
										</md-field>
									</div>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field>
											<label for="city_id">{{ trans('cabinet.profile.city') }}</label>
											<md-select v-model="user.city_id" name="city_id" md-dense>
												<md-option :value="region.id" v-for="(region, i) in cities" :key="i">{{ region.name }}</md-option>
											</md-select>
										</md-field>
									</div>
									<md-field>
										<label>{{ trans('cabinet.profile.address') }}</label>
										<md-input v-model="user.address"></md-input>
									</md-field>
									<div class="text-right">
										<button type="submit" class="btn btn--brand">{{ trans('cabinet.btn.save') }}</button>
									</div>
								</form>
		            		</div>	<!-- /.profile__card -->
					    </mb-tabs-content>	<!-- /.tabs-content -->
						<mb-tabs-content id="direction" class="is-active">
							<div class="alert alert-danger p-lg mb-lg" v-if="user.subject_1_id == 0 || user.subject_2_id == 0">Перед прохождением теста выберите, пожалуйста, свое направление</div>
		            		<div class="profile__card">
								<form @submit.prevent="submitDirection">
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field>
											<label for="language">{{ trans('cabinet.profile.study_lang') }}*</label>
											<md-select v-model="user.lang" name="language" md-dense>
												<md-option value="uz">Узбекский</md-option>
												<md-option value="ru">Русский</md-option>
											</md-select>
										</md-field>
									</div>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field>
											<label for="university">{{ trans('cabinet.profile.uni') }}*</label>
											<md-select v-model="user.university_id" @md-selected="selectFaculties" name="university" md-dense>
												<md-option :value="id" v-for="(university, id) in universities" :key="id">{{ university }}</md-option>
											</md-select>
										</md-field>
									</div>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field>
											<label for="faculty_id">{{ trans('cabinet.profile.faculty') }}*</label>
											<md-select v-model="user.faculty_id" name="faculty_id" md-dense>
												<md-option :value="faculty.id" v-for="(faculty, i) in selectedFaculties" :key="i">{{ faculty.name }}</md-option>
											</md-select>
										</md-field>
									</div>

									<p class="profile__s-title">{{ trans('cabinet.profile.subjects') }}*</p>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field class="profile__s-wrap">
											<span>3.1</span>
											<md-select v-model="user.subject_1_id" name="subject_1_id" md-dense>
												<md-option :value="subject.id" v-for="(subject, index) in subjects" :key="index">{{ subject.name }}</md-option>
											</md-select>
										</md-field>
									</div>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field class="profile__s-wrap">
											<span>2.1</span>
											<md-select v-model="user.subject_2_id" name="subject_2_id" md-dense>
												<md-option :value="subject.id" v-for="(subject, index) in subjects" :key="index">{{ subject.name }}</md-option>
											</md-select>
										</md-field>
									</div>
									<div class="md-select-wrap" @click="selectClicked($event)">
										<md-field class="profile__s-wrap">
											<span>1.1</span>
											<md-select v-model="user.subject_3_id" name="subject_3_id" md-dense>
												<md-option :value="subject.id" v-for="(subject, index) in subjects" :key="index">{{ subject.name }}</md-option>
											</md-select>
										</md-field>
									</div>
									<div class="text-right">
										<button type="submit" class="btn btn--brand">{{ trans('cabinet.btn.save') }}</button>
									</div>
								</form>
		            		</div>	<!-- /.profile__card -->
						</mb-tabs-content>	<!-- /.tabs-content -->
						<mb-tabs-content id="password">
		            		<div class="profile__card">
								<form @submit.prevent="submitPassword">
									<md-field>
										<label>{{ trans('cabinet.profile.old_password') }}</label>
										<md-input v-model="password.old" type="password"></md-input>
									</md-field>
									<md-field>
										<label>{{ trans('cabinet.profile.new_password') }}</label>
										<md-input v-model="password.new" type="password"></md-input>
									</md-field>
									<md-field>
										<label>{{ trans('cabinet.profile.repeat_password') }}</label>
										<md-input v-model="password.new_confirmation" type="password"></md-input>
									</md-field>
									<div class="text-right">
										<button type="submit" class="btn btn--brand">{{ trans('cabinet.btn.save') }}</button>
									</div>
								</form>
		            		</div>	<!-- /.profile__card -->
						</mb-tabs-content>	<!-- /.tabs-content -->
					</div>	<!-- /.profile__tabs-content -->

            	</div>	<!-- /.col-md-7 -->

            </div>	<!-- /.row -->
        </div>	<!-- /.container -->

    </div>
</template>

<script>
    import { userInfo, profileData, changePassword, updateGeneral, updateDirection } from '@/api/user'
	import Tabs from '../components/tabs/tabs.vue'
	import TabsMenu from '../components/tabs/tabs-menu.vue'
    import TabsContent from '../components/tabs/tabs-content.vue'

    export default {
        data() {
            return {
				regions: [],
            	universities: [],
				faculties: [],
				selectedFaculties: [],
				cities: [],
            	subjects: [],
  				user: {
                    name: null,
                    address: null,
                    district_id: null,
                    city_id: null,

                    lang: null,
                    university_id: null,
                    faculty_id: null,
    
                    selectBox: null,
                    selectBoxPlace: null,
                    subject_1_id: 1,
                    subject_2_id: 1,
                    subject_3_id: 1
				},
				password: {
					old: null,
                    new: null,
                    new_confirmation: null,
				},
				tempDataKeeper: null
            }
		},
		computed: {
			loadedUser() {
				return this.$store.getters.user;
			},
			empty() {
				return "";
			}
		},
        created() {

			if (this.loadedUser) {
				this.user = this.loadedUser
			} else {
				userInfo().then(res => {
					this.user = res.data
				})
			}

			profileData().then(res => {
				const profileData = res.data;
				this.regions = profileData.regions
				this.universities = profileData.universities
				this.faculties = profileData.faculties
				this.subjects = profileData.subjects
				this.selectFaculties();
				this.updateCities();
			})

        },
        methods: {
        	updateCities() {
				this.cities = this.regions.filter((el) => {
					return el.parent_id == this.user.district_id
				})
				let elSel = this.cities[0];
				if (elSel &&
					this.cities.map((item) => { return item.id }).indexOf(this.user.city_id) == -1
				) {
					this.user.city_id = elSel.id
				}
        	},
        	pageScroll(e) {
        		let $docBody = document.body,
        			selectBox = this.selectBox,
        			boundAttribute = selectBox.getAttribute('x-out-of-boundaries')

    			selectBox.style.height = '0px'
        		if (!boundAttribute || boundAttribute == null) {
	        		setTimeout(()=> {
	        			selectBox.style.top = this.initialSelectBoxY + 'px'
		    			selectBox.style.height = 'auto'
	        		})
        		}

        		// remove scroll listener when select is removed
        		if ($docBody.getElementsByClassName('md-select-menu').length == 0) {
		        	window.removeEventListener('scroll', this.pageScroll)
        		}
        	},

        	selectClicked($event) {
        		let selectBox = this.selectBox
        		this.initialSelectBoxY = this.getCoords($event.target).top // get initial s-box Y pos-n

        		setTimeout(()=> {
	        		this.selectBox = document.body.getElementsByClassName('md-select-menu')[0]
	        		this.selectBox.style.top = this.initialSelectBoxY + 'px'
	    			this.selectBox.style.height = 'auto'
        		})

        		// add scroll listener when selectbox created
	        	window.addEventListener('scroll', this.pageScroll)
        	},

        	getCoords(elem) { // crossbrowser version
			    let box = elem.getBoundingClientRect();

			    let body = document.body;
			    let docEl = document.documentElement;

			    let scrollTop = window.pageYOffset || docEl.scrollTop || body.scrollTop;
			    let scrollLeft = window.pageXOffset || docEl.scrollLeft || body.scrollLeft;

			    let clientTop = docEl.clientTop || body.clientTop || 0;
			    let clientLeft = docEl.clientLeft || body.clientLeft || 0;

			    let top  = box.top +  scrollTop - clientTop;
			    let left = box.left + scrollLeft - clientLeft;

			    return { top: Math.round(top), left: Math.round(left) };
			},

			selectFaculties () {
				this.selectedFaculties = this.faculties[this.user.university_id] || []
				let elSel = this.selectedFaculties[0];
				if (
					elSel &&
					this.selectedFaculties.map((item) => { return item.id }).indexOf(this.user.faculty_id) == -1
				) {
					this.user.faculty_id = elSel.id
					this.user.subject_1_id = elSel.subject_1_id
					this.user.subject_2_id = elSel.subject_2_id
					this.user.subject_3_id = elSel.subject_3_id
				}
			},

			submitPassword () {
				changePassword(this.password).then(res => {
					if (res.data.success) {
						this.$notify({
							group: 'cabinet',
							text: res.data.message,
							type: 'alert-success',
							duration: 4 * 1000
						})
						this.password = {
							old: null,
							new: null,
							new_confirmation: null,
						}
					}
				})
			},

			submitGeneral () {
				updateGeneral({
					name: this.user.name,
                    address: this.user.address,
                    district_id: this.user.district_id,
                    city_id: this.user.city_id,
				}).then(res => {
					if (res.data.success) {
						this.$store.dispatch('setUser', res.data.user)
						this.$notify({
							group: 'cabinet',
							text: res.data.message,
							type: 'alert-success',
							duration: 4 * 1000
						})
					}
				})
			},

			submitDirection () {

				updateDirection({
					lang: this.user.lang,
                    university_id: this.user.university_id,
                    faculty_id: this.user.faculty_id,
                    subject_1_id: this.user.subject_1_id,
                    subject_2_id: this.user.subject_2_id,
                    subject_3_id: this.user.subject_3_id
				}).then(res => {
					if (res.data.success) {
						this.$store.dispatch('setUser', res.data.user)
						this.$notify({
							group: 'cabinet',
							text: res.data.message,
							type: 'alert-success',
							duration: 4 * 1000
						})
					}
				})
			}
        },
        components: {
        	'mb-tabs': Tabs,
			'mb-tabs-menu': TabsMenu,
			'mb-tabs-content': TabsContent
        }
    }
</script>