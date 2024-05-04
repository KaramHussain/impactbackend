<div>
    <div>
        <h4>Coming soon...</h4>
        <p>Stay tuned!</p>
    </div>
</div>

<script>
export default {
    data(){
        return {
            search:''
        };
    },
    methods: {
        
        getAmount() {
                axios.post(`/getAmount`, {
                    
                })

                .then((res)=>{

                    if(res) {
                        // let cpt = res.data;
                        // this.$router.push({name:'cpt-layterms', params:{cpt:cpt}});
                    }

                })
                .catch((error) => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style>

</style>
