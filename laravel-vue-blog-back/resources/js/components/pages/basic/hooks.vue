<template>
    <div>
        <h1 ref="myref">Hooks</h1>
        <p>My Name is {{name}}</p>
    </div>
</template>


<script>
  export default{
      data(){
          return{
             name: 'Arup'
          }
      },
      beforeCreate(){
          console.log(this.name)
      },
      created(){
          //call mostly initial data from it
          console.log("data and other function is available but not html", this.name)
      },
      mounted(){
          console.log(this.$refs.myref);
      }
  }
</script>
