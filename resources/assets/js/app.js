
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import VeeValidate from 'vee-validate';
import Toasted from 'vue-toasted';
import VueChatScroll from 'vue-chat-scroll';
import VueModal from 'vue-js-modal'

import Moment from 'vue-moment';

//Vue.use(Moment)
Vue.use(require('vue-moment'));
// Vue.use(require('moment-timezone'));

import NewAd from './components/NewAd.vue';
import NewServiceAd from './components/NewServiceAd.vue';
import ChooseAdType from './components/ChooseAdType.vue';
import SingleAd from './components/SingleAd.vue';
import MyAds from './components/MyAds.vue';
import Welc from './components/Welcome.vue';
import SellerProfile from './components/SellerProfile.vue';
import SellerAds from './components/SellerAds.vue';
import Chat from './components/Chat.vue';
import Services from './components/Services.vue';
import Service from './components/SingleService.vue';
import Profile from './components/Profile.vue';
import MyOwnAds from './components/MyOwnAds.vue';
import MyFlags from './components/MyFlags.vue';
import SearchResult from './components/SearchResult.vue';
import ServiceSearchResult from './components/SearchServiceResult.vue';
import Category from './components/Category.vue';
import Testing from './components/Testing.vue';

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(VueRouter);
Vue.use(VeeValidate);
Vue.use(Toasted, {
	duration: 6000
});
Vue.use(VueModal, {dialog: true});
Vue.use(VueChatScroll);

 const router = new VueRouter({
	routes : [
		{path: '/', component: Welc},
		{path: '/create_ad', component:NewAd, meta:{requiresAuth: true}},
		{path: '/create_service_ad', component:NewServiceAd, meta:{requiresAuth: true}},
		{path: '/choose_ad_type', component:ChooseAdType, meta:{requiresAuth: true}},
		{path: '/ad/:id/:slug', component:SingleAd},
		{path: "/seller/:id/:slug" , name:"sellerProfile", component: SellerProfile, props: true},
		{path: "/seller/:id/:slug/all_ads" , name:"sellerAllAds", component: SellerAds, props: true},
		{path: "/chat/:id" , name:"chat", component: Chat, props: true, meta:{requiresAuth: true}},
		{path: "/services" , name:"services", component: Services},
		{path: "/service_ad/:id/:slug" , name:"service", component: Service},
		{path: "/profile" , name:"profile", component: Profile, meta:{requiresAuth: true}},
		{path: "/my_ads" , name:"myOwnAds", component: MyOwnAds, meta:{requiresAuth: true}},
		{path: "/my_flags" , name:"myFlags", component: MyFlags, meta:{requiresAuth: true}},
		{path: "/search_result" , name:"searchresult", component: SearchResult},
		{path: "/category/:id/:slug" , name:"category", component: Category, props: true},
		{path: "/service_search_result" , name:"serviceSearchResult", component: ServiceSearchResult, props: true},
		{path: "/testing" , name:"Testing", component: Testing, props: true},
	],
	mode: 'history'
})

 router.beforeEach((to, from, next)=>{
 	if(to.meta.requiresAuth){
 		const authUser = window.Laravel.auth
 		if(authUser){
 			next()
 		}else{
			//  next('/login')
 			window.location.href="/login"
 			// router.push({path: '/login'})
 		}
 	}
 	next()
 })

Vue.component('example', require('./components/Example.vue'));
Vue.component('categories', require('./components/Categories.vue'));
Vue.component('ads', require('./components/Ads.vue'));
Vue.component('welcome', require('./components/Welcome.vue'));
Vue.component('test', require('./components/Test.vue'));
Vue.component('my-ads', require('./components/MyAds.vue'));
Vue.component('my-ad', require('./components/MyAd.vue'));
Vue.component('welcome-banner', require('./components/WelcomeBanner'));
Vue.component('ad-lists', require('./components/MyAds.vue'));
Vue.component('search-bar', require('./components/SearchBar.vue'));
Vue.component('product-sidebar', require('./components/ProdSideBar.vue'));
Vue.component('user-ad', require('./components/UserAd.vue'));
Vue.component('chat-log', require('./components/ChatLog.vue'));
Vue.component('service-ad', require('./components/ServiceAd.vue'));
Vue.component('seller-serv', require('./components/SellerService.vue'));
Vue.component('prof-pic', require('./components/UpdateProfPic.vue'));
Vue.component('report-modal', require('./components/ReportModal.vue'));
Vue.component('reports', require('./components/SellerReports.vue'));
Vue.component('report', require('./components/SellerReport.vue'));
Vue.component('edit-report', require('./components/EditReport.vue'));
Vue.component('upper-bar', require('./components/UpperBar.vue'));
Vue.component('search-pill', require('./components/SearchPill.vue'));
Vue.component('serv-search-pill', require('./components/ServiceSearchPill.vue'));
// Vue.component('my-service', require('./components/MyService.vue'));
// Vue.component('profile-link', require('./components/profileLink.vue'));

const app = new Vue({
    el: '#app',
    router
});
