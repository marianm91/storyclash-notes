<template>
  <div class="modal-backdrop" @click="$emit('close')">
    <div class="modal-content" @click.stop>
      <h2>{{ title }}</h2>
      <textarea v-model="updateContent" rows="10" placeholder="Enter your note"></textarea>
      <div class="actions">
        <button class="btn-inverted btn-green btn-lg" @click="$emit('close')">Cancel</button>
        <button class="btn btn-green btn-lg" @click="saveNote">{{ actionText }}</button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import axios from "axios";

export default {
  props: {
    noteId: {
      type: Number,
      default: null
    },
    parentId: {
      type: Number,
      default: null
    },
    content: {
      type: String,
      default: ''
    },
  },
  data() {
    return {
      title: '',
      actionText: '',
      updateContent: this.content
    }
  },
  mounted() {
    if (this.noteId) {
      this.title = 'Edit Note';
      this.actionText = 'Save Note';
    } else if (this.parentId) {
      this.title = 'Create a new Reply';
      this.actionText = 'Create Reply';
    } else {
      this.title = 'Create a new Note';
      this.actionText = 'Create Note';
    }
  },
  methods: {
    saveNote() {
      if (this.noteId) {
        this.editNote()
      }

      if (this.parentId) {
        this.createNote();
      }
    },
    createNote() {
      axios.post('/api/notes/', {
        content: this.content,
        parent_id: this.parentId
      })
          .then(() => {
            this.$emit('save');
            this.$emit('close');
          });
    },
    editNote() {
      axios.put('/api/notes/'+this.noteId, {
        content: this.updateContent,
      })
          .then(() => {
            this.$emit('save');
            this.$emit('close');
          });
    }
  }
}
</script>

<style scoped>
h2 {
  font-size: 24px;
  margin-bottom: 10px;
  font-weight: bold;
}

textarea {
  padding: 10px;
  margin-bottom: 20px;
  width: calc(100% - 15px);
}

.actions {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}


</style>
