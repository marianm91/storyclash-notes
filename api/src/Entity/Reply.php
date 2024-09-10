<?php

namespace App\Entity;

use App\Repository\ReplyRepository;
use Doctrine\ORM\Mapping as ORM;
#[ORM\Entity(repositoryClass: ReplyRepository::class)]
class Reply extends Post
{
    #[ORM\ManyToOne(targetEntity:Note::class, inversedBy:'replies')]
    #[ORM\JoinColumn(nullable:true, onDelete:'CASCADE')]
    private Note $parentNote;

    public function setParentNote(Note $parentNote): void
    {
        $this->parentNote = $parentNote;
    }

    public function getParentNote(): Note
    {
        return $this->parentNote;
    }
}