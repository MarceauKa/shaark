<template>
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-users mr-1"></i> {{ __("Users") }}</span>
            <button class="btn btn-primary btn-sm text-white" @click="add()">{{ __('Add user') }}</button>
        </div>

        <div class="card-body">
            <loader :loading="loading"></loader>

            <div class="table-responsive" v-if="!loading">
                <table class="table table-borderless table-sm">
                    <thead>
                    <tr>
                        <th>{{ __("Name") }}</th>
                        <th>{{ __("E-Mail Address") }}</th>
                        <th>{{ __("Is admin?") }}</th>
                        <th>#</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.is_admin ? __('Yes') : __('No') }}</td>
                        <td>
                            <button class="btn btn-info btn-sm text-white" @click="edit(user)">{{ __('Edit') }}</button>
                            <confirm class="btn btn-danger btn-sm text-white" :text="__('Delete')" :text-confirm="__('Confirm')" @confirmed="remove(user)"></confirm>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer" v-if="creating || editing">
            <user-form :editing="editing" @submited="formSubmited()"></user-form>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            users: [],
            loading: false,
            creating: false,
            editing: false,
        }
    },

    mounted() {
        this.fetch();
    },

    methods: {
        fetch() {
            this.loading = true;

            axios.get('/api/manage/users').then((response) => {
                this.loading = false;
                this.users = response.data.data;
            }).catch((error) => {
                this.loading = false;
                this.$toasted.error(this.__("Unable to load users"));
            })
        },

        remove(user) {
            this.loading = true;

            axios.delete(`/api/manage/users/${user.id}`)
                .then(response => {
                    this.$toasted.success(this.__("Deleted"));
                    this.fetch();
                })
                .catch(error => {
                    if (error.response.data.status === 'error') {
                        this.$toasted.error(error.response.data.message);
                    } else {
                        this.$toasted.error(this.__("Can't delete"));
                    }

                    this.loading = false;
                });
        },

        add() {
            this.creating = true;
            this.editing = false;
        },

        edit(user) {
            this.creating = false;
            this.editing = { ...user };
        },

        formSubmited() {
            this.creating = false;
            this.editing = false;
            this.fetch();
        }
    },
}
</script>
