<?php
declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class UserDTO
{
    /**
     * @var string
     */
    private string $login;

    /**
     * @var string|null
     */
    private ?string $name = 'undefined';

    /**
     * @var int
     */
    private int $publicRepos = 0;

    /**
     * @var ?string
     */
    public ?string $website = '';

    /**
     * @var ?string
     */
    private ?string $location = '';

    /**
     * @var ?int
     */
    private ?int $followers = 0;

    /**
     * @var string|null
     */
    private ?string $avatar = null;

    /**
     * @var ?string
     */
    private ?string $message = '';

    /**
     * @var \DateTime|null
     * @SerializedName ("created_at")
     */
    private ?\DateTime $created;

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return UserDTO
     */
    public function setLogin(string $login): self
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     * @return UserDTO
     */
    public function setName(?string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int|null
     * @SerializedName ("public_repos")
     */
    public function getPublicRepos(): ?int
    {
        return $this->publicRepos;
    }

    /**
     * @param int $publicRepos
     * @SerializedName ("public_repos")
     * @return UserDTO
     */
    public function setPublicRepos(int $publicRepos): self
    {
        $this->publicRepos = $publicRepos;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getFollowers(): ?int
    {
        return $this->followers;
    }

    /**
     * @param int|null $followers
     * @return UserDTO
     */
    public function setFollowers(?int $followers): self
    {
        $this->followers = $followers;
        return $this;
    }

    /**
     * @SerializedName ("avatar_url")
     * @return string|null
     */
    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    /**
     * @param string|null $avatar
     * @SerializedName ("avatar_url")
     * @return UserDTO
     */
    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;
        return $this;
    }

    /**
     * @SerializedName ("blog")
     * @return string|null
     */
    public function getWebsite(): ?string
    {
        return $this->website;
    }

    /**
     * @param string|null $website
     * @SerializedName ("blog")
     * @return UserDTO
     */
    public function setWebsite(?string $website): self
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getLocation(): ?string
    {
        return $this->location;
    }

    /**
     * @param string|null $location
     * @return UserDTO
     */
    public function setLocation(?string $location): self
    {
        $this->location = $location;
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
     * @return UserDTO
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * @return \DateTime|null
     * @SerializedName ("created_at")
     */
    public function getCreated(): ?\DateTime
    {
        return $this->created;
    }

    /**
     * @param \DateTime|null $created
     * @return UserDTO
     * @SerializedName ("created_at")
     */
    public function setCreated(?\DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }
}

