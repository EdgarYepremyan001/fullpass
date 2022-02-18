<template>
  <div>
    <b-container>
      <h1>Edit ...{{post.title}}</h1>
      <b-form @submit.prevent="editPost" >
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
          label="Image Url:"
          label-for="src"
        >
          <b-form-file
            id="src"
            v-model="file"
            type="text"
            placeholder="Enter new img Url"
            required
          ></b-form-file>
        </b-form-group>

        <quillEditor
          ref="myQuillEditor"
          @change="onEditorChange($event)"
          v-model="form.description"
          :options="editorOption"/>

        <b-button v-if="!form.approved" variant="primary" @click.prevent="form.approved = !form.approved">Approve</b-button>
        <b-button type="submit" variant="primary">Save</b-button>
      </b-form>
    </b-container>
  </div>
</template>


<script>
import { quillEditor } from "vue-quill-editor";
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';

export default {
  name: "AdminEditPosts",
  components:{quillEditor},
  data(){
    return {
      form:{
        title:'',
        src:'',
        description:'',
        approved: '',
      },
      file:'',
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
  mounted(){
    this.$store.dispatch('Posts/getAPIPost',this.$route.params.id);
  },
  computed:{
    post(){
      this.form.title = this.$store.getters['Posts/getPost']['title'];
      this.form.src = this.$store.getters['Posts/getPost']['src'];
      this.form.description = this.$store.getters['Posts/getPost']['description'];
      this.form.approved = this.$store.getters['Posts/getPost']['approved'];
      return this.$store.getters['Posts/getPost'];
    }
  },
  methods:{
    editPost(){
      this.axios.put(`http://127.0.0.1:8000/api/posts/${this.$route.params.id}`,this.form).then(response => {
        this.$swal(response.data.msg);
        this.$router.push(`/posts/${this.$route.params.id}`);
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
