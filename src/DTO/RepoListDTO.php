<?php
declare(strict_types=1);

namespace App\DTO;

class RepoListDTO
{
    public array $repos = [];

    /**
     * @var ?string
     */
    public ?string $message = '';

    /**
     * @return array
     */
    public function getRepos(): array
    {
        return $this->repos;
    }

    /**
     * @param array $repos
     * @return RepoListDTO
     */
    public function setRepos(array $repos): self
    {
        $this->repos = $repos;
        return $this;
    }

    /**
     * @param array $repos
     * @return RepoListDTO
     */
    public function addRepos(array $repos): self
    {
        $this->repos = array_merge($this->repos, $repos);
        return $this;
    }

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return RepoListDTO
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }
}

