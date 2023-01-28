<?php

namespace App\Entity;

use App\Repository\PlayersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayersRepository::class)]
class Players
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $first_name = null;

    #[ORM\Column(length: 255)]
    private ?string $last_name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_of_birth = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $track_record = null;

    #[ORM\ManyToOne(inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Countries $Countries_id = null;

    #[ORM\OneToMany(mappedBy: 'Players1_id', targetEntity: Matches::class, orphanRemoval: true)]
    private Collection $matches;

    #[ORM\OneToMany(mappedBy: 'Players_id', targetEntity: Scores::class, orphanRemoval: true)]
    private Collection $scores;

    public function __construct()
    {
        $this->matches = new ArrayCollection();
        $this->scores = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(string $first_name): self
    {
        $this->first_name = $first_name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->last_name;
    }

    public function setLastName(string $last_name): self
    {
        $this->last_name = $last_name;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->date_of_birth;
    }

    public function setDateOfBirth(\DateTimeInterface $date_of_birth): self
    {
        $this->date_of_birth = $date_of_birth;

        return $this;
    }

    public function getTrackRecord(): ?string
    {
        return $this->track_record;
    }

    public function setTrackRecord(?string $track_record): self
    {
        $this->track_record = $track_record;

        return $this;
    }

    public function getCountriesId(): ?Countries
    {
        return $this->Countries_id;
    }

    public function setCountriesId(?Countries $Countries_id): self
    {
        $this->Countries_id = $Countries_id;

        return $this;
    }

    /**
     * @return Collection<int, Matches>
     */
    public function getMatches(): Collection
    {
        return $this->matches;
    }

    public function addMatch(Matches $match): self
    {
        if (!$this->matches->contains($match)) {
            $this->matches->add($match);
            $match->setPlayers1Id($this);
        }

        return $this;
    }

    public function removeMatch(Matches $match): self
    {
        if ($this->matches->removeElement($match)) {
            // set the owning side to null (unless already changed)
            if ($match->getPlayers1Id() === $this) {
                $match->setPlayers1Id(null);
            }
        }

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
            $score->setPlayersId($this);
        }

        return $this;
    }

    public function removeScore(Scores $score): self
    {
        if ($this->scores->removeElement($score)) {
            // set the owning side to null (unless already changed)
            if ($score->getPlayersId() === $this) {
                $score->setPlayersId(null);
            }
        }

        return $this;
    }
}
