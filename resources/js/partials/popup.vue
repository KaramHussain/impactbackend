<template>
	<div>

		<div class="card">

			<div class="card-header">

				<div class="card-title text-success">
					<h5>
						<span class="icon circle">
							<i class="fas fa-pencil-alt"></i>
						</span>

						<span>Tell us more about your symptom</span>

					</h5>

					<span class="close pointer" @click="close">
						<i class="fa fa-times-circle text-danger"></i>
						&times;
					</span>

				</div>

			</div>

			<div class="card-body">
				<slot v-if="!loading">

					<div :key="question.id" v-for="question in questions">

						<p> <strong>{{question.question}}</strong> </p>

						<div v-if="question.answers.length != 0">
							<div :key="answer.id"
							v-for="answer in question.answers">

								<div v-if="question.type == 'checkbox'">
									<label class="checkbox__container checkbox__container--block" :for="answer.id">

										{{answer.answer}}

										<div v-if="checkAnswer(answer) == true">
											true
											<input checked :id="answer.id" type="checkbox" :value="answer.id" @change="selectAnswers($event, answer)">
											<span class="checkmark"></span>
										</div>

										<div v-else>
											false
											<input :checked="false" :id="answer.id" type="checkbox" :value="answer.id" @change="selectAnswers($event, answer)">
											<span class="checkmark"></span>
										</div>

									</label>
								</div>

								<div v-if="question.type == 'radio'">
									<input :id="answer.id" :checked="checkAnswer(answer)" type="radio" :name="answer.question_id" :value="answer.id" @change="selectAnswers($event, answer)">
									<label :for="answer.id">
										{{answer.answer}}
										<span class="radio-button"></span>
									</label>
								</div>

							</div>
						</div>

					</div>

				</slot>

				<slot v-else>
					<i class="fa fa-spinner fa-spin"></i>
				</slot>
			</div><!--card-body-->

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary btn-sm" @click="close">
					Finish
				</button>
			</div>

		</div>

	</div>
</template>

<script>
	export default{
		props:['loading', 'questions'],
		data(){
			return {

			};
		},
		computed: {
			symptom_questions() {
				return this.questions;
			}
		},
		methods:{

			checkAnswer(answer) {
				if(answer.hasOwnProperty('checked')) {
					if(answer.checked == true) {
						return true;
					}
					return false;
				}
				return false;
			},

			close() {
				this.$emit('close', this.questions);
			},

			selectAnswers(event, answer) {

				let checked = event.target.checked;

				this.applyEffectsOnAnswers(answer, checked);

				if(checked) {
					answer = Object.assign({}, answer, {checked:true});
					this.$store.dispatch('anatomy/fillAnswers', answer);
				}
				else {
					answer = Object.assign({}, answer, {checked:false});
					this.$store.dispatch('anatomy/fillAnswers', answer);
				}
				//if answer has warning show it by emitting custom event showAnswerWarning
				if(answer.warning_text) {
					this.$emit('showAnswerWarning', answer);
				}

			},

			applyEffectsOnAnswers(answer, checked) {

				if(checked) {

					if(answer.type == 'unCheckAll') {
						//loop through questions
						this.apply('unCheckAll', answer);
					}

					else if (answer.type == 'checkAll') {
						this.apply('checkAll', answer);
					}

				}
			},

			apply(type, answer) {
				var updated_questions = [];
				//loop through questions
				for(var question of this.questions) {

					for (let ans of question.answers) {
						//if selected answer has same question id with other answers then uncheck it

						if (ans.question_id == answer.question_id) {
							if(type == 'unCheckAll') {
								ans.checked = false;
								//Object.assign({}, ans, {checked:false});
							}
							else if(type == 'checkAll') {
								ans.checked = true;
								//Object.assign({}, ans, {checked:false});
							}
						}

					}
					updated_questions.push(question);
					this.questions = updated_questions;
				}

			}

		}
	}
</script>

<style scoped>

.card {
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:500px;
	overflow:auto;
}
.card-body {
	position:relative;
}
.close {
	position:absolute;
	right:10px;
	top:15px;
}

</style>
