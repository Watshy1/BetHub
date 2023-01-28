<?php

namespace App\Entity;

use App\Repository\ScoresRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoresRepository::class)]
class Scores
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $set1 = null;

    #[ORM\Column]
    private ?int $set2 = null;

    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Matches $Matches_id = null;

    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Players $Players_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSet1(): ?int
    {
        return $this->set1;
    }

    public function setSet1(int $set1): self
    {
        $this->set1 = $set1;

        return $this;
    }

    public function getSet2(): ?int
    {
        return $this->set2;
    }

    public function setSet2(int $set2): self
    {
        $this->set2 = $set2;

        return $this;
    }

    public function getMatchesId(): ?Matches
    {
        return $this->Matches_id;
    }

    public function setMatchesId(?Matches $Matches_id): self
    {
        $this->Matches_id = $Matches_id;

        return $this;
    }

    public function getPlayersId(): ?Players
    {
        return $this->Players_id;
    }

    public function setPlayersId(?Players $Players_id): self
    {
        $this->Players_id = $Players_id;

        return $this;
    }
}
