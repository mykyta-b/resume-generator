<?php


namespace App\DTO\Helper;


trait BasicRequestDTO
{
    protected ?string $uri = null;
    protected string $method = 'GET';
    protected ?array $params = null;
    protected bool $redirects = true;
    protected ?array $allowedResponses = [];

    /**
     * @param string|null $uri
     * @return self
     */
    public function setUri(?string $uri): self
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUri(): ?string
    {
        return $this->uri;
    }

    /**
     * @param string $method
     * @return self
     */
    public function setMethod(string $method): self
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param array|null $params
     * @return self
     */
    public function setParams(?array $params): self
    {
        $this->params = $params;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getParams(): ?array
    {
        return $this->params;
    }

    /**
     * @param bool $redirects
     * @return self
     */
    public function setRedirects(bool $redirects): self
    {
        $this->redirects = $redirects;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRedirects(): bool
    {
        return $this->redirects;
    }

    /**
     * @param array|null $allowedResponses
     * @return self
     */
    public function setAllowedResponses(?array $allowedResponses): self
    {
        $this->allowedResponses = $allowedResponses;
        return $this;
    }

    /**
     * @return array|null
     */
    public function getAllowedResponses(): ?array
    {
        return $this->allowedResponses;
    }
}
