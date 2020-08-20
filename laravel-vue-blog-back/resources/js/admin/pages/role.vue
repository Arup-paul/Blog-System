<template>
    <div>
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Management <Button @click="addModal=true"><Icon type="md-add"/>Add a New Role</Button></p>

					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>ID</th>
								<th>Role Type</th>
								<th>Created At</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(role, i) in roles" :key="i" :v-if="roles.length">
								<td>{{i+1}}</td>
								<td class="_table_name">{{role.roleName}}</td>
								<td>{{role.created_at}}</td>
								<td>
									<Button type="info" size="small" @click="showEditModal(role,i)">Edit</Button>
									<Button type="error" size="small" @click="showDeletingModal(role,i)" :loading="role.isDeleteing">Delete</Button>
								</td>
							</tr>
								<!-- ITEMS -->




						</table>
					</div>
				</div>

                 <!-- adding modal -->
                 <Modal
                 v-model="addModal"
                 title="Add Role"
                 :mask-closable="false"
                 :closable="false"
                 >
                     <Input v-model="data.roleName" placeholder="Enter Role Type.."  />

                     <div slot="footer">
                        <Button type="default" @click="addModal=false">Close</Button>
                        <Button type="primary" @click="add" :disable="isAdding" :loading="isAdding">{{isAdding ? 'Adding..' : 'Add Role'}}</Button>
                     </div>
                 </Modal>

                   <!--  edit modal -->
                 <Modal
                 v-model="editModal"
                 title="Edit Role"
                 :mask-closable="false"
                 :closable="false"
                 >
                     <Input v-model="editData.roleName" placeholder="Enter Role Type.."  />

                     <div slot="footer">
                        <Button type="default" @click="editModal=false">Close</Button>
                        <Button type="primary" @click="edit" :disable="isAdding" :loading="isAdding">{{isAdding ? 'Editing..' : 'Update Role'}}</Button>
                     </div>
                 </Modal>

                 <!-- delete modal -->
                 <!-- <Modal v-model="showDeleteModal">
                     <p slot="header" style="color:#f60;text-align:center">
                         <Icon type="ios-information-circle"></Icon>
                         <span>Delete Confirmation</span>
                     </p>
                     <div style="text-align:center">
                         <p>Are you sure you want to delete Item?</p>
                     </div>
                     <div slot="footer">
                         <Button type="error" size="large" long :loading="isDeleting" :disable="isDeleting" @click="deleteTag">Delete</Button>
                     </div>
                 </Modal> -->
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
                 roleName: ''
              },
              addModal : false,
              editModal : false,
              isAdding:false,
              roles : [],

              editData: {
                  roleName: ''
              },
              index : -1 ,
             showDeleteModal: false,
             isDeleting:false,
             deleteItem:{},
             deletingIndex:-1,
             isEditingItem:false,


          }
    },

    methods:{
        async add(){
            if(this.data.roleName.trim() == '' ) return this.e('Role name is required')
            const res = await this.callApi('post','app/create_role',this.data)
            if(res.status === 201){
                this.roles.unshift(res.data);
                this.s('Role has been added succefully')
                this.addModal = false
                this.data.roleName =''
            }else{
                if(res.status ==422){
                    if(res.data.errors.roleName){
                        this.e(res.data.errors.roleName[0])
                    }
                }else{
                   this.swr()
                }

            }
        },

         async edit(){
            if(this.editData.roleName.trim() == '' ) return this.e('Role name is required')
            const res = await this.callApi('post','app/edit_role',this.editData )
            if(res.status === 200){
                this.roles[this.index].roleName = this.editData.roleName
                this.s('Role has been Updated succefully')
                this.editModal = false
            }else{
                if(res.status ==422){
                    if(res.data.errors.roleName){
                        this.e(res.data.errors.roleName[0])
                    }
                }else{
                   this.swr()
                }

            }
        },
        showEditModal(role,index){
            let obj = {
                id: role.id,
                roleName: role.roleName
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },
         showDeletingModal(role,i){
            const  deleteModalObject =  {
            showDeleteModal: true,
            deleteUrl: "app/delete_role",
            data: role,
            deletingIndex: i,
            isDeleted: false
        }
          this.$store.commit('setDeletingModalobj',deleteModalObject)
        },
        // async deleteTag(){
        //     this.isDeleting = true
        //     const res = await this.callApi('post','app/delete_tag',this.deleteItem)
        //    if(res.status === 200){
        //        this.tags.splice(this.deletingIndex,1)
        //        this.s('Tag has been delete Successfully!')
        //    }else{
        //        this.swr()
        //    }
        //     this.isDeleting = false
        //     this.showDeleteModal = false

        // },
       
    },


        async created(){
            const res = await this.callApi('get','app/get_roles')
            if(res.status = 200){
                this.roles = res.data
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
                    this.roles.splice(this.deletingIndex,1)
               }
           }
       }




    }

</script>
