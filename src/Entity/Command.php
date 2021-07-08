<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandRepository")
 */
class Command
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderKey;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $stripeKey;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandProduct", mappedBy="command", orphanRemoval=true)
     */
    private $commandProduct;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $billing;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->commandProduct = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderKey(): ?string
    {
        return $this->orderKey;
    }

    public function setOrderKey(string $orderKey): self
    {
        $this->orderKey = $orderKey;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipcode(): ?string
    {
        return $this->zipcode;
    }

    public function setZipcode(string $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStripeKey(): ?string
    {
        return $this->stripeKey;
    }

    public function setStripeKey(string $stripeKey): self
    {
        $this->stripeKey = $stripeKey;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|CommandProduct[]
     */
    public function getCommandProduct(): Collection
    {
        return $this->commandProduct;
    }

    public function addCommandProduct(CommandProduct $commandProduct): self
    {
        if (!$this->commandProduct->contains($commandProduct)) {
            $this->commandProduct[] = $commandProduct;
            $commandProduct->setCommand($this);
        }

        return $this;
    }

    public function removeCommandProduct(CommandProduct $commandProduct): self
    {
        if ($this->commandProduct->contains($commandProduct)) {
            $this->commandProduct->removeElement($commandProduct);
            // set the owning side to null (unless already changed)
            if ($commandProduct->getCommand() === $this) {
                $commandProduct->setCommand(null);
            }
        }

        return $this;
    }

    public function getTotal()
    {
        $total = 0;
        foreach( $this->commandProduct as $commandProduct){
            $total += $commandProduct->getPrice()*$commandProduct->getQuantity();
        }

        return $total;
    }

    public function getBilling(): ?string
    {
        return $this->billing;
    }

    public function setBilling(?string $billing): self
    {
        $this->billing = $billing;

        return $this;
    }
}
