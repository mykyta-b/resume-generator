<?php
declare(strict_types=1);


namespace App\DTO;


class ResumeDTO
{
    /**
     * @var array
     */
    private array $errors = [];

    private UserDTO $user;
    private RepoListDTO $repos;

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param array $errors
     * @return ResumeDTO
     */
    public function setErrors(array $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    /**
     * @return UserDTO
     */
    public function getUser(): UserDTO
    {
        return $this->user;
    }

    /**
     * @param UserDTO $user
     * @return ResumeDTO
     */
    public function setUser(UserDTO $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return RepoListDTO
     */
    public function getRepos(): RepoListDTO
    {
        return $this->repos;
    }

    /**
     * @param RepoListDTO $repos
     * @return ResumeDTO
     */
    public function setRepos(RepoListDTO $repos): self
    {
        $this->repos = $repos;
        return $this;
    }
}
