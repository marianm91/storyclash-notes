<template>
  <div>
    <!-- Header -->
    <header>
      <div>
        <h1>Storyclash Notes</h1>
        <h3 class="text-gray">Manage and track your Creators in projects and analyze them.</h3>
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
              :actions="[
              { label: 'Edit', handler: () => openEditModal(note) },
              { label: 'Delete', handler: () => showDeleteConfirmation(note) }
            ]"
          />
          <button v-if="shouldShowMoreButton(note)"
                  class="btn thread-btn"
                  @click="showAllReplies(note.id)">
            Show {{ extraRepliesCount(note) }} more replies
          </button>
          <div v-if="shouldShowMoreButton(note)" class="thread-extension"></div>
          <ul v-if="note.replies">
            <li v-for="(reply, index) in note.replies" :key="reply.id"
                :class="{ 'collapsed-reply': !expandedNotes.includes(note.id) && isReplyHidden(index, note.replies.length) }">
              <NoteItem
                  :user="reply.user"
                  :content="reply.content"
                  :createdAt="reply.createdAt"
                  :actions="[]"
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

    <ConfirmationModal v-if="showConfirmationModal"
                       :note="noteToDelete"
                       action="Delete"
                       title="Are you sure you want to delete?"
                       message="By deleting this note all replies will be deleted too. This cannot be undone!"
                       @confirm="deleteNote"
                       @close="closeConfirmationModal"/>
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
      showConfirmationModal: false,
      noteToReplyId: null as null | number,
      noteToUpdate: null as null | Note,
      noteToDelete: null as null | Note,
      createNote: null as null | boolean,
    };
  },
  computed: {
    shouldShowMoreButton() {
      return (note: any) => {
        return note.replies && note.replies.length > 2 && !this.expandedNotes.includes(note.id);
      };
    },
    extraRepliesCount() {
      return (note: any) => {
        return note.replies.length - 1;
      };
    }
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
      this.showConfirmationModal = true;
    },
    closeConfirmationModal() {
      this.showConfirmationModal = false;
      this.noteToDelete = null;
    },
    isReplyHidden(index: number, totalReplies: number): boolean {
      return totalReplies > 2 && index !== totalReplies - 1;
    },
    showAllReplies(noteId: number) {
      this.expandedNotes.push(noteId);
    }
  }
});
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
  .thread-extension {
    border-left: $content-border;
    margin: 10px 60px;
    height: 15px;
  }
}

.collapsed-reply {
  display: none;
}

</style>
