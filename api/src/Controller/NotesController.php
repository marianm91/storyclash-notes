<?php

namespace App\Controller;

use App\Repository\NoteRepository;
use App\Service\NoteService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/notes', name: 'api_notes_')]
class NotesController extends AbstractController
{
    private const NOTE_CREATED = 'Note created!';
    private const NOTE_UPDATED = 'Note updated!';
    private const NOTE_DELETED = 'Note deleted!';
    private const NOTE_NOT_FOUND = 'Note not found!';

    #[Route('/', methods: ['GET'])]
    public function list(NoteService $notesService): JsonResponse
    {
        return new JsonResponse($notesService->getAllNotesJson(), 200, [], true);
    }

    #[Route('/', methods: ['POST'])]
    public function create(Request $request, NoteService $notesService): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $note = $notesService->createNote($data);

        return new JsonResponse(['status' => self::NOTE_CREATED, 'note' => $note], JsonResponse::HTTP_CREATED);
    }

    #[Route('/{id}', methods: ['PUT'])]
    public function update(Request $request, int $id, NoteRepository $noteRepository, NoteService $noteService): JsonResponse
    {
        $note = $noteRepository->find($id);

        if (!$note) {
            return new JsonResponse(['status' => self::NOTE_NOT_FOUND], JsonResponse::HTTP_NOT_FOUND);
        }

        $data = json_decode($request->getContent(), true);
        $noteService->updateNote($note, $data);

        return new JsonResponse(['status' => self::NOTE_UPDATED]);
    }

    #[Route('/{id}', methods: ['DELETE'])]
    public function delete(int $id, NoteRepository $noteRepository, NoteService $NotesService): JsonResponse
    {
        $note = $noteRepository->find($id);

        if (!$note) {
            return new JsonResponse(['status' => self::NOTE_NOT_FOUND], JsonResponse::HTTP_NOT_FOUND);
        }

        $NotesService->deleteNote($note);

        return new JsonResponse(['status' => self::NOTE_DELETED]);
    }
}
