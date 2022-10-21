export default {
    data() {
        return {
            posts : []
        }
    },
    mounted() {
        this.postList();
    },
    methods: {
        postList()
        {
            this.$axios.get('/post/list').then((response) => {
                this.posts = response.data;
            })
        }
    }
}