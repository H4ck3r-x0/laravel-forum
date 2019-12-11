<template>
    <div class="font-sans h-screen">
        <div class="container mx-auto flex justify-center">
            <form class="w-full max-w-lg bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
                  @submit.prevent="register"
                  @keydown="form.errors.clear($event.target.name)">
                <h1 class="text-3xl text-gray-700 font-medium py-5 tracking-wider">Become a Member</h1>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full md:w-1/2 px-3 mb-6 md:mb-0">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-full-name">
                            Full Name
                        </label>
                        <input
                            name="name"
                            v-model="form.name"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-full-name"
                            :class="form.errors.has('name') ? 'border border-red-500' : ''"
                            type="text"
                            autofocus
                            placeholder="Jane Doe">
                        <p class="text-red-500 text-xs italic"
                           v-if="form.errors.has('name')"
                           v-text="form.errors.get('name')"></p>
                    </div>
                    <div class="w-full md:w-1/2 px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-username">
                            username
                        </label>
                        <input
                            name="username"
                            v-model="form.username"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            :class="form.errors.has('username') ? 'border border-red-500' : ''"
                            id="grid-username"
                            type="text"
                            placeholder="JaneDoe">
                        <p class="text-red-500 text-xs italic"
                           v-if="form.errors.has('username')"
                           v-text="form.errors.get('username')"></p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-email-address">
                            email address
                        </label>
                        <input
                            name="email"
                            v-model="form.email"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            :class="form.errors.has('email') ? 'border border-red-500' : ''"
                            id="grid-email-address"
                            type="email"
                            placeholder="example@example.com">
                        <p class="text-red-500 text-xs italic"
                           v-if="form.errors.has('email')"
                           v-text="form.errors.get('email')"></p>
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-password">
                            Password
                        </label>
                        <input
                            name="password"
                            v-model="form.password"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            :class="form.errors.has('password') ? 'border border-red-500' : ''"
                            id="grid-password"
                            type="password"
                            placeholder="******************">
                        <p class="text-red-500 text-xs italic"
                           v-if="form.errors.has('password')"
                           v-text="form.errors.get('password')"></p>

                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3">
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                               for="grid-password-confirm">
                            Confirm Password
                        </label>
                        <input
                            name="password_confirmation"
                            v-model="form.password_confirmation"
                            class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                            id="grid-password-confirm"
                            type="password"
                            placeholder="******************">
                    </div>
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full md:w-1/3 px-3 mb-6 md:mb-0">
                        <button
                            :disabled="form.errors.any()"
                            type="submit"
                            :class="form.errors.any() ? 'cursor-not-allowed bg-gray-100 text-gray-400' : 'bg-secondary hover:bg-lightBlue'"
                            class="font-medium tracking-wide px-4 py-1 rounded text-white focus:outline-none"
                            >
                            Sign Up
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import Form from "../../helpers/Form";

    export default {
        data() {
            return {
                showErrors: false,
                form: new Form({
                    name: '',
                    username: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            register() {
                this.form.post('/register')
                .then(response => {
                    window.location.href = '/threads';
                })
                .catch(error => {
                    this.showErrors = true;
                })
            },
        }
    }
</script>
