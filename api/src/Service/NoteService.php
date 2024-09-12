<?php

namespace App\Service;

use App\Entity\Note;
use App\Entity\Reply;
use App\Repository\NoteRepository;
use App\Repository\UserRepository;
use ArrayObject;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class NoteService
{
    private EntityManagerInterface $entityManager;
    private NoteRepository $noteRepository;
    private UserRepository $userRepository;
    private SerializerInterface $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        NoteRepository         $noteRepository,
        UserRepository         $userRepository,
        SerializerInterface    $serializer
    )
    {
        $this->entityManager = $entityManager;
        $this->noteRepository = $noteRepository;
        $this->userRepository = $userRepository;
        $this->serializer = $serializer;
    }

    public function getAllNotesJson(): array|string|int|float|bool|ArrayObject|null
    {
        $notes = $this->noteRepository->findAllOrderedByCreatedAtAndId();

        return $this->serializer->serialize($notes, 'json', [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
    }

    public function createNote(array $data): Note|Reply
    {
        $users = $this->userRepository->findAll();
        $randomUser = $users[array_rand($users)];

        if (isset($data['parent_id'])) {
            $note = new Reply();
            $parentNote = $this->noteRepository->find($data['parent_id']);
            $note->setParentNote($parentNote);
        } else {
            $note = new Note();
        }

        $note->setContent($data['content']);
        $note->setUser($randomUser);

        $this->entityManager->persist($note);
        $this->entityManager->flush();

        return $note;
    }

    public function updateNote(Note $note, array $data): void
    {
        $note->setContent($data['content']);

        $this->entityManager->flush();
    }

    public function deleteNote(Note $note): void
    {
        $this->entityManager->remove($note);
        $this->entityManager->flush();
    }
}
