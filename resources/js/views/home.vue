<template>
    <div class="main" @click="hideSuggestions($event)">
        <h4 class="my-3">Find all medical care services & get instant quote</h4>

        <section class="search-box my-5">

            <div class="row p-0 m-0">

                <div class="search-field">
                    <div class="form-group" id="bloodhound">
                        <!-- <input autocomplete = "off" type="search" class="form-control typeahead" id="search-text" placeholder="Search Disease, Treatment, Doctors" v-model="search.search_text" @keydown="hideSuggestions($event)"> -->

                        <input autocomplete="off" type="search" class="form-control typeahead" id="search-text" placeholder="Search..." v-model="search.search_text" @keydown="hideSuggestions($event)">

                        <div v-show="search.results.length" class="search_suggestions hidden">
                            <ul class="list-group">

                                <li class="list-group-item" v-for="(search, index) in search.results" :key ="index" @click = "selectSearch(search)">

                                    <!-- <router-link :to="{path:`/cpt_layterms/${search.cpt_code}`}"> -->
                                        <div>

                                            <template>
                                                {{search.parent_term}}
                                            </template>
                                            <template v-if="search.term!=null">
                                                -> {{search.term}}
                                            </template>

                                        </div>

                                        <div class="text-muted">
                                            <small>
                                                {{search.code}}
                                            </small>
                                            <small>
                                                <!-- Location: {{search.body_part}} -->
                                            </small>
                                            <!-- <strong>

                                            </strong>
                                            -  -->
                                            <!-- {{search.description}} -->
                                        </div>
                                        <div class="text-muted">
                                            <small>

                                                <template>
                                                    {{formattedDesc(search.cpt_code_full_description)}}
                                                </template>

                                                <!--
                                                <template v-if="search.icd10cm_description">
                                                    {{formattedDesc(search.icd10cm_description)}}
                                                </template> -->
                                                <!-- Age: {{search.age}}
                                                &nbsp;&nbsp;
                                                Gender: {{formattedGender(search.gender)}}
                                                &nbsp;&nbsp; -->
                                            </small>
                                        </div>
                                    <!--</router-link> -->

                                </li>

                            </ul>
                        </div>
                    </div>

                </div>

                <div class="search-field">
                     <div class="form-group">
                        <input type="text" id="location" class="form-control" placeholder="Zip code" v-model="search.search_zipCode">
                    </div>
                </div>

                <div class="search-field">
                    <div class="form-group">
                        <!-- <input type="text" class="form-control" placeholder="Age" v-model="search.search_age"> -->
                        <select class="form-control" v-model="search.search_age">
                            <option v-for="(age, index) in ages" :key="index">
                                {{age}}
                            </option>
                        </select>
                    </div>
                </div>

                <div class="search-field">
                    <div class="form-group">
                        <select class="form-control" id="" v-model="search.search_gender">
                            <option value="1">Male</option>
                            <option value="2">Female</option>
                        </select>
                    </div>
                </div>

                <div class="search-btn">
                    <div class="form-group">
                        <button :disabled ="false" type="button" class="btn btn-success" @click="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

            </div>

        </section>
    </div>
</template>

<script>
import {mapGetters, mapState, mapActions} from 'vuex';

export default {
    data() {
        return {

            search: {
                search_text:'',
                search_gender:1,
                search_zipCode:'',
                search_age:'0-1',
                results:{}
            }

        }
    },

    computed:{
        search_query() {
            return this.search.search_text;
        },

        ages() {

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

            return ages;

        }
    },

    methods: {

        formattedTerm(term) {
            return term;
            //return term.length > 35 ? term.substring(0, 35) + '...' : term;
        },

        formattedDesc(desc) {
            return desc.length > 80 ? desc.substring(0, 80) + '...' : desc;
        },

        location(id) {
            switch (id) {
                case 653:
                    return 'Pelvis';
                    break;
                case 662:
                    return 'Stomach';
                    break;
                case 659:
                    return 'Naval (Belly button)';
                    break;
                case 661:
                    return 'Groin';
                    break;
                default:
                    break;
            }
        },

        // formattedTerm(term) {
        //     return term.charAt(0).toUpperCase() + term.slice(1);
        // },

        formattedGender(gender) {
            if(gender == 1) {
                return 'Male';
            }
            else if(gender==2) {
                return 'Female';
            }
            else {
                return 'Both';
            }
        },

        submit() {

            let query = this.search.search_text;
            let age = this.search.search_age;
            let gender = this.search.search_gender;
            let location = this.search.search_zipCode;

           axios.post(`/searchSubmit`, {
                q:query,
                age:age,
                gender:gender,
                location:location
            })

            .then((res)=>{

                if(res) {
                    let cpt = res.data;
                    this.$router.push({name:'cpt-layterms', params:{cpt:cpt}});
                }

            })
            .catch((error) => {
                console.log(error);
            });
        },

        searched(e) {
            console.log(e);
        },

        hideSuggestions(e) {
           let key = e.which;
           if(key == '27') {
               this.search.results = {};
           }
        },

        selectSearch(term) {
            //let formatted_term = this.formattedTerm(term);
            // this.search.search_text = formatted_term;
            if(term.term != null && term.parent_term != null) {
                this.search.search_text = term.parent_term + "->" + term.term;
            }
            else {
                this.search.search_text = term.parent_term;
            }
            this.search.results = {};
            $(".typeahead").blur();
        },

        validated() {
            if(this.search.search_text == '') {
                return false;
            }
            return true;
        },

        useTypeahead(data) {
            // constructs the suggestion engine
            var results = new Bloodhound({
                datumTokenizer: Bloodhound.tokenizers.whitespace,
                queryTokenizer: Bloodhound.tokenizers.whitespace,
                // `results` is an array of state names defined in "The Basics"
                local: data
            });

            $('#bloodhound .typeahead').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
            },
            {
                name: 'results',
                source: results
            });
        },

        highlight(data) {
            return data.replace(new RegExp(this.search.search_text, "gi"), match => {
                return '<span class="highlightText">' + match + '</span>';
            });
        }

    },

    watch: {

        search_query:function(query) {

            var elem = document.getElementById('search-text');

            if(query == '') {
                this.search.results = '';
                elem.classList.add('hidden');
                return;
            }

            elem.classList.remove('hidden');

            axios.get(`/search/${query}`)
            .then((res)  => {
                console.log(res);
            });

            // axios.get(`/search?q=${query}`)
            // .then((res) => {
            //     this.search.results = res.data;
            //     //this.highlight(res.data);
            //     //this.useTypeahead(res.data);
            // })
            // .catch((error) => {
            //     console.log(error);
            // });
        }
    }

}
</script>

<style>

    .highlightText {
        color:#000;
        font-weight:bold;
    }

    section.search-box {
        display: flex;
        flex-wrap: nowrap;
        width:100%;
    }

    .search-field {
        width:200px;
    }

    .search-field li.list-group-item a {
        color:#222;
        text-decoration: none;
        display:block;
    }

    .search-field li.list-group-item a:hover {
        color:#000;
    }

    .search-field li.list-group-item:hover {
        background:#F0F0F0;
    }

    .search-field:first-child {
        width:350px;
        position:relative;
        margin-bottom:0;
    }

    .search_suggestions {
        position: absolute;
        background:#fff;
        box-shadow: 0 8px 12px rgba(0,0,0,0.4);
        top:100%;
        left:0;
        width:100%;
        max-height:350px;
        overflow:auto;
        transform:translateY(-10px);
    }
</style>
