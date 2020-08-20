<template>
    <div>
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blogs <Button @click="$router.push('/createBlog')" ><Icon type="md-add"/>Create Blogs</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Title</th>
								<th>Categories</th>
								<th>tags</th>
								<th>views</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(blog, i) in blogs" :key="i" :v-if="blogs.length">
								<td>{{i+1}}</td>
								<td class="_table_name">{{blog.title}}</td>
                                <td>
                                <span v-for="(c,i) in blog.cat" v-if="blog.cat.length"><Tag type="border">{{c.categoryName}}</Tag></span>
                                </td>
                                <td ><span v-for="(t,i) in blog.tag" v-if="blog.tag.length"><Tag type="border">{{t.tagName}}</Tag></span></td>
                                <td>{{blog.views}}</td>
								<td>
									<Button type="info" size="small" >Visit Blog</Button>
								    <Button type="info" size="small" @click="$router.push(`/editblog/${blog.id}`)" v-if="isUpdatePermitted">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(blog,i)" :loading="blog.isDeleteing" v-if="isDeletePermitted">Delete</Button>
								</td>
							</tr>
                            <Page :total="pageInfo.total" :current="pageInfo.current_page" :page-size="parseInt(pageInfo.per_page)" @on-change="getBlogData" v-if="pageInfo"/>
								<!-- ITEMS -->




						</table>
					</div>
				</div>


                 <deleteModal></deleteModal>

			</div>
		</div>
</template>

<script>
import deleteModal from './../components/deleteModal.vue'
import {mapGetters} from 'vuex'
export default{

    data(){
          return{ 
              isAdding:false,
              blogs : [],
              index : -1 ,
              showDeleteModal: false,
              isDeleting:false,
              deleteItem:{},
              deletingIndex:-1,
              total: 10,
              pageInfo:null,


          }
    },


    methods:{
    
        showDeletingModal(blog,i){
         const  deleteModalObject =  {
            showDeleteModal: true,
            deleteUrl: "app/delete_blog",
            data: blog,
            deletingIndex: i,
            isDeleted: false,
            msg: 'Are your sure want to delete this blog?',
            successMsg:'Blog has been succefully Deleted!'
        }
        this.$store.commit('setDeletingModalobj',deleteModalObject)
        console.log('delete methode called');
        },
        async getBlogData(page = 1){
            const res = await this.callApi('get',`app/blogs_data?page=${page}&total=${this.total}`)
            if(res.status = 200){
                this.blogs = res.data.data
                this.pageInfo = res.data
            }else{
                this.swr()
            }
        }
    },


        async created(){
            this.getBlogData()
        },
         components:{
           deleteModal
       },
       computed:{
          ...mapGetters(['getDeleteModalObj'])
       },
       watch:{
           getDeleteModalObj(obj){
               if(obj.isDeleted){
                    this.blogs.splice(this.deletingIndex,1)
               }
           }
       }




    }

</script>
