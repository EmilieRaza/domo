<?php

namespace App\Entity;

use App\Repository\CaracteristiqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CaracteristiqueRepository::class)
 */
class Caracteristique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=TitleCaracteristique::class, inversedBy="caracteristiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $titleCaracteristique;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getTitleCaracteristique(): ?TitleCaracteristique
    {
        return $this->titleCaracteristique;
    }

    public function setTitleCaracteristique(?TitleCaracteristique $titleCaracteristique): self
    {
        $this->titleCaracteristique = $titleCaracteristique;

        return $this;
    }
}
