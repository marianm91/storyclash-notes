<template>
  <div class="modal-backdrop" @click="$emit('close')">
    <div class="modal-content" @click.stop>
      <h2>{{ title }}</h2>
      <p></p>
      <div class="actions">
        <button class="btn-inverted btn-green btn-lg" @click="$emit('close')">Cancel</button>
        <button class="btn btn-lg btn-red" @click="confirm">{{ action }}</button>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import {Note} from "@/types/types";
import {defineComponent} from 'vue';

export default defineComponent({
  props: {
    note: {
      type: Object as () => Note
    },
    title: String,
    action: String,
    message: String
  },
  methods: {
    confirm() {
      this.$emit('confirm', this.note?.id);
      this.$emit('close');
    }
  }
})
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

</style>
