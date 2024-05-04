import Vue from 'vue';
import Router from 'vue-router';

Vue.use(Router);

import step1 from './views/anatomy-step1.vue';
import anatomy_symptoms from './views/anatomy_symptoms.vue';
import cpt_layterms from './views/cpt_layterms.vue';
import home from './views/home.vue';
import offer from './views/offer.vue';
import shop from './views/shop.vue';
import login from './views/login.vue';
import shouldice_questionaire from './views/shouldice_questionaire.vue';
import shouldice_questionaire_old from './views/shouldice_questionaire_old.vue';

let routes = [
	{
		name:'home',
		path:'/',
		component:home,
		props:{origin:window.location.origin}
	},
	{
		name:'anatomy',
		path:'/anatomy',
		component:step1,
		props:{origin:window.location.origin}
	},
	{
		name:'anatomy-sypmtoms',
		path:'/anatomy/symptoms',
		component:anatomy_symptoms,
		props:{origin:window.location.origin}
	},
	{
		name:'cpt-layterms',
		path:'/cpt_layterms/:cpt',
		component:cpt_layterms,
		props:{origin:window.location.origin}
	},
	{
		name:'offer',
		path:'/offer/:cpt',
		component:offer,
		props:{origin:window.location.origin}
	},
	{
		name:'shop',
		path:'/shop/:cpt',
		component:shop,
		props:{origin:window.location.origin}
	},
	{
		name:'shouldice-questions',
		path:'/shouldice/questions',
		component:shouldice_questionaire,
		props:{origin:window.location.origin},
	},
	{
		name:'shouldice-questions-old',
		path:'/shouldice/questions/old',
		component:shouldice_questionaire_old,
		props:{origin:window.location.origin}
    },
    {
		name:'login',
		path:'/logins',
        component:login,
        props:{origin:window.location.origin}
	}
];

export default new Router({
	base:'/',
	mode:'history',
	routes
});
