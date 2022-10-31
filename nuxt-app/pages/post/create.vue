<template>
    <div class="container">
        <div class="card create-card my-5">
            <div class="card-header">
                <h4 class="title text-center">Post Create</h4>
            </div>
            <div class="card-body d-flex flex-row">
                <div class="image">
                    <img src="../../assets/images/image1.webp" alt="" class="post-img">
                </div>
                <div class="form">
                    <div class="input-item mb-3">
                        <label for="">Choose Image</label>
                        <input type="file" class="form-control">
                    </div>
                    <div class="input-item mb-3">
                        <label for="category">Select Category</label>
                        <multiselect v-model="category" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :preserve-search="true" label="name" track-by="id" :preselect-first="true">
                            <pre class="language-json"><code>{{ category  }}</code></pre>
                        </multiselect>
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Title</label>
                        <input type="text" class="form-control">
                    </div>
                    <div class="input-item mb-3">
                        <label for="">Description</label>
                        <textarea name="" id="" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="input-item">
                        <button class="btn btn-secondary me-3">Clear</button>
                        <button class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
    const runtimeConfig = useRuntimeConfig();
    const { data: options , category } = await useFetch(runtimeConfig.public.apiBase + '/category/list');
</script>

<style src="../../assets/css/list.css"></style>

