<template>
    <div class="w-100">
        <div class="bg-white shadow-sm mx-auto mt-3 rounded-lg overflow-hidden" style="max-width: 500px">
            <div class="text-center text-shadow px-4 py-5 bg-dark">
                <h1 class="text-warning mb-1 display-4">Settings</h1>
                <h6 class="text-light mb-0 lead font-weight-normal">Fill out the form below</h6>
            </div>
            <form autocomplete="off" class="px-5 pt-4 pb-5" @submit.prevent="onSubmit">
                <input type="hidden" name="id" v-model="form.id">
                <div class="form-group">
                    <label class="required" for="">Full name</label>
                    <input type="text" class="form-control" name="name" placeholder="John Doe" v-model="form.name" :class="{ 'is-invalid': form.errors.has('name') }">
                    <small class="text-danger mt-1" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></small>
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" placeholder="johndoe" v-model="form.username" :class="{ 'is-invalid': form.errors.has('username') }">
                    <small class="text-danger mt-1" v-if="form.errors.has('username')" v-text="form.errors.get('username')"></small>
                </div>
                <div class="form-group">
                    <label class="required" for="">Email address</label>
                    <input type="email" class="form-control" name="email" placeholder="johndoe@example.com" v-model="form.email" :class="{ 'is-invalid': form.errors.has('email') }">
                    <small class="text-danger mt-1" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></small>
                </div>
                <div class="form-group">
                    <label for="">New password</label>
                    <input type="password" class="form-control" name="password" v-model="form.password" :class="{ 'is-invalid': form.errors.has('password') }">
                    <small class="text-danger mt-1" v-if="form.errors.has('password')" v-text="form.errors.get('password')"></small>
                </div>
                <div class="form-group">
                    <label for="">Password confirmation</label>
                    <input type="password" class="form-control" name="password_confirmation" v-model="form.password_confirmation" :class="{ 'is-invalid': form.errors.has('password') }">
                </div>
                <div class="grid">
                    <label for="image">Change profile image</label>
                    <input type="file" name="profileImage" class="form-control-file mt-1" id="image" @change="onImageChange">
                </div>
                <button class="btn btn-dark rounded-pill mt-4 btn-block btn-sm py-3 border-0">Submit</button>
            </form>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters, mapActions } from 'vuex';
import Form from '@/core/Form';
export default {
    computed: {
        ...mapGetters({
            user: 'auth/user'
        }),
    },
    data() {
        return {
            form: new Form({
                id: null,
                name: '',
                email: '',
                username: '',
                password: '',
                password_confirmation: '',
            }),

            profileImage: null,
        }
    },
    mounted() {
        this.form.id = this.user.id;
        this.form.name = this.user.name;
        this.form.username = this.user.username || '';
        this.form.email = this.user.email;
    },
    methods: {
        ...mapActions({
            'attempt': 'auth/attempt',
            'updateUser': 'auth/updateUser'
        }),
        onSubmit() {
            this.form.post('/account/update').then(async (response) => {
                let tempUser = response.data;
                if(this.profileImage !== null) {
                    let temp = new FormData(); // temporary variable to handle profile image submission
                    temp.append('profile_image', this.profileImage);

                    try {
                        let response = await axios.post(`/users/${this.user.id}/profile-image`, temp);
                        tempUser.image_path = response.data;
                    } catch(error) { console.log(error); }
                }

                this.updateUser(tempUser);
            }).catch(error => { console.log(error) }).finally(() => {
                if(this.user.permissions.includes('view collaborators')) this.$router.replace('/dashboard');
                else this.$router.replace({ name: 'profile', params: { id: this.user.id } });

                // window.location.reload();
            });
        },
        onImageChange(event) {
            this.profileImage = event.target.files[0];
        }
    }
}
</script>