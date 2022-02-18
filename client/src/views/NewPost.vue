<template>
  <div>
    <b-container>
      <h1>Create New Post</h1>
      <router-link
        class="btn btn-primary"
        :to="{name:'Posts'}"
      >Back</router-link>
      <b-form @submit.prevent="create" >
        <b-form-group
          id="title"
          label="Title:"
          label-for="title"
        >
          <b-form-input
            id="title"
            v-model="form.title"
            type="text"
            placeholder="Enter new title"
            required
          ></b-form-input>
        </b-form-group>

        <b-form-group
          id="src"
          label="Image :"
          label-for="src">
          <b-form-file
            id="src"
            v-model="file"
            type="file"
            placeholder="Enter src"
            required
          ></b-form-file>

        </b-form-group>

        <quillEditor
          ref="myQuillEditor"
          @change="onEditorChange($event)"
          v-model="form.description"
          :options="editorOption"/>

        <b-button type="submit" variant="primary">Save</b-button>
      </b-form>
    </b-container>
  </div>
</template>

<script>
import { quillEditor } from "vue-quill-editor"; //Call the Editor
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

export default {
  name: "NewPost",
  components:{quillEditor},
  data(){
    return {
      form:{
        title:'',
        src:'',
        description:'',
      },
      file: '',
      uillUpdateImg:false,
      serverUrl:'',
      value:this.content,
      editorOption: {
        placeholder: '',
        theme: 'snow',
        modules: {
          toolbar: {
            container: [
              ['bold'],
              ['italic'],
              ['underline'],
              ['strike'],
              [{'list':'ordered'},{'list': 'bullet' }],
              ['blockquote'], ['code-block'],
              ['link'],
              ['image'],
              [{'list': 'ordered'}, {'list': 'bullet'}],
            ],
            handlers: {
              'image': function (description) {
                if (description) {
                  document.querySelector('#quill-upload input').click()
                } else {
                  this.quill.format('image', false);
                }
              }
            }
          }
        }
      }
    }
  },
  methods:{
    create(){
      let formData = new FormData();

      formData.append('file', this.file);
      for (let i = 0; i < Object.keys(this.form).length;i++) {
        formData.append(Object.keys(this.form)[i], Object.values(this.form)[i]);
      }


      axios.post("http://127.0.0.1:8000/api/posts",
        formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        }).then(response => {
        this.$swal(response.data.msg);
        this.$router.push('/posts');
      })
    },
    onEditorChange({ quill, html, text }) {
      this.description = html
      this.$emit('textChange',html)
    },
  }
}
</script>

<style scoped>

</style>
