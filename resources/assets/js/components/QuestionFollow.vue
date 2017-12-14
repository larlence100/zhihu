<template>
    <div class="panel panel-default">
        <div class="panel-heading" style="text-align: center">
            <h2>{{this.name}}</h2>

            <span>作者</span>
        </div>
        <div class="panel-body">
            <button class="btn btn-default pull-left" v-text="text" v-on:click="follow" v-bind:class="{'btn-success' : followed}">
                关注该问题
            </button>
            <a href="/questions/create" class="btn btn-primary pull-right">发布问题</a>
        </div>
    </div>
</template>

<script>
    export default {
        props:['question','name'],

        mounted() {
            axios.post('/api/question/follower',{'question':this.question}).then(response => {
                this.followed = response.data.followed
            })
        },
        data() {
            return {
                followed: false
            }
        },
        methods: {
            follow(){
                axios.post('/api/question/follow',{'question':this.question}).then(response => {
                    this.followed = response.data.followed
                })
            }
        },
        computed: {
            text() {
                return this.followed ? '已关注':'关注该问题'
            }
        }
    }
</script>
