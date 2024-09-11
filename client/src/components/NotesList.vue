<template>
  <div>
    <!-- Header -->
    <header>
      <h1>StoryClash Notes</h1>
      <button class="create-note-btn" @click="openModal">+</button>
    </header>

    <!-- Main content area -->
    <main>
      <ul class="notes-list">
        <li class="note-item" v-for="note in notes" :key="note.id">
          <div class="note-header">
            <img :src="note.user.avatar" alt="User Avatar" class="user-avatar" />
            <div class="user-info">
              <h4>{{ note.user.name }}</h4>
              <span>{{ note.createdAt }}</span>
            </div>
            <div class="note-actions">
              <button @click="openReplyModal(note.id)" class="action-btn">Reply</button>
              <button @click="deleteNote(note.id)" class="action-btn">Delete</button>
            </div>
          </div>
          <div class="note-content">
            <p>{{ note.content }}</p>
          </div>

          <!-- Replies -->
          <ul class="replies-list" v-if="note.replies">
            <li v-for="reply in note.replies" :key="reply.id" class="reply-item">
              <div class="reply-header">
                <img :src="reply.user.avatar" alt="User Avatar" class="user-avatar" />
                <div class="user-info">
                  <h5>{{ reply.user.name }}</h5>
                  <span>{{ reply.createdAt }}</span>
                </div>
              </div>
              <div class="reply-content">
                <p>{{ reply.content }}</p>
              </div>
            </li>
          </ul>

          <button class="reply-btn" @click="openReplyModal(note.id)">Reply</button>
        </li>
      </ul>
    </main>

    <!-- Modal component -->
    <NoteModal v-if="showModal" @save="fetchNotes" @close="closeModal" />
  </div>
</template>

<script>
import axios from 'axios';
import NoteModal from './NoteModal.vue';

export default {
  components: {
    NoteModal
  },
  data() {
    return {
      notes: [],
      showModal: false,
      parentId: null
    };
  },
  methods: {
    fetchNotes() {
      axios.get('/api/notes')
          .then(response => {
            this.notes = response.data;
          });
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.showModal = false;
    },
    openReplyModal(parentId) {
      this.parentId = parentId;
      this.openModal();
    },
    deleteNote(id) {
      axios.delete(`/api/notes/${id}`)
          .then(() => this.fetchNotes());
    }
  },
  mounted() {
    this.fetchNotes();
  }
}
</script>

<style scoped lang="scss">
@import '../assets/styles/_variables.scss';

.notes-list {
  list-style: none;
  padding: 0;
}

.note-item {
  background-color: #f9f9f9;
  margin-bottom: 20px;
  padding: 15px;
  border-radius: 10px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);

  .note-header {
    display: flex;
    justify-content: space-between;
    align-items: center;

    .user-avatar {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      margin-right: 10px;
    }

    .user-info {
      h4 {
        margin: 0;
      }

      span {
        font-size: 0.8rem;
        color: #777;
      }
    }

    .note-actions {
      .action-btn {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        margin-left: 5px;

        &:hover {
          background-color: #f0f0f0;
        }
      }
    }
  }

  .note-content {
    margin-top: 10px;
  }

  .replies-list {
    margin-top: 10px;
    padding-left: 20px;
    border-left: 2px solid #ddd;

    .reply-item {
      background-color: #f1f1f1;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 10px;
    }

    .reply-header {
      display: flex;
      align-items: center;

      .user-avatar {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        margin-right: 10px;
      }

      .user-info {
        h5 {
          margin: 0;
          font-size: 0.9rem;
        }

        span {
          font-size: 0.7rem;
          color: #999;
        }
      }
    }
  }

  .reply-btn {
    display: inline-block;
    margin-top: 10px;
    background-color: $green;
    color: #fff;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    border: none;

    &:hover {
      background-color: darken($green, 10%);
    }
  }
}
</style>
