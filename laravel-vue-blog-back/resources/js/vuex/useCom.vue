<template>
        <div>
            <div class="container-fluid">
                <h1>I will show how all other components react to changes</h1>
               <h2> The master components : {{counter}}</h2>
                  <div>
                       <comA></comA>
                  </div>

                    <div>
                       <comB></comB>
                  </div>

                    <div>
                       <comC></comC>
                  </div>
                  <Button type="info" @click="changeCounter">Change the state of counter</Button>


            </div>

        </div>

</template>

<script>
import  comA from './comA.vue';
import  comB from './comB.vue';
import  comC from './comC.vue';
import {mapGetters,mapActions} from 'vuex';
export default{
    data(){
      return{
          localVar :'some value'
       }
    },
    computed:{
       ...mapGetters({
          'counter': 'getCounter'
       })
    },
    methods:{

        ...mapActions([
           'changeCounterAction'
        ]),

        runsomethingcounterchange(){
           console.log('I am running changing')
        },

       changeCounter(){
           this.$store.dispatch('changeCounterAction',1)
        // this.$store.commit('changeTheCounter',1)
       }
    },

   created(){
       console.log(this.$store.state.counter)
   },
   components:{
       comA,
       comB,
       comC,

   },
   watch:{
       counter(value){
           console.log('counter is changing',value)
           this.runsomethingcounterchange()
           console.log('local var',this.localVar)
       }
   }
}
</script>
