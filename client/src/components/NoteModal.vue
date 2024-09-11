<template>
  <div class="modal-backdrop" @click="$emit('close')">
    <div class="modal-content" @click.stop>
      <h2>Create a Note</h2>
      <textarea v-model="updateContent" placeholder="Enter your note"></textarea>
      <div class="actions">
        <button class="btn-primary" @click="saveNote">Save</button>
        <button class="btn-secondary" @click="$emit('close')">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
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
      updateContent: this.content
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
  width: 100%;
  height: 100px;
  padding: 10px;
  border-radius: 5px;
  border: 1px solid #ccc;
  margin-bottom: 20px;
}

.actions {
  display: flex;
  justify-content: flex-end;
  gap: 10px;
}


</style>
