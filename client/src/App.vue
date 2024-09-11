<template>
  <div id="app">
    <NotesList/>
  </div>
</template>

<script>
import NotesList from './components/NotesList.vue'
import axios from 'axios'

axios.defaults.baseURL = 'http://127.0.0.1:8000'
export default {
  components: {
    NotesList
  }
}
</script>
