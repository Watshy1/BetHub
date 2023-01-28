<?php

namespace App\Entity;

use App\Repository\MatcheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatcheRepository::class)]
class Matche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $Player1_id = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Player $Player2_id = null;

    #[ORM\OneToMany(mappedBy: 'Matche_id', targetEntity: Score::class, orphanRemoval: true)]
    private Collection $scores;

    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayer1Id(): ?Player
    {
        return $this->Player1_id;
    }

    public function setPlayer1Id(?Player $Player1_id): self
    {
        $this->Player1_id = $Player1_id;

        return $this;
    }

    public function getPlayer2Id(): ?Player
    {
        return $this->Player2_id;
    }

    public function setPlayer2Id(?Player $Player2_id): self
    {
        $this->Player2_id = $Player2_id;

        return $this;
    }

    /**
     * @return Collection<int, Score>
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Score $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores->add($score);
            $score->setMatcheId($this);
        }

        return $this;
    }

    public function removeScore(Score $score): self
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getMatcheId() === $this) {
                $score->setMatcheId(null);
            }
        }

        return $this;
    }
}
