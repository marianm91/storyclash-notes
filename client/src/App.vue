<template>
  <NotesList/>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import NotesList from './components/NotesList.vue';
import axios from 'axios'

axios.defaults.baseURL = process.env.VUE_APP_API_URL;
export default defineComponent({
  name: 'App',
  components: {
    NotesList
  }
});
</script>
