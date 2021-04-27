<?php
declare(strict_types=1);


namespace App\DTO;


class ErrorDTO
{
    /**
     * @var ?string
     */
    private ?string $message = '';

    /**
     * @return string|null
     */
    public function getMessage(): ?string
    {
        return $this->message;
    }

    /**
     * @param string|null $message
     * @return ErrorDTO
     */
    public function setMessage(?string $message): self
    {
        $this->message = $message;
        return $this;
    }
}

