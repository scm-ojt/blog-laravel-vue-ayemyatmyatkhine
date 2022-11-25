<template>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Import File</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" @click="importFile">
                        <input type="file" class="form-control my-3" ref="file" name="import_file" @change="handleFileData">
                        <button type="submit" class="btn btn-primary btn-submit">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { $fetch } from "ohmyfetch"
const messages = ref()
const import_file = ref()
const route = useRoute()
async function importFile(){   
    let formData = new FormData()
    formData.append('file' , import_file.value)
    if (route.path == '/post') {
        await $fetch(runtimeConfig.public.apiBase + '/post/import' ,{
            method: 'POST',
            body: formData
        }).then((response)=>{
            messages.value = response.message
        })
    }
    else {
        await $fetch(runtimeConfig.public.apiBase + '/category/import' ,{
            method: 'POST',
            body: formData
        }).then((response)=>{
            messages.value = response.message
        })
    }
}

function handleFileData(){
    import_file.value = this.$refs.file.files[0];
}

</script>