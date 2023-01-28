<?php

namespace App\Entity;

use App\Repository\ScoreRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScoreRepository::class)]
class Score
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
    private ?Matche $Matche = null;

    #[ORM\ManyToOne(inversedBy: 'scores')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $Player = null;

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

    public function getMatche(): ?Matche
    {
        return $this->Matche;
    }

    public function setMatche(?Matche $Matche): self
    {
        $this->Matche = $Matche;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->Player;
    }

    public function setPlayer(?Player $Player): self
    {
        $this->Player = $Player;

        return $this;
    }
}
