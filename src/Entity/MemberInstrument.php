<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\MemberInstrumentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MemberInstrumentRepository::class)]
#[ORM\Table(
    name: 'member_instrument',
    uniqueConstraints: [
        new ORM\UniqueConstraint(name: 'uniq_member_instrument', columns: ['member_id', 'instrument_id'])
    ]
)]
class MemberInstrument
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Member::class)]
    #[ORM\JoinColumn(name: 'member_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Member $member = null;

    #[ORM\ManyToOne(targetEntity: Instrument::class)]
    #[ORM\JoinColumn(name: 'instrument_id', referencedColumnName: 'id', nullable: false, onDelete: 'CASCADE')]
    private ?Instrument $instrument = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(Member $member): self
    {
        $this->member = $member;

        return $this;
    }

    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    public function setInstrument(Instrument $instrument): self
    {
        $this->instrument = $instrument;

        return $this;
    }
}