<template>
  <div>
    <div class="card">
      <div class="card-header">
        <h4 v-if="categoryId == null || categoryId == 'null'">Create</h4>
        <h4 v-else>Update</h4>
      </div>
      <div class="card-body">
        <form action="">
			<label for="">Category</label><span class="required">*</span>
			<!-- create -->
			<div class="my-3" v-if="categoryId == null || categoryId == 'null'" :class="{ 'has-error': errorMessage }">
				<input name="category" type="text" class="form-control" v-model="name"/>
				<span v-if="errorMessage" class="required">{{ errorMessage }}</span>
			</div>
			<!-- update -->
			<div class="my-3" v-else :class="{ 'has-error': errorMessage }">	
				<input type="text" class="form-control" v-model="categoryName"/>
				<span v-if="errorMessage" class="required">{{ errorMessage }}</span>
			</div>
			<button class="btn btn-primary" type="submit" @click.prevent="save" v-if="categoryId == null || categoryId == 'null'">Save</button>
			<button class="btn btn-primary" type="submit" v-else @click.prevent="update(categoryId)">Update</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
	import axios from 'axios'
	const config = useRuntimeConfig()
	const name = ref();
	const message = ref();
	const errorMessage = ref()
	const props = defineProps({
		categoryId: String,
		categoryName: String,
	})

	const emit = defineEmits(["successMessage"]);

	// add new category
	async function save() {
		const data = {
			name: name.value
		}
		await axios.post(config.public.apiBase + "/category/create", data , {
			headers : {
                'Accept' : 'application/json',
                'Content-Type': 'application/json'
            },
		}).then((response) => {
			message.value = response.data.successMessage
			emit("successMessage", message.value)
			name.value = ''
		}).catch((error)=>{
			errorMessage.value = error.response.data.errors.name[0]
		})
	}

	// update category
	async function update(categoryId) {
		const updateData = {
			categoryName : props.categoryName
		}
		await axios.put(config.public.apiBase + `/category/update/${categoryId}` , updateData).then((response) =>{
			message.value = response.data.successMessage
			emit("successMessage", message.value)
		}).catch((error) => {
			errorMessage.value = error.response.data.errors.categoryName[0]
		})
	}
</script>

<style src="../assets/css/list.css"></style>

