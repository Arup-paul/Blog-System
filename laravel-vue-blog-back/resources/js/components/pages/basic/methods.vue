<template>
    <div>
        <h1>the number is : {{views}}</h1>
        <button @click="updateCounter(1)">Incress</button>
        <button @click="updateCounter(-1)">Decress</button>
        <br><br><br>

        <div v-for="(blog,i) in blogs" :key="i" v-if="blogs.length">
              <h1>{{blog.title}}</h1>
              <p>{{blog.post}}</p>
        </div>

        <br>
        <br>
        <br>

        <div>
            <h1 v-if="showItem">show the item is "showItem" is true</h1>
            <h1 v-else>show the item is "showItem" is false</h1>
        </div>

        <button @click="changeshowItem">Change showItem</button>


    </div>
</template>


<script>

export default{
    data(){
        return {
            views: 0,
            blogs : [],
            showItem:false
        }
    },
    methods:{
        updateCounter(number){
            this.views += number
        },
        changeshowItem(){
            this.showItem = !this.showItem
        }

    },
    created(){
        this.views = 100

        //get the blog post
        let posts =  [
                {title:'this is title 1', post: 'this is blog post 1', id:1},
                {title:'this is title 2', post: 'this is blog post 2', id:2},
                {title:'this is title 3', post: 'this is blog post 3', id:3},
                {title:'this is title 4', post: 'this is blog post 4', id:4},
            ]
            this.blogs = posts
    }
}
</script>
