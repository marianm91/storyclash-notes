<template>
  <div>
    <!-- Header -->
    <header>
      <div>
        <h1>Storyclash Notes</h1>
        <h3 class="text-gray">Manage and track your Creators in projects and analyze them.</h3>
      </div>
      <button class="btn btn-green btn-lg create-note-btn" @click="openModal">Create a New Note</button>
    </header>

    <main>
      <ul class="notes-list">
        <li v-for="note in notes" :key="note.id">
          <NoteItem
              :user="note.user"
              :content="note.content"
              :createdAt="note.createdAt"
              :actions="[
              { label: 'Edit', handler: () => openEditModal(note.id, note.content) },
              { label: 'Delete', handler: () => showDeleteWarning(note.id) }
            ]"
          />
          <div v-if="note.replies">
            <li v-for="reply in note.replies" :key="reply.id">
              <NoteItem
                  :user="reply.user"
                  :content="reply.content"
                  :createdAt="reply.createdAt"
                  :actions="[]"
                  :isReply="true"
              />
            </li>
          </div>
          <button class="btn btn-secondary reply-btn" @click="openReplyModal(note.id)">Reply</button>
        </li>
      </ul>
    </main>

    <!-- Modal component -->
    <NoteModal v-if="showModal" :parent-id="createNoteParentId" :note-id="noteToUpdateId" :content="noteToUpdateContent"
               @save="fetchNotes" @close="closeModal"/>
    <ConfirmationModal v-if="showConfirmationModal" :noteId="noteToDeleteId" @confirm="deleteNote"
                       @close="closeConfirmationModal"/>
  </div>
</template>

<script>
import axios from 'axios';
import NoteModal from './NoteModal.vue';
import NoteItem from './NoteItem.vue';
import ConfirmationModal from './ConfirmationModal.vue';

export default {
  components: {
    NoteModal,
    NoteItem,
    ConfirmationModal
  },
  data() {
    return {
      notes: [],
      showModal: false,
      showConfirmationModal: false,
      createNoteParentId: null,
      noteToUpdateId: null,
      noteToUpdateContent: null,
      noteToDeleteId: null,
    };
  },
  methods: {
    fetchNotes() {
      axios.get('/api/notes').then((response) => {
        this.notes = response.data;
      });
    },
    openModal() {
      this.showModal = true;
    },
    closeModal() {
      this.createNoteParentId = null;
      this.noteToUpdateId = null;
      this.showModal = false;
      this.noteToUpdateContent = null;
    },
    openEditModal(noteId, content) {
      this.noteToUpdateId = noteId;
      this.noteToUpdateContent = content;
      this.openModal();
    },
    openReplyModal(parentId) {
      this.createNoteParentId = parentId;
      this.openModal();
    },
    showDeleteWarning(noteId) {
      this.noteToDeleteId = noteId;
      this.showConfirmationModal = true;
    },
    closeConfirmationModal() {
      this.showConfirmationModal = false;
      this.noteToDeleteId = null;
    },
    deleteNote(id) {
      axios.delete(`/api/notes/${id}`).then(() => this.fetchNotes());
    },
  },
  mounted() {
    this.fetchNotes();
  },
};
</script>

<style scoped lang="scss">
@import '../assets/styles/_variables.scss';

header h3 {
  font-weight: normal;
}

.create-note-btn {
  box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
}

.notes-list {
  list-style: none;

  & > li {
    border-bottom: 2px solid #ddd;
    padding:24px;
  }
  .reply-btn {
    margin-left: 45px;
  }
}
</style>
