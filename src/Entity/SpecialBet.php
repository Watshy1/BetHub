<?php

namespace App\Entity;

class SpecialBet {
    private $id;
    private $matche;
    private $player;
    private $scoreTeam1;
    private $scoreTeam2;
    private $createdAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
    }

    public function getId() {
        return $this->id;
    }

    public function getMatche() {
        return $this->matche;
    }

    public function setMatche($matche) {
        $this->matche = $matche;
        return $this;
    }

    public function getPlayer() {
        return $this->player;
    }

    public function setPlayer($player) {
        $this->player = $player;
        return $this;
    }
}
