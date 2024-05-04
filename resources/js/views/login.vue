<template>
    <div>
        <form action="" @submit.prevent="submit">
            <input type="text" class="form-control" v-model="form.email">
            <input type="text" class="form-control" v-model="form.password">
            <input type="submit" class="btn btn-success">
        </form>
    </div>
</template>

<script>
    import axios from 'axios';
    export default {
        methods:{
            data() {
                return {
                    form: {
                        email:'',
                        password:''
                    }
                };
            },

            submit() {

                axios.post('login', {
                    email:this.from.email,
                    password:this.form.password
                })
                .then(({data}) => {
                    console.log(data);
                })
                .catch(() => {

                });

            }

        }
    }
</script>
