<template>
    <div>
        <button class="btn btn-primary ml-4" v-on:click="followUser" v-if="!self" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        props: ['userId', 'follows', 'self'],
        mounted() {
            console.log('Component mounted.')
        },
        data: function () {
            return {
                status: this.follows,
                self : this.self
            }
        },
        methods: {
            followUser() {
                axios.post('/follow/' + this.userId)
                    .then(response => {
                        this.status = ! this.status;
                        document.location.reload();
                        console.log(response.data);
                    })
                    .catch(errors => {
                        if (errors.response.status == 401) {
                            window.location = '/login';
                        }
                    });
            }
        },
        computed: {
            buttonText() {
                return (this.status) ? 'Unfollow' : 'Follow';
            }
        }
    }
</script>