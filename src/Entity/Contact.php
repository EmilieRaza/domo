<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact {
    
    /**
     *  @Assert\NotBlank(message="Le champ ne peut pas être vide!")
     */
    private $firstname;

    /**
     *  @Assert\NotBlank(message="Le champ ne peut pas être vide!")
     */
    private $lastname;

   /**
     *  @Assert\NotBlank(message="Le champ ne peut pas être vide!")
     *  @Assert\Email
     */
    private $email;

     /**
     *  @Assert\NotBlank(message="Le champ ne peut pas être vide!")
     *  @Assert\Regex("/^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$/")
     */
    private $phone;

    
    private $type;

     /**
     * @Assert\NotBlank(message="Le message ne peut pas être vide!")
     * @Assert\Length(min=10)
     */
    private $message;


    public function getFirstName(): ?string
    {
        return $this->firstname;
    }

    public function setFirstName(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastname;
    }

    public function setLastName(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }
    

}