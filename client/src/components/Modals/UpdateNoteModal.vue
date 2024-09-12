<template>
  <BaseNoteModal
      :title="'Update Note'"
      :actionText="'Update Note'"
      :placeholder="'Please enter your Note'"
      :content="note?.content"
      @save="updateNote"
      @close="$emit('close')"
  />
</template>

<script lang="ts">
import BaseNoteModal from './BaseNoteModal.vue';
import axios from 'axios';
import {Note} from "@/types/types";
import { defineComponent } from 'vue';

export default defineComponent ({  components: { BaseNoteModal },
  props: {
    note: Object as () => Note,
  },
  methods: {
    updateNote(content: string) {
      axios.put(`/api/notes/${this.note?.id}`, { content })
          .then(() => this.$emit('save'))
          .finally(() => this.$emit('close'));
    }
  }
});
</script>
