<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ODM\Document]
class User implements PasswordAuthenticatedUserInterface{
    #[ODM\Id]
    private $id;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    private string $name;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    private string $surname;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    private string $password;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    private string $address;

    #[ODM\Field(type: "string")]
    #[Assert\Email]
    private string $email;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    private string $phone;

    #[ODM\Field(type: "bool")]
    private bool $personalDataPermission;

    public function getId()
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): User
    {
        $this->surname = $surname;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): User
    {
        $this->address = $address;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): User
    {
        $this->phone = $phone;
        return $this;
    }

    public function isPersonalDataPermission(): bool
    {
        return $this->personalDataPermission;
    }

    public function setPersonalDataPermission(bool $personalDataPermission): User
    {
        $this->personalDataPermission = $personalDataPermission;
        return $this;
    }
}