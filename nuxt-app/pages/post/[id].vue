<template>
    <div class="container mt-5 min-vh-75">
        <div class="card detail-card my-5">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="postImage">
                        <img v-if="post.image == null || post.image == 'null'" src="../../assets/images/image1.webp" alt="postImage" class="post-img">
                        <img  v-else :src="imageUrl + `/storage/images/${post.image}`" alt="" class="post-img image">
                    </div>
                    <div class="post-detail ms-4">
                        <h4>{{ post.title }}</h4>
                        <div class="part-1 d-flex flex-row w-100">
                            <div class="date">
                                <label for="">Date</label><span class="mx-1">:</span><span>{{ moment(post.created_at).format("dddd, MMMM Do YYYY") }}</span>
                            </div>
                            <div class="user">
                                <label for="">By</label><span class="mx-1">:</span><span>{{ post.user?.name }}</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex flex-row" v-for="category in post.categories" :key="category.id">
                            <div class="category">{{category['name']}}</div>
                        </div>
                        <div class="paragraph mt-3">{{post.body}}</div>
                    </div>
                </div>
                <div class="comment">
                    <div class="input-group my-4">
                        <input type="text" class="form-control" placeholder="Write comment here!" v-model="comment" aria-describedby="basic-addon2">
                        <button class="input-group-text" id="basic-addon2" type="submit" @click.prevent="createComment">Comment</button>
                    </div>
                    <div class="all-comment">
                        <label for="">All comments</label><span class="mx-2">:</span>
                        <div class="my-3" v-for="comment in post.comments" :key="comment.id">
                            <span class="comment-user me-2">{{ comment.user.name }}</span>
                            <span class="comment-body">{{comment['body']}}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import axios from 'axios'
    import { onMounted } from "vue";
    import moment from 'moment'
    import { useAuthStore } from '~/store/pinia'
    const store = useAuthStore()
    definePageMeta({
        layout: "after-login",
    })
    const runtimeConfig = useRuntimeConfig()
    const route = useRoute()
    const imageUrl = runtimeConfig.public.url
    const postId = route.params.id
    const comment = ref()
    const post = ref({})
    const getPost = async () => {
        await axios.get(runtimeConfig.public.apiBase + `/post/detail/${postId}`).then((response)=>{
            post.value = response.data
        })  
    }
    onMounted(getPost)
    
    // create comment
    async function createComment()
    {
        const data = {
            userId : store.userId,
            postId : route.params.id,
            comment : comment.value
        }
        await axios.post(runtimeConfig.public.apiBase + '/comment/create' , data ,{
            headers : {
                'Accept' : 'application/json',
                'Content-Type': 'application/json',
            },
        })
        comment.value = ''
        getPost()
    }
</script>

<style src="../../assets/css/list.css"></style>