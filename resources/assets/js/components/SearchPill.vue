<template>
    <div class="search_pill">
        <a href="#" @click.prevent="$router.go(-1)" title="Back"> &larr;</a>
        <div class="search_form">
            <form class="form-horizontal" onsubmit="event.preventDefault()">
                <div class="form-group">
                    <div class="input-group" v-if="!searching">
                        <input type="text" class="form-control" v-model="query.product" @keyup.enter="search" placeholder="What are you looking for?">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button" @click.prevent="search"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                    <div v-if="searching" class="searching">
                        <p>Searching...</p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return{
                query:{
                    product: '',
                    
                },
                searching: false,
            }
        },
        methods: {
            search(){
                if(this.query.product != ''){
                    this.searching =  true;

        			axios.post('/product_search', {
        				prod: this.query.product
        			}).then((res) => {
                        let vm = this
                        vm.searching = false
                        vm.$router.push({name: 'searchresult', query:{prod: vm.query.product, loc:vm.query.location}, params: {result: res.data}})
                    })
                }
            }
        },
    }
</script>


<style scoped>
    .search_pill{
        background: #fff;
        padding: 15px 30px;
        height: 50px;
        margin-top: -22px;
        box-shadow: 0 0 20px rgba(224, 221, 221, 0.8);

        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
    }
    .search_pill a{
        flex: 0 1 4%;
        font-size: 38px;
        font-weight: 900;
        padding-left: 25px;
        
        color: #b92db9;
        transition: transform .6s;        
    }
    .search_pill a:hover{
        text-decoration: none;
        color: #fa04fa;
        transform: translateX(-8px) scale(1.2);
    }
    .search_pill .search_form{
        flex: 0 1 40%;
    }
    .search_pill form{
        width: 80%;
        align-self: center; 
        margin: 14px auto;
    }
    .searching{
        font-size: 18px;
        font-weight: 500;
        color: #b92db9;
        margin-top: 10px;
    }

</style>
