<template>
    <button
        class="btn btn-default"
        v-bind:class="{'btn-success':voted}"
        v-text="vote_count"
        v-on:click="vote"
    ></button>
</template>

<script>
    export default {
        props:['answer', 'count'],
        mounted() {
            this.hasUserVote();
        },
        data: function () {
            return {
                voted: false,
                vote_count: this.count
            }
        },
        methods: {
            hasUserVote(){
                axios.get('/api/answer/'+ this.answer+'/vote/users',{}).then(response => {
                    this.voted = response.data.voted
                })
            },
            vote (){
                axios.post('/api/answer/vote',{answer: this.answer}).then(response => {
                    this.voted = response.data.voted
                    response.data.voted ? this.vote_count ++ : this.vote_count --
                })
            }
        },

    }
</script>
