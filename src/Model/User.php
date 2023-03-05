<?php

declare(strict_types=1);

namespace App\Model;

class User
{
    private string $id;
    private string $username;
    private string $email;

    public function __construct(string $id, string $username, string $email)
    {
        $this->id = $id;
        $this->username = $username;
        $this->email = $email;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}