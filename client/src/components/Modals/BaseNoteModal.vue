<template>
  <div class="modal-backdrop" @click="$emit('close')">
    <div class="modal-content" @click.stop>
      <h2>{{ title }}</h2>
      <textarea v-model="updateContent" :placeholder="placeholder" rows="5"></textarea>
      <div class="actions">
        <button class="btn-inverted btn-green btn-lg" @click="$emit('close')">Cancel</button>
        <button class="btn btn-green btn-lg" @click="onSave">{{ actionText }}</button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue';

export default defineComponent ({
  props: {
    title: {
      type: String,
      required: true
    },
    actionText: {
      type: String,
      required: true
    },
    placeholder: {
      type: String,
      required: true
    },
    content: {
      type: String,
      default: ''
    }
  },
  data() {
    return {
      updateContent: this.content
    }
  },
  methods: {
    onSave() {
      this.$emit('save', this.updateContent);
    }
  }
});
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
  width: calc(100% - 20px);
}

.actions {
  display: flex;
  justify-content: space-between;
  gap: 10px;
}


</style>
