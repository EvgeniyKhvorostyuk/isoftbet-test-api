<template>
    <div class="container">
        <transition name="fade">
            <div v-if="transactions.length > 0"  class="row justify-content-center">
                <div class="col-lg-12 col-md-12 col-xs-12">
                    <div class="card card-default">
                        <div class="card-header">Transactions list</div>

                        <div class="card-body table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>CustomerId</th>
                                        <th class="text-center">Amount</th>
                                        <th class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="transaction in transactions" :key="transaction.transactionId">
                                        <td>{{ transaction.transactionId }}</td>
                                        <td>{{ transaction.customerId }}</td>
                                        <td class="text-center">{{ transaction.amount }}</td>
                                        <td class="text-center">{{ transaction.date }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <!-- Create Token Modal -->
        <div class="modal fade" id="modal-access-token" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Please enter Your access token
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>

                    <div class="modal-body">
                        <!-- Create Token Form -->
                        <form role="form" @submit.prevent="store">
                            <!-- Name -->
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Token</label>

                                <div class="col-md-6">
                                    <input id="create-token-name" type="text" class="form-control" :class="{'is-invalid': error.length > 0}" name="token" v-model="token" @input="error = ''">
                                    <span v-if="error.length > 0" class="invalid-feedback" role="alert">
                                        <strong>{{ error }}</strong>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="store">
                            Add Token
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        name: 'transactions',
        mounted () {
            // if (this.token.length === 0 || localStorage.getItem('token')) {
            if (this.token.length === 0) {
                this.showAccessTokenForm();
            }
            // else {
            //     this.token = localStorage.getItem('token');
            //     this.getTransactions(this.token);
            // }
        },
        data () {
            return {
                token: '',
                error: '',
                transactions: []
            }
        },
        methods: {
            store () {
                if (this.token.length > 0) {
                    // localStorage.setItem('token', this.token);
                    this.getTransactions(this.token);
                } else {
                    this.error = 'Token is required!'
                }
            },
            getTransactions (token) {
                return axios.get('/api/transactions', {
                    headers: {
                        "Authorization": `Bearer ${token}`
                    }
                })
                .then(response => {
                    this.transactions = response.data;
                    $('#modal-access-token').modal('hide');
                })
                .catch(error => {
                    this.error = error.message
                    // localStorage.removeItem('token');
                });
            },
            showAccessTokenForm() {
                $('#modal-access-token').modal('show');
            },
        }
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .9s;
    }
    .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
        opacity: 0;
    }
</style>
