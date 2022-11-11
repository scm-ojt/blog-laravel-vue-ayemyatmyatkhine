<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h4>Create</h4>
        <h4 >Update</h4>
      </div>
      <div class="card-body">
        <form action="" @submit.prevent="save" class="needs-validation" novalidate>
            <label for="">Category</label><span class="required">*</span>
            <input type="text" class="form-control my-3" v-model="category" required>
            <button class="btn btn-primary" type="submit" v-if="create">Save</button>
            <button class="btn btn-primary" type="submit" v-else>Update</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { $fetch } from "ohmyfetch"
const config = useRuntimeConfig()
const category = ref()
const categoryId = ref()
const message = ref()
// save new category
async function save() {
  await $fetch(config.public.apiBase + "/category/create", {
    method: "POST",
    body: {
      name: category.value,
    },
  }).then((response) => {
    message.value = response.successMessage;
  });
  window.location.reload(true)
}
</script>

<style src="../assets/css/list.css"></style>

