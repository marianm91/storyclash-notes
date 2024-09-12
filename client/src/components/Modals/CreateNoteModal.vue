<template>
  <BaseNoteModal
      :title="'Create a new Note'"
      :actionText="'Create Note'"
      :placeholder="'Please enter your Note'"
      @save="saveNote"
      @close="$emit('close')"
  />
</template>

<script lang="ts">
import BaseNoteModal from './BaseNoteModal.vue';
import axios from 'axios';
import { defineComponent } from 'vue';

export default defineComponent ({
  components: { BaseNoteModal },
  methods: {
    saveNote(content: string) {
      axios.post('/api/notes/', { content })
          .then(() => this.$emit('save'))
          .finally(() => this.$emit('close'));
    }
  }
});
</script>
