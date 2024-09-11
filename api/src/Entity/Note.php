<?php

namespace App\Entity;

use App\Repository\NoteRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NoteRepository::class)]
class Note extends Post
{
    #[ORM\OneToMany(targetEntity:Reply::class, mappedBy:'parentNote')]
    #[ORM\OrderBy(['createdAt' => 'ASC'])]
    private Collection $replies;

    public function getReplies(): Collection
    {
        return $this->replies;
    }

    public function setReplies(Collection $replies): void
    {
        $this->replies = $replies;
    }
}
