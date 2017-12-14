<template>
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            <h2 v-text="name"></h2>

            <span>作者</span>
        </div>
        <div class="panel-body">
            <button
                    class="btn btn-default"
                    v-text="text"
                    v-on:click="follow"
                    v-bind:class="{'btn-success' : followed}"
            >
                关注该问题
            </button>
            <send-message :user="this.toUser"></send-message>
           <!-- <a href="" class="btn btn-primary">发送私信</a>-->
        </div>
    </div>
</template>

<script>
    export default {
        props:['user','username'],
        mounted() {
            axios.get('/api/user/followers/'+this.user,{}).then(response => {
                this.followed = response.data.followed
            })
        },
        data() {
            return {
                followed: false,
                toUser : this.user
            }
        },
        methods: {
            follow(){
                axios.post('/api/user/follow',{'user':this.user}).then(response => {
                    this.followed = response.data.followed
                })
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注':'关注'
            },
            name() {
                return this.username
            }

        }
    }
</script>
