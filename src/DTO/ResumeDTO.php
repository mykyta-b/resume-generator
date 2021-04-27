<?php
declare(strict_types=1);


namespace App\DTO;


class ResumeDTO
{
    /**
     * @var string
     */
    private string $userName;

    /**
     * @var array
     */
    private array $errors = [];

    private UserDTO $user;
    private RepoListDTO $repos;

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @param string $userName
     * @return ResumeDTO
     */
    public function setUserName(string $userName): self
    {
        $this->userName = $userName;
        return $this;
    }

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
