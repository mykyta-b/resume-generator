<?php
declare(strict_types=1);


namespace App\DTO;

use Symfony\Component\Serializer\Annotation\SerializedName;

class RepoDTO
{
    /**
     * @var string|null
     */
    private ?string $language = '';

    /**
     * @var int|null
     */
    private ?int $size = 0;

    /**
     * @var \DateTime|null
     * @SerializedName ("created_at")
     */
    private ?\DateTime $created;

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     * @return RepoDTO
     */
    public function setLanguage(?string $language): self
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int|null $size
     * @return RepoDTO
     */
    public function setSize(?int $size): self
    {
        $this->size = $size;
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
     * @SerializedName ("created_at")
     * @return RepoDTO
     */
    public function setCreated(?\DateTime $created): self
    {
        $this->created = $created;
        return $this;
    }
}

