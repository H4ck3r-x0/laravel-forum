<template>
	<div class="font-sans">
		<div class="container mx-auto flex justify-center">
		<form 
		  method="POST" 
		  action="/login" 
		  class="w-full max-w-lg bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"
		  @submit.prevent="login"
		  @keydown="form.errors.clear($event.target.name)"
		  >
		  	<h1 class="text-3xl text-gray-700 font-medium py-5 tracking-wider">Sign In</h1>
		  	<div class="text-red-500 text-xl mb-3">
		  		<p v-text="error"></p>
		  	</div>
		    <div class="mb-4">
		      <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
		        E-Mail Address
		      </label>
		      <input 
		      name="email"
		      v-model="form.email"
		      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
		      :class="form.errors.has('email') ? 'border border-red-500' : ''"
		      id="email" 
		      type="email" 
		      placeholder="Email Address" 
		      autocomplete="email" autofocus>
		    <p class="text-red-500 text-xs italic"
               v-if="form.errors.has('email')"
               v-text="form.errors.get('email')"></p>
		    </div>
		    <div class="mb-6">
		      <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
		        Password
		      </label>
		      <input 
		      name="password"
		      v-model="form.password" 
		      class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" 
		      :class="form.errors.has('password') ? 'border border-red-500' : ''"
		      id="password" 
		      type="password" 
		      placeholder="******************" 
		      autocomplete="current-password">
		    <p class="text-red-500 text-xs italic"
               v-if="form.errors.has('password')"
               v-text="form.errors.get('password')"></p>
		    </div>
		    <div class="md:flex md:items-center mb-6">
			    <label class="md:w-2/3 block text-gray-500 font-bold">
			      <input class="mr-2 leading-tight" v-model="form.remember" name="remember" type="checkbox">
			      <span class="text-sm">
			        Remember Me
			      </span>
			    </label>
	  		</div>
		    <div class="flex items-center justify-between">
		      <button 
			      class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none" 
			      type="submit"
		      >
		        Sign In
		      </button>
		      <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="/password/reset">
		        Forgot Your Password?
		      </a>
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
    			error: '',
                form: new Form({
                    email: '',
                    password: '',
                    remember: false
                }),
    		}
    	},

    	methods: {
            login() {
                this.form.post('/login')
                .then(response => {
                    window.location.href = '/threads';
                })
                .catch(error => {
                	 this.handleLoginErrors(error);
                })
            },

            handleLoginErrors(error)
            {
	        	 if (error.response.status == 406) 
	        	 {
	        	 	 this.error = error.response.data.errors;
	        	 	 this.form.password = '';
	        	 }
            }
    	}

    }
</script>
