<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Information
{
   
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

    /**
     *  @Assert\NotBlank(message="Le champ ne peut pas être vide!")
     */
    private $address;

     /**
     * @Assert\Regex("/^[0-9]{4,7}$/", message="Deux chiffres maximum")
     */
    private $zipcode;

    /**
     *  @Assert\NotBlank(message="Le champ ne peut pas être vide!")
     */
    private $city;


    private $code;

   
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }
}
