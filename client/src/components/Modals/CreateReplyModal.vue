<template>
  <BaseNoteModal
      :title="'Reply to Note'"
      :actionText="'Create Reply'"
      :placeholder="'Please enter your Reply'"
      @save="createReply"
      @close="$emit('close')"
  />
</template>

<script lang="ts">
import BaseNoteModal from './BaseNoteModal.vue';
import axios from 'axios';
import { defineComponent } from 'vue';

export default defineComponent ({  components: { BaseNoteModal },
  props: {
    parentId: Number
  },
  methods: {
    createReply(content: string) {
      axios.post('/api/notes/', { content, parent_id: this.parentId })
          .then(() => this.$emit('save'))
          .finally(() => this.$emit('close'));
    }
  }
});
</script>
