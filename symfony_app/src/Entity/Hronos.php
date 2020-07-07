<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\HronosRepository")
 */
class Hronos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $user_id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $date;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tih_fct;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $tih_teo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $free_money;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $hl;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getDate(): ?string
    {
        return $this->date;
    }

    public function setDate(string $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTihFct(): ?int
    {
        return $this->tih_fct;
    }

    public function setTihFct(?int $tih_fct): self
    {
        $this->tih_fct = $tih_fct;

        return $this;
    }

    public function getTihTeo(): ?int
    {
        return $this->tih_teo;
    }

    public function setTihTeo(?int $tih_teo): self
    {
        $this->tih_teo = $tih_teo;

        return $this;
    }

    public function getFreeMoney(): ?int
    {
        return $this->free_money;
    }

    public function setFreeMoney(?int $free_money): self
    {
        $this->free_money = $free_money;

        return $this;
    }

    public function getHl(): ?int
    {
        return $this->hl;
    }

    public function setHl(?int $hl): self
    {
        $this->hl = $hl;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
