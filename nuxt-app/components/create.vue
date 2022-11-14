<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h4 v-if="categoryId == null || categoryId == 'null'">Create</h4>
        <h4 v-else>Update</h4>
      </div>
      <div class="card-body">
        <form action="" class="needs-validation" novalidate>
          <label for="">Category</label><span class="required">*</span>
          <input v-if="categoryId == null || categoryId == 'null'" type="text" class="form-control my-3" v-model="category" required />
          <input v-else type="text" class="form-control my-3" v-model="categoryName" required />
          <button class="btn btn-primary" @click.prevent="save" v-if="categoryId == null || categoryId == 'null'">Save</button>
          <button class="btn btn-primary" v-else @click.prevent="update(categoryId)">Update</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
	import { $fetch } from "ohmyfetch";
	const config = useRuntimeConfig();
	const category = ref();
	const message = ref();
	const props = defineProps({
		categoryId: String,
		categoryName: String,
	});
	// watch(props, (name) => {
	//     console.log(props)
	// })

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
		window.location.reload(true);
	}

	// update category
	async function update(categoryId) {
		await $fetch(config.public.apiBase + `/category/update/${categoryId}` , {
			method : 'PUT',
			body : {
				category : props.categoryName
			}
		})
		window.location.reload(true);
	}
</script>

<style src="../assets/css/list.css"></style>

