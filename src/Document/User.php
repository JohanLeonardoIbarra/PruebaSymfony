<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Doctrine\Bundle\MongoDBBundle\Validator\Constraints\Unique;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

#[ODM\Document]
#[ODM\HasLifecycleCallbacks]
#[Unique('email')]
class User implements PasswordAuthenticatedUserInterface{
    #[ODM\Id]
    private $id;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    #[Groups(['Full'])]
    private string $name;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    #[Groups(['Full'])]

    private string $surname;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    #[Groups(['Full'])]
    private string $password;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    #[Groups(['Full'])]
    private string $address;

    #[ODM\Field(type: "string")]
    #[Assert\Email]
    #[Groups(['Full', 'Order'])]
    private string $email;

    #[ODM\Field(type: "string")]
    #[Assert\NotBlank]
    #[Groups(['Full'])]
    private string $phone;

    #[ODM\Field(type: "bool")]
    #[Assert\IsTrue]
    private bool $personalDataPermission;

    #[ODM\Field(type: "string")]
    #[Groups(['Full'])]
    private string $token;

    public function getToken(): string
    {
        return $this->token;
    }

    #[ODM\PrePersist]
    public function setToken(): void
    {
        $this->token = md5($this->getEmail());
    }

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