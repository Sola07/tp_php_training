<?php

namespace App\Model;

class User {

    /**
     * @var string
     */
    private $username;
    /**
     * @var string
     */
    private $password;

    private $id;


    /**
     * Get the value of username
     */
    public function getUsername(): ?string
    {
        return $this->username;
    }

    /**
     * Set the value of username
     */
    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get the value of password
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set the value of password
     */
    public function setPassword(string $password):self
    {
        $this->password = $password;

        return $this;
    }

    public function setID (int $id): self {
      $this->id = $id;
      return $this;
    }

    public function getID (): ?int {
      return $this->id;
    }
}
