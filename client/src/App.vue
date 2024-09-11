<template>
  <NotesList/>
</template>

<script lang="ts">
import { defineComponent } from 'vue';
import NotesList from './components/NotesList.vue';
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000'
export default defineComponent({
  name: 'App',
  components: {
    NotesList
  }
});
</script>
