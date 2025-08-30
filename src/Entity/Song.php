<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\SongRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SongRepository::class)]
class Song
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 180)]
    private ?string $title = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $originalArtist = null;

    #[Assert\Url]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $referenceUrl = null;

    public function __toString(): string
    {
        $title = $this->title ?? '';
        $artist = $this->originalArtist;

        if ($title !== '' && $artist !== null && $artist !== '') {
            return sprintf('%s (%s)', $title, $artist);
        }

        return $title !== '' ? $title : sprintf('Song#%d', $this->id ?? 0);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getOriginalArtist(): ?string
    {
        return $this->originalArtist;
    }

    public function setOriginalArtist(?string $originalArtist): self
    {
        $this->originalArtist = $originalArtist;

        return $this;
    }

    public function getReferenceUrl(): ?string
    {
        return $this->referenceUrl;
    }

    public function setReferenceUrl(?string $referenceUrl): self
    {
        $this->referenceUrl = $referenceUrl;

        return $this;
    }
}