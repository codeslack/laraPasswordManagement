<template>
    <div class="container-not mt-5">
        <div class="row justify-content-center">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-lock fa-fw"></i> Password Vaults
                        </h3>

                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">
                                <i class="fas fa-user-plus fa-fw"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Web</th>
                                    <th>User Name</th>
                                    <th>Password</th>
                                    <th>Opt. One</th>
                                    <th>Opt. Two</th>
                                    <th>Remarks</th>
                                    <th>Registered At</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="vault in vaults.data" :key="vault.id">
                                    <td>{{vault.id}}</td>
                                    <td>{{vault.site_name}}</td>
                                    <td>{{vault.user_name}}</td>
                                    <td>{{vault.password}}</td>
                                    <td>{{vault.opt_one}}</td>
                                    <td>{{vault.opt_two}}</td>
                                    <td>{{vault.remarks}}</td>
                                    <td>{{vault.created_at | myDate}}</td>

                                    <td>
                                        <button @click="editModal(vault)" class="btn btn-primary">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button :disabled="form.busy" @click="deleteUser(vault.id)" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="vaults" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div
            class="modal fade"
            id="addNew"
            tabindex="-1"
            role="dialog"
            aria-labelledby="addNewLabel"
            aria-hidden="true" >

            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-show="!editmode" id="addNewLabel">
                            <i class="fas fa-user-plus fa-fw"></i> Register New Info
                        </h5>
                        <h5 class="modal-title" v-show="editmode" id="addNewLabel">
                            <i class="fas fa-user-plus fa-fw"></i> Update Info
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editmode ? updateUser() : createUser()" autocomplete="off">
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <input
                                    v-model="form.site_name"
                                    type="text"
                                    name="site_name"
                                    placeholder="Web Site Name"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('site_name') }"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-globe-asia fa-fw"></i></span>
                                </div>
                                <has-error :form="form" field="site_name"></has-error>
                            </div>

                            <div class="input-group mb-3">
                                <input
                                    v-model="form.user_name"
                                    type="text"
                                    name="user_name"
                                    placeholder="User Name"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('user_name') }"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-user fa-fw"></i></span>
                                </div>
                                <has-error :form="form" field="user_name"></has-error>
                            </div>

                            <div class="input-group mb-3">
                                <input
                                    v-model="form.password"
                                    type="text"
                                    name="password"
                                    id="password"
                                    placeholder="Password"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('password') }"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-key fa-fw"></i></span>
                                </div>
                                <has-error :form="form" field="password"></has-error>
                            </div>


                            <div class="input-group mb-3">
                                <input
                                    v-model="form.opt_one"
                                    type="text"
                                    name="opt_one"
                                    id="opt_one"
                                    placeholder="Optional One"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('opt_one') }"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-dot-circle fa-fw"></i></span>
                                </div>
                                <has-error :form="form" field="opt_one"></has-error>
                            </div>

                            <div class="input-group mb-3">
                                <input
                                    v-model="form.opt_two"
                                    type="text"
                                    name="opt_two"
                                    id="opt_two"
                                    placeholder="Optional Two"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('opt_two') }"
                                >
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-dot-circle fa-fw"></i></span>
                                </div>
                                <has-error :form="form" field="opt_two"></has-error>
                            </div>

                            <div class="input-group mb-3">
                                <textarea
                                    v-model="form.remarks"
                                    name="remarks"
                                    id="remarks"
                                    placeholder="Notes (Optional)"
                                    class="form-control"
                                    :class="{ 'is-invalid': form.errors.has('remarks') }"
                                ></textarea>
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-file-alt fa-fw"></i></span>
                                </div>
                                <has-error :form="form" field="remarks"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">
                                <i class="fas fa-times-circle fa-fw"></i> Close
                            </button>
                            <button :disabled="form.busy"  v-show="editmode" type="submit" class="btn btn-success">
                                <i class="fas fa-save fa-fw"></i> Update
                            </button>
                            <button :disabled="form.busy" v-show="!editmode" type="submit" class="btn btn-success">
                                <i class="fas fa-save fa-fw"></i> Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>            

        </div>
    </div>
</template>




<script>
    
    export default {      

        data() {
            return {
                editmode: false,
                vaults: {},
                errors: [],
                form: new Form({
                    id: "",
                    user_id: "",
                    site_name: "",
                    user_name: "",
                    password: "",
                    opt_one: "",
                    opt_two: "",
                    remarks: ""
                })
            }
        },

        computed: {
            activeUsers() {
                return this.users.filter((user) => {
                    return user.isOnline
                })
            }
        },

        methods: {
            getResults(page = 1) {
                axios.get("api/vault?page=" + page).then(response => {
                    this.vaults = response.data;
                });
            },

            deleteUser(id) {
                swal
                    .fire({
                        title: "Are you sure?",
                        text: "You won't be able to revert this!",
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, delete it!"
                    })
                    .then(result => {
                        // Send request to the server
                        if (result.value) {
                            this.form
                                .delete("api/vault/" + id)
                                .then(() => {
                                    swal.fire("Deleted!", "Your Info has been deleted.", "success");
                                    Fire.$emit("callbackReload");
                                })
                                .catch(() => {
                                    swal.fire("Failed!", "There was something wronge.", "warning");
                                });
                        }
                    });
            },


            createUser() {
                this.$Progress.start();

                this.form
                    .post("api/vault")
                    .then(() => {
                        Fire.$emit("callbackReload");
                        $("#addNew").modal("hide");

                        toast.fire({
                            type: "success",
                            title: "User Created in successfully"
                        });
                        this.$Progress.finish();
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },

            updateUser() {
                this.$Progress.start();
                console.log('Editing data');
                this.form
                    .put("api/vault/" + this.form.id)
                    .then(() => {
                        // success
                        $("#addNew").modal("hide");
                        swal.fire("Updated!", "Information has been updated.", "success");
                        this.$Progress.finish();
                        Fire.$emit("callbackReload");
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            },
            editModal(vault) {
                this.editmode = true;
                this.form.reset();
                $("#addNew").modal("show");
                this.form.fill(vault);
            },
            newModal() {
                this.editmode = false;
                this.form.reset();
                $("#addNew").modal("show");
            },

            loadUsers() {
                this.$Progress.start();
                axios.get('api/vault')
                .then((response) => {
                    this.vaults = response.data;
                    this.$Progress.finish();
                })
                .catch(e => {
                    this.errors.push(e);
                    this.$Progress.fail();
                });
            }


        },

        created() {
            Fire.$on("searching", () => {
                let query = this.$parent.search;
                axios
                    .get("api/findVaults?q=" + query)
                    .then(data => {
                        this.vaults = data.data;
                    })
                    .catch(() => {
                        this.$Progress.fail();
                    });
            });
            this.loadUsers();
            Fire.$on("callbackReload", () => {
                this.loadUsers();
            });
        }
    }
</script>
