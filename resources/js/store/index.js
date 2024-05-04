import Vue from 'vue';
import Vuex from 'vuex';
import anatomy from '../modules/anatomy.js';

Vue.use(Vuex);

export default new Vuex.Store({
	modules:{
		anatomy
	}
});