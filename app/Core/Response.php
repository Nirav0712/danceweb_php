<?php

namespace App\Core;

class Response
{
    protected int $statusCode = 200;
    protected array $headers = [];
    protected string $content = '';
    protected ?string $redirectUrl = null;

    public function __construct()
    {
        $this->headers = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'SAMEORIGIN',
            'Referrer-Policy' => 'strict-origin-when-cross-origin',
            'Permissions-Policy' => 'camera=(), microphone=(), geolocation=()',
        ];
    }

    public function status(int $code): self
    {
        $this->statusCode = $code;
        return $this;
    }

    public function getStatus(): int
    {
        return $this->statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function header(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }

    public function json(mixed $data, int $code = 200): self
    {
        $this->status($code);
        $this->header('Content-Type', 'application/json; charset=utf-8');
        $this->content = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return $this;
    }

    public function html(string $content, int $code = 200): self
    {
        $this->status($code);
        $this->header('Content-Type', 'text/html; charset=utf-8');
        $this->content = $content;
        return $this;
    }

    public function redirect(string $url, int $code = 302): self
    {
        $this->statusCode = $code;
        $this->redirectUrl = $url;
        $this->header('Location', $url);
        if (!headers_sent()) {
            http_response_code($code);
            header("Location: {$url}");
        }
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getBody(): string
    {
        return $this->content;
    }

    public function getRedirectUrl(): ?string
    {
        return $this->redirectUrl;
    }

    public function send(): void
    {
        if (!headers_sent()) {
            http_response_code($this->statusCode);
            foreach ($this->headers as $name => $value) {
                header("{$name}: {$value}");
            }
        }
        if ($this->redirectUrl) {
            exit;
        }
        echo $this->content;
    }
}
