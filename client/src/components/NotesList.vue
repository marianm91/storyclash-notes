<template>
  <div>
    <header>
      <div>
        <h1>Storyclash Notes</h1>
        <span class="text-gray text-lg">Manage and track your Creators in projects and analyze them.</span>
      </div>
      <button class="btn btn-green btn-lg create-note-btn" @click="openCreateModal">Create a New Note</button>
    </header>

    <main>
      <ul class="notes-list">
        <li v-for="note in notes" :key="note.id">
          <NoteItem
              :user="note.user"
              :content="note.content"
              :createdAt="note.createdAt"
              @edit="openEditModal(note)"
              @delete="showDeleteConfirmation(note)"
          />
          <button v-if="shouldShowMoreButton(note)"
                  class="btn thread-btn"
                  @click="showAllReplies(note.id)">
            Show {{ note?.replies?.length - 1 }} more replies
          </button>
          <div v-if="shouldShowMoreButton(note)" class="thread-line-extension"></div>
          <ul v-if="note.replies">
            <li v-for="(reply, index) in note.replies" :key="reply.id"
                :class="{ 'collapsed-reply': isReplyCollapsed(index, note) }">
              <NoteItem
                  :user="reply.user"
                  :content="reply.content"
                  :createdAt="reply.createdAt"
                  :isReply="true"
              />
            </li>
          </ul>

          <button class="btn btn-secondary thread-btn" @click="openReplyModal(note.id)">Reply</button>
        </li>
      </ul>
    </main>

    <!-- Modal components -->
    <UpdateNoteModal v-if="noteToUpdate" :note="noteToUpdate" @save="fetchNotes" @close="closeModals"/>
    <CreateNoteModal v-if="createNote" @save="fetchNotes" @close="closeModals"/>
    <CreateReplyModal v-if="noteToReplyId" :parent-id="noteToReplyId" @save="fetchNotes" @close="closeModals"/>

    <ConfirmationModal v-if="noteToDelete" :note="noteToDelete" action="Delete" @confirm="deleteNote"
                       @close="closeConfirmationModal">
      <h2>Are you sure you want to delete?</h2>
      <p>By deleting this note all replies will be deleted too. This cannot be undone!</p>
    </ConfirmationModal>
  </div>
</template>

<script lang="ts">
import axios from 'axios';
import NoteItem from './NoteItem.vue';
import ConfirmationModal from './Modals/ConfirmationModal.vue';
import CreateNoteModal from './Modals/CreateNoteModal.vue';
import UpdateNoteModal from './Modals/UpdateNoteModal.vue';
import CreateReplyModal from './Modals/CreateReplyModal.vue';
import {Note} from "@/types/types";
import {defineComponent} from 'vue';

export default defineComponent({
  components: {
    NoteItem,
    CreateNoteModal,
    UpdateNoteModal,
    CreateReplyModal,
    ConfirmationModal
  },
  data() {
    return {
      notes: [] as Array<Note>,
      expandedNotes: [] as Array<number>,
      noteToReplyId: null as null | number,
      noteToUpdate: null as null | Note,
      noteToDelete: null as null | Note,
      createNote: null as null | boolean,
    };
  },

  mounted() {
    this.fetchNotes();
  },
  methods: {
    fetchNotes() {
      axios.get<Note[]>('/api/notes').then((response) => {
        this.notes = response.data;
      });
    },
    async deleteNote(id: number) {
      await axios.delete(`/api/notes/${id}`);
      this.fetchNotes()
    },
    closeModals() {
      this.noteToReplyId = null;
      this.noteToUpdate = null;
      this.createNote = null;
    },
    openCreateModal() {
      this.createNote = true;
    },
    openEditModal(note: Note) {
      this.noteToUpdate = note;
    },
    openReplyModal(parentId: number) {
      this.noteToReplyId = parentId;
    },
    showDeleteConfirmation(note: Note) {
      this.noteToDelete = note;
    },
    closeConfirmationModal() {
      this.noteToDelete = null;
    },
    isReplyCollapsed(index: number, note: Note): boolean {
      return !this.expandedNotes.includes(note.id) && note.replies?.length > 2 && index !== note.replies?.length - 1;
    },
    shouldShowMoreButton(note: Note) {
      return note.replies?.length > 2 && !this.expandedNotes.includes(note.id);
    },
    showAllReplies(noteId: number) {
      this.expandedNotes.push(noteId);
    }
  }
});
</script>

<style scoped lang="scss">
@import '../assets/styles/_variables.scss';

.create-note-btn {
  box-shadow: 0 4px 4px 0 rgba(0, 0, 0, 0.25);
}

.notes-list {
  &, ul {
    list-style: none;
  }

  & > li {
    border-bottom: $content-border;
    padding: 24px;
  }

  .thread-btn {
    margin: 10px 45px;
  }

  .thread-line-extension {
    border-left: $content-border;
    margin: 10px 60px;
    height: 15px;
  }
}

.collapsed-reply {
  display: none;
}

</style>
