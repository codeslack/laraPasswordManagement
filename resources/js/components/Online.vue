<template>
	<div class="container">
        <div class="row justify-content-center mt-5">
         
                <div class="col-md-6">
                <h1>All payments</h1>
                
                    
                        <li v-for="payment in payments" :key="payment.id">
                            <p>
                                {{payment.name}} {{ payment.amount}}
                            </p>
                        </li>
                   
                </div>

           
                <div class="col-md-6">
                        <h1>Unpaid Payments</h1>
                
                    
                        <li v-for="payment in unpaidPayments" :key="payment.id">
                            <p>
                                {{payment.name}} {{ payment.amount}}
                            </p>
                        </li>
                   
                </div>

                <div class="col-md-6">
                        <h1>Online User</h1>
                
                    
                        <li v-for="payment in activeUsers" :key="payment.id">
                            <p>
                                {{payment.name}} {{ payment.amount}}
                            </p>
                        </li>
                   
                </div>

        
            <div class="col-md-12">
				<div class="card">
                    <div class="card-header">
						<h3 class="card-title">
                            <i class="fas fa-users fa-fw"></i> Online User List
                        </h3>
					</div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                </tr>
							
                                <tr v-for="user in activeUsers" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td><i class="fas fa-dot-circle fa-fw text-success"></i> Online</td>                                    
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
  	

	
</template>

<script>
	export default {
		data() {
			return {
				users: [],
                errors: [],
                payments: [
                    {name: 'HouseRent', amount: 15000, paid: true},
                    {name: 'electricty', amount: 1000, paid: false},
                    {name: 'gas', amount: 800, paid: true},
                    {name: 'water', amount: 700, paid: false},
                    {name: 'net', amount: 600, paid: false},
                ]
                
			}
        },
        
    
		// Fetches posts when the component is created.
		created() {
            this.$Progress.start();
			axios.get(`api/online`)
				.then(response => {
					// JSON responses are automatically parsed.
                    this.users = response.data;
                    this.$Progress.finish();
				})
				.catch(e => {
                    this.errors.push(e);
                    this.$Progress.fail();
				})

        },
        
        computed: {
            activeUsers() {
                
                
                return this.users.filter((user) => {
                    return user.isOnline
                });

            },

            unpaidPayments() {
                //return this.payments;
                return this.payments.filter( (p) => {
                    return !p.paid;
                })

                 
            }
        }

	}
</script>
