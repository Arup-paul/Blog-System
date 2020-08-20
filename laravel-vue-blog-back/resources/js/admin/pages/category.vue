<template>
    <div>
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category <Button @click="addModal=true"><Icon type="md-add"/>Add Category</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
                                <th>Icon Image</th>
								<th>Category Name</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categoryList" :key="i" :v-if="categoryList.length">
								<td>{{i+1}}</td>
                                <td class="table_image">
                                    <img :src="category.IconImage"/>
                                </td>
								<td class="_table_name">{{category.categoryName}}</td>

								<td>{{category.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(category,i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(category,i)" :loading="category.isDeleteing">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->




						</table>
					</div>
				</div>

                 <!--tag adding modal -->
                 <Modal
                 v-model="addModal"
                 title="Add Category"
                 :mask-closable="false"
                 :closable="false"
                 >
                     <Input v-model="data.categoryName" placeholder="Enter Category name.."  />
                     <div class="space"></div>
                     <Upload
                     ref="uploads"
                     type="drag"
                     :headers="{'x-csrf-token':token,'X-Requested-With': 'XMLHttpRequest'}"
                     :on-success="handleSuccess"
                     :on-error="handleError"
                     :format="['jpg','jpeg','png']"
                     :max-size="2048"
                     :on-format-error="handleFormatError"
                     :on-exceeded-size="handleMaxSize"
                     action="/app/upload">
                         <div style="padding:20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color:#3399ff"></Icon>
                            <p>Click or Drag files here to upload</p>
                         </div>
                     </Upload>
                     <div class="demo-upload-list" v-if="data.IconImage">
                         <img :src = "`${data.IconImage}`"/>
                         <div class="demo-upload-list-cover">
                              <Icon type="ios-trash-outline" @click="deleteImage" ></Icon>
                         </div>
                     </div>




                     <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="addCategory" :disable="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Category'}}</Button>
                     </div>
                 </Modal>

                   <!--tag  edit modal -->
                 <Modal
                 v-model="editModal"
                 title="Edit Category"
                 :mask-closable="false"
                 :closable="false"
                 >
                       <Input v-model="editData.categoryName" placeholder="Enter Category name.."  />
                     <div class="space"></div>
                     <Upload v-show="isIconImageNew"
                     ref="editDataUploads"
                     type="drag"
                     :headers="{'x-csrf-token':token,'X-Requested-With': 'XMLHttpRequest'}"
                     :on-success="handleSuccess"
                     :on-error="handleError"
                     :format="['jpg','jpeg','png']"
                     :max-size="2048"
                     :on-format-error="handleFormatError"
                     :on-exceeded-size="handleMaxSize"
                     action="/app/upload">
                         <div style="padding:20px 0">
                            <Icon type="ios-cloud-upload" size="52" style="color:#3399ff"></Icon>
                            <p>Click or Drag files here to upload</p>
                         </div>
                     </Upload>
                     <div class="demo-upload-list" v-if="editData.IconImage">
                         <img :src = "`${editData.IconImage}`"/>
                         <div class="demo-upload-list-cover">
                              <Icon type="ios-trash-outline" @click="deleteImage(false)" ></Icon>
                         </div>
                     </div>

                     <div slot="footer">
                        <Button type="default" @click="closeEditModal">Close</Button>
                        <Button type="primary" @click="editCategory" :disable="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Update Category'}}</Button>
                     </div>
                 </Modal>

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
              data : {
                 categoryName: '',
                 IconImage: ''
              },
              addModal : false,
              editModal : false,
              isAdding:false,
              categoryList : [],

              editData: {
                  categoryName: '',
                  IconImage: ''
              },
             index : -1 ,
             showDeleteModal: false,
             isDeleting:false,
             deleteItem:{},
             deletingIndex:-1,
             token: '',
             isIconImageNew: false,
             isEditingItem:false,


          }
    },

    methods:{
        async addCategory(){
            if(this.data.categoryName.trim() == '' ) return this.e('Category name is required')
            if(this.data.IconImage.trim() == '' ) return this.e('Icon Image is required')
            this.data.IconImage = `${this.data.IconImage}`
            const res = await this.callApi('post','app/create_category',this.data)
            if(res.status === 201){
                this.categoryList.unshift(res.data);
                this.s('Category has been added succefully')
                this.addModal = false
                this.data.categoryName =''
                this.data.IconImage =''
            }else{
                if(res.status ==422){
                    if(res.data.errors.categoryName){
                        this.e(res.data.errors.categoryName[0])
                    }
                    if(res.data.errors.IconImage){
                        this.e(res.data.errors.IconImage[0])
                    }
                }else{
                   this.swr()
                }

            }
        },

         async editCategory(){
            if(this.editData.categoryName.trim() == '' ) return this.e('Category name is required')
            if(this.editData.IconImage.trim() == '' ) return this.e('Icon Image is required')
            const res = await this.callApi('post','app/edit_category',this.editData )
            if(res.status === 200){
                this.categoryList[this.index].categoryName = this.editData.categoryName
                this.s('Category has been Updated succefully')
                this.editModal = false
            }else{
                if(res.status ==422){
                    if(res.data.errors.categoryName){
                        this.e(res.data.errors.categoryName[0])
                    }
                    if(res.data.errors.IconImage){
                        this.e(res.data.errors.IconImage[0])
                    }
                }else{
                   this.swr()
                }

            }
        },
        showEditModal(category,index){
            // let obj = {
            //     id: tag.id,
            //     tagName: tag.tagName
            // }
            console.log(category)
            this.editData = category
            this.editModal = true
            this.index = index
            this.isEditingItem = true
        },
      
        showDeletingModal(category,i){
            const  deleteModalObject =  {
            showDeleteModal: true,
            deleteUrl: "app/delete_category",
            data: category,
            deletingIndex: i,
            isDeleted: false
        }
          this.$store.commit('setDeletingModalobj',deleteModalObject)
        //   this.deleteItem = tag
        //   this.deletingIndex = i
        //   this.showDeleteModal = true
        },

        handleSuccess(res,file){
            res = `/uploads/${res}`
            if(this.isEditingItem){
                return this.editData.IconImage = res
            }
               this.data.IconImage = res
        },
        handleError(res,file){
            this.$Notice.warning({
                title: 'The file format is Incorrect ',
                desc:`${file.errors.file.lenght ?file.errors.file[0] : 'Something went wrong'  }`
            });
        },

        handleFormatError(file){
            this.$Notice.warning({
                title: 'The file format is Incorrect ',
                desc:'File format of ' + file.name + ' is incorrect, please select jpg ,jpeg or png.'
            });
        },

           handleMaxSize(file){
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc:'File ' + file.name + ' is to large, to more than 2MB'
            });
        },

        closeEditModal(){
           this.isEditingItem = false
           this.editModal = false
        },

        async deleteImage(isAdd = true){
            let image
            if(!isAdd){//for editing
                this.isIconImageNew = true
                image = this.editData.IconImage
                this.editData.IconImage = ''
                this.$refs.editDataUploads.clearFiles();
            }else{
                image = this.data.IconImage
                this.data.IconImage = ''
                this.$refs.uploads.clearFiles();

            }
            const res = await this.callApi('post','app/delete_image',{imageName:image})
            if(res.status !=200){
                this.data.IconImage = image
                this.swr()
            }
        }

    },


        async created(){
            this.token = window.Laravel.csrfToken
            const res = await this.callApi('get','app/get_categories')
            if(res.status = 200){
                this.categoryList = res.data
            }else{
                this.swr()
            }
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
                    this.categoryList.splice(this.deletingIndex,1)
               }
           }
       }




    }

</script>

<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
    .table_image img{
        width:40px;
    }
</style>
