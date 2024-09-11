<template>
  <div class="modal-backdrop" @click="$emit('close')">
    <div class="modal-content" @click.stop>
      <h2>Are you sure you want to delete?</h2>
      <p>By deleting this note all replies will be deleted too. This cannot be undone!</p>
      <div class="actions">
        <button class="btn-inverted btn-green btn-lg" @click="$emit('close')">Cancel</button>
        <button class="btn btn-lg btn-red" @click="confirmDelete">Delete</button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
export default {
  props: ['noteId'],
  methods: {
    confirmDelete() {
      this.$emit('confirm', this.noteId);
      this.$emit('close');
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

p {
  margin-bottom: 20px;
}

.actions {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}

.btn-primary {
  background-color: red;
  color: white;
}

.btn-secondary {
  background-color: grey;
  color: white;
}
</style>
