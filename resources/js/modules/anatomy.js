
import axios from 'axios';

const state = {
	symptoms:{},
	selected_symptoms:{},
	questions:{},
	selected_answers:[],
	patientInfo:{},
	ages:[],
	selected_questions:[],
	refined_parts:{}
};

const getters = {
	getSelectedSymptoms(state) {
		return state.selected_symptoms.length;	
	},
	sypmtomsLength(state) {
		return state.symptoms.length;
	},
	refinedParts(state) {
		return state.refined_parts;
	}
};

const mutations = {
	//after symptoms
	SYMPTOMS(state, payload) {
		state.symptoms = payload;
	},

	//before anatomy page loads
	FILL_SYMPTOMS(state, payload) {
		state.symptoms = payload;
	},

	FILL_QUESTIONS(state, payload) {
		state.questions = payload;
	},

	FILL_SELECTED_SYMPTOMS(state, payload) {
		state.selected_symptoms = payload;
	},

	addAnswers(state, answer) {
		
		if(answer.checked != false) { 
			state.selected_answers.push(answer);
		}
	
		state.selected_questions.filter((question) => {
			for(var q of question.answers) {
				if(answer.id == q.id) {
					if (answer.checked == true) {
						q.checked = true;
					}
					else if (answer.checked == false) {
						q.checked = false;
					}
				}
			}
		});
	
	},

	fillAges(state, data) {
		state.ages = data;
	},

	patientInfo(state, info) {
		state.patientInfo = info;
		localStorage.setItem('patientInfo', JSON.stringify(info));
	},

	fillParts(state, parts) {
		state.refined_parts = parts;
	},

	fillQuestions(state, questions) {
		state.selected_questions.push(questions);
	},

	removeQuestions(state, questions) {
		//selected questions will be the filtered questions, symptoms that are cancelled will be removed and rest of questions will be removed  
		state.selected_questions = questions;

		// $.each(questions, function(question, index) {
		// 	console.log(question);
		// });

	},

	filteredQuestions(state, symptom) {
		state.questions = {};
		let changed_questions = [];
		
		//if not empty selected questions    
		if(state.selected_questions.length != 0) {
			state.selected_questions.filter((question) => {
				if(symptom.id == question.symptom_id) {
					changed_questions.push(question);
				}
			});
		}

		state.questions = changed_questions;

	},

	removeAnswer(state, questions) {
		
		var answers_from_selected_questions = []; 
		var selected_answers = [];
		
		for(var question of questions) {
			for(var answer of question.answers) {
				//answers_from_selected_questions.push(answer);
				state.selected_answers.filter((ans) => {
					if(answer.id != ans.id) {
						selected_answers.push(ans);
					}
				});
			}
		}

		console.log(selected_answers);
		
		for(var i = 0; i < selected_answers.length; i++) {
			var j;
			for (j = i + 1; j < selected_answers.length; j++) {
				if(selected_answers[i] == selected_answers[j]) {
					// if prev element is equals next element then delete next
					selected_answers.splice(selected_answers[j], 1);
				}
			}
		}

		console.log(selected_answers);
	
	}

};

const actions = {

	removeAnswer(context, questions) {
		context.commit('removeAnswer', questions);
	},

	filteredQuestions(context, symptom) {
		context.commit('filteredQuestions', symptom);
	},

	getSymptomsFromSubParts({commit}, data) {
		
		let part = data.id;
		let endpoint = data.url;
		let view = data.view;
		let location = data.location;
		let gender = data.gender;
		let age = data.age;
		
		return new Promise((resolve, reject)=>{
			axios.post(`${endpoint}/anatomy/fetch-symptoms-from-subparts`, {
				id:part,
				view:view,
				age:age,
				location:location,
				gender:gender
			})
			.then((res) => {
				console.log(res);
				commit('FILL_SYMPTOMS', res.data);
				resolve();
			});
		});
	},
	
	getParts({commit}, data) {
		let endpoint = data.url;
		let part = data.part;
		axios.post(endpoint + '/anatomy/fetch-parts',  {
			part:part
		})
		.then((res) => {
			commit('fillParts', res.data);
		});


	},

	getAges({commit}, endpoint)
	{
		// axios.post(`${endpoint}/anatomy/ages`).then((data)=>{
		// 	commit('fillAges', data);
		// }); 
		let ages =  [
			'0-1',
			'1-5',
			'6-17',
			'18-24',
			'25-34',
			'35-44',
			'45-54',
			'55-64',
			'65-74',
			'75-84',
			'85+'
		];
		commit('fillAges', ages);
	},

	GET_LOCAL_STORAGE(context,	payload ) {
		return JSON.parse(localStorage.getItem(payload));  
	},

	SET_LOCAL_STORAGE(context, payload) {
		
		let key = payload[0];
		let data = payload[1];
		
	},

	CHECK_LOCAL_STORAGE({commit}, payload) {
		if (localStorage.getItem(key)) {
			return true;
		}	
		return false;
	},

	REMOVE_LOCAL_STORAGE({commit}, key) {
		if (localStorage.getItem(key)) {
			localStorage.removeItem(key);
		}
	},

	FETCH_SYMTOMPS({commit}){
		
		let symptoms = {};
		
		if (localStorage.getItem('symptoms')) {
        	symptoms = JSON.parse(localStorage.getItem('symptoms'));
        }

		commit('SYMPTOMS', symptoms);
	},

	fillAnswers({commit}, answer){
		commit('addAnswers', answer);
	},

	getSymptoms({commit}, data) {
		
		let part = data.part;
		let view = data.view;
		let endpoint = data.url;
		let age = data.age;
		let gender = data.gender;
		let location = data.location;

		//console.log(part, "and view is "+view);

		return new Promise((resolve, reject)=>{
			axios.post(`${endpoint}/fetch-symptoms`, {
				part:part,
				view:view,
				age:age,
				location:location,
				gender:gender
			})
			.then((res) => {
				commit('FILL_SYMPTOMS', res.data);
				resolve();
			});
		});
	
	},

	SELECT_QUESTIONS({commit}, payload){
		console.log(symptom.id);
		let endpoint = payload.url;
		this.$http.get(`${endpoint}/fetch-questions`, {
    		params:{id:symptom.id}
    	})
    	.then(({data}) => {
    		//console.log(data);
    		//fill questions
    		commit('FILL_QUESTIONS', data);
    		//fill selected sypmtoms
    		commit('FILL_SELECTED_SYMPTOMS', payload);

			//console.log(data);
    	
    	}, errors => {
    		
    		console.log(errors);
    	
    	});

	},

	FILL_SYMPTOMS_ACTION(context, payload) {
		//console.log(payload);
		context.commit('FILL_SYMPTOMS', payload);
		localStorage.setItem('symptoms', JSON.stringify(payload));
	},

	fillPatientInfo({commit}, info){
		commit('patientInfo', info);
	},

	fillQuestions(context, questions) {
		context.commit('fillQuestions', questions);
	},

	removeQuestions(context, questions) {
		context.commit('removeQuestions', questions);
	}

};

export default {
	namespaced:true,
	state,
	getters,
	mutations,
	actions
}


