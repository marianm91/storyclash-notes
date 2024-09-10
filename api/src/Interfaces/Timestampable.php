<?php

namespace App\Interfaces;

interface Timestampable
{
    public function setCreatedAt(): void;
    public function setUpdatedAt(): void;
    public function getCreatedAt(): ?\DateTimeInterface;
    public function getUpdatedAt(): ?\DateTimeInterface;
}