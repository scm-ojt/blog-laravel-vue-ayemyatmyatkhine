<template>
    <div class="container mt-5 min-vh-75">
        <div class="card detail-card my-5">
            <div class="card-body">
                <div class="d-flex flex-row">
                    <div class="postImage">
                        <img v-if="post.image != null" :src="imageUrl + `/storage/images/${post.image}`" alt="postImage" class="post-img image">
                        <img  v-else src="../../assets/images/image1.webp" alt="" class="post-img">
                    </div>
                    <div class="post-detail ms-4">
                        <h4>{{ post.title }}</h4>
                        <div class="part-1 d-flex flex-row w-100">
                            <div class="date">
                                <label for="">Date</label><span class="mx-1">:</span><span>{{ moment(post.created_at).format("dddd, MMMM Do YYYY") }}</span>
                            </div>
                            <div class="user">
                                <label for="">By</label><span class="mx-1">:</span><span>{{ post.user.name}}</span>
                            </div>
                        </div>
                        <div class="mt-3 d-flex flex-row" v-for="category in post.categories" :key="category.id">
                            <div class="category">{{category.name}}</div>
                        </div>
                        <div class="paragraph mt-3">{{post.body}}</div>
                    </div>
                </div>
                <div class="comment">
                    <div class="input-group my-4">
                        <input type="text" class="form-control" placeholder="Write comment here!" v-model="comment" aria-describedby="basic-addon2">
                        <button class="input-group-text" id="basic-addon2" @click.prevent="createComment">Comment</button>
                    </div>
                    <div class="all-comment">
                        <label for="">All comments</label><span class="mx-2">:</span>
                        <div class="my-3">
                            <span class="comment-user me-2">hello</span>
                            <span class="comment-body">jsdfihweirjweir erjiweuriwerewj</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    import { $fetch } from "ohmyfetch";
    import moment from 'moment'
    const runtimeConfig = useRuntimeConfig()
    const route = useRoute()
    const imageUrl = runtimeConfig.public.url
    const comment = ref()
    const { data: post } = await useFetch(runtimeConfig.public.apiBase + `/post/detail/${route.params.id}`)
    const postId = route.params.id
    async function createComment()
    {
        await $fetch(runtimeConfig.public.apiBase + '/comment/create' , {
            method : 'POST',
            body : {
                postId : postId,
                comment : comment.value
            }
        })
    }
</script>

<style src="../../assets/css/list.css"></style>