<template>
  <div class="modal-backdrop" @click="$emit('close')">
    <div class="modal-content" @click.stop>
      <h2>Are you sure?</h2>
      <p>Do you really want to delete this note? This action cannot be undone.</p>
      <div class="actions">
        <button class="btn-primary" @click="confirmDelete">Delete</button>
        <button class="btn-secondary" @click="$emit('close')">Cancel</button>
      </div>
    </div>
  </div>
</template>

<script>
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
  justify-content: flex-end;
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
