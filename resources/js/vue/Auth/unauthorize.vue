<template>
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-6">
        <div class="card card-default">
          <div class="card-header">Login</div>
          <div class="card-body">
            <div class="alert alert-danger" v-if="error !== '' ">
              {{error}}
            </div>
            <form autocomplete="off" @submit.prevent="login" method="post">
              <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" v-model="password" required>
              </div>
              <button type="submit" class="btn btn-primary">Signin</button>
            </form>
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
        email: null,
        password: null,
        success: false,
        has_error: false,
        error: '',
        responseBody: ''
      }
    },
    mounted() {
      //
    },
    methods: {
      login() {
        axios.post('/api/auth/login', {
            email: this.email,
            password: this.password
        })
        .then(response => {
            if(response.status == 200)
            {
                const d = new Date();
                d.setTime(d.getTime() + (48*60*60*1000));
                let expires = "expires="+ d.toUTCString();
                document.cookie = "authorize=" + response.headers.authorization + ";" + expires;
                window.location.href = "/todos";
            }
        })
        .catch(error => {
            this.error = error;
        })
      },
      getResponse(){
        document.cookie = 'authorize=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
        axios.post('api/auth/logout', {
            user: this.$user
        })
        .catch(error => {
            console.log(error);
        });
        alert('account deactivated');
      }
    },
    created(){
      this.getResponse();
    }
  }
</script>