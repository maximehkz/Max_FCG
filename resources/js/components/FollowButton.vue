
<template>
    <div>
        <button class="btn btn-primary ml-4" @click="followUser" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows'],
        mounted() {
            console.log('Component mounted.')
        },
        data: function () {
            return {
                status: this.follows,
            }
        },
        methods: {
            followUser() {
                console.log('clicked button')
                axios.post('/follow/' + this.userId)
                    .then(response => {
                        this.status = ! this.status;
                        console.log(response.data);
                    })
                    .catch(errors => {
                      if (errors.response.status == 401) { //if error 401 pops in, the user will be redirected to the login page. Authentication must be done before following.
                           window.location = '/login';
                      }
                    });
            }
        },
        computed: {
            buttonText() {
                console.log('status ' + this.status)
                return (this.status) ? 'Unfollow' : 'Do Follow';
            }
        }
    }
</script>
