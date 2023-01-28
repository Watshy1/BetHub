<?php

namespace App\Entity;

use App\Repository\MatchesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MatchesRepository::class)]
class Matches
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Players $Players1_id = null;

    #[ORM\ManyToOne(inversedBy: 'matches')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Players $Players2_id = null;

    #[ORM\OneToMany(mappedBy: 'Matches_id', targetEntity: Scores::class, orphanRemoval: true)]
    private Collection $scores;

    public function __construct()
    {
        $this->scores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlayers1Id(): ?Players
    {
        return $this->Players1_id;
    }

    public function setPlayers1Id(?Players $Players1_id): self
    {
        $this->Players1_id = $Players1_id;

        return $this;
    }

    public function getPlayers2Id(): ?Players
    {
        return $this->Players2_id;
    }

    public function setPlayers2Id(?Players $Players2_id): self
    {
        $this->Players2_id = $Players2_id;

        return $this;
    }

    /**
     * @return Collection<int, Scores>
     */
    public function getScores(): Collection
    {
        return $this->scores;
    }

    public function addScore(Scores $score): self
    {
        if (!$this->scores->contains($score)) {
            $this->scores->add($score);
            $score->setMatchesId($this);
        }

        return $this;
    }

    public function removeScore(Scores $score): self
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getMatchesId() === $this) {
                $score->setMatchesId(null);
            }
        }

        return $this;
    }
}
