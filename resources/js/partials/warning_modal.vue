<div> 
	<div> 

		<div class="modal" tabindex="-1" role="dialog" id="warningModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					
					<div class="modal-header">
						<div 
						class="modal-title text-danger"> 
							<h5>
								<span class="icon circle"> 
									<i class="fas fa-exclamation-triangle" aria-hidden="true"></i>  
								</span>

								<span>Warning</span>

							</h5>
							
						</div>
						<button type="button" @click="close" class="close text-danger" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					
					<div class="modal-body">
						
						<slot>
							<p v-text="data.warning_text"></p>
						</slot>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal" @click="close">
							Close
						</button>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>

<script> 
	export default{
        name:'warningModal',
		props:['data'],
		methods:{
			close(){
				this.$emit('close');
			}
		}
	}
</script>

<style scoped>
.modal-content{
    border:1px solid #bf5252;
}

.card{
	position:absolute;
	top:0;
	left:0;
	width:100%;
	height:inherited;
}

</style>