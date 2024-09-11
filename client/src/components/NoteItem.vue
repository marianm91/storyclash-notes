<template>
  <div :class="['note-item', { reply: isReply }]">
    <div class="note-header">
      <img v-if="!isReply" :src="require('@/assets/note.png')" alt="Note" class="note-icon">
      <img :src="user.avatar" alt="User Avatar" class="user-avatar"/>
      <div class="user-info">
        <h4 v-if="!isReply">{{ user.name }}</h4>
        <h5 v-else>{{ user.name }}</h5>
        <span>{{ formatDate(createdAt) }}</span>
      </div>
      <div class="note-actions">
        <button v-for="(action, index) in actions" :key="index" class="btn" @click="action.handler">
          {{ action.label }}
        </button>
      </div>
    </div>
    <div class="note-content">
      <p>{{ content }}</p>
    </div>
  </div>
</template>

<script lang="ts">
import DateTimeMixin from '@/mixins/DateTimeMixin.vue'
export default {
  mixins: [DateTimeMixin],
  props: {
    user: {
      type: Object,
      required: true,
    },
    content: {
      type: String,
      required: true,
    },
    createdAt: {
      type: String,
      required: true,
    },
    actions: {
      type: Array,
      required: true,
    },
    isReply: {
      type: Boolean,
      default: false,
    },
  },
};
</script>

<style scoped lang="scss">
.note-item {
  &.reply {
    .note-header {
      margin-left: 35px;
    }
  }

  .note-header {
    display: flex;
    align-items: center;

    .note-icon {
      margin: 0 6px;
    }

    .user-avatar {
      width: 35px;
      height: 35px;
      border-radius: 50%;
      margin: 0 6px;
    }

    .user-info {
      h4 {
        margin: 0;
      }

      h5 {
        margin: 0;
        font-size: 0.9rem;
      }

      span {
        font-size: 0.8rem;
        color: #777;
      }
    }

    .note-actions {
      display: flex;
      padding: 10px;

      button {
        margin: 0 5px
      }
    }
  }

  .note-content {
    margin: 10px 60px;
    padding: 5px 24px;
    border-left: 2px solid #ddd;
  }
}
</style>
