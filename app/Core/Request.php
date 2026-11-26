<?php

namespace App\Core;

class Request
{
    protected string $method;
    protected string $uri;
    protected array $params;
    protected array $body;
    protected array $server;
    protected array $files;
    protected array $routeParams = [];

    public function __construct(array $query = [], array $body = [], array $server = [])
    {
        $this->server = !empty($server) ? array_merge($_SERVER, $server) : $_SERVER;
        $this->method = strtoupper($this->server['REQUEST_METHOD'] ?? 'GET');
        
        // Handle method override for forms
        if ($this->method === 'POST' && isset($_POST['_method'])) {
            $this->method = strtoupper($_POST['_method']);
        }

        $uri = $this->server['REQUEST_URI'] ?? '/';
        $uri = explode('?', $uri)[0];
        $this->uri = '/' . trim($uri, '/');
        if ($this->uri !== '/' && str_ends_with($this->uri, '/')) {
            $this->uri = rtrim($this->uri, '/');
        }

        $this->params = !empty($query) ? $query : $_GET;
        $this->body = !empty($body) ? $body : $_POST;
        $this->files = $_FILES;

        // JSON body support
        $contentType = $this->server['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $raw = file_get_contents('php://input');
            $data = json_decode($raw, true);
            if (is_array($data)) {
                $this->body = array_merge($this->body, $data);
            }
        }
    }

    public function method(): string
    {
        return $this->method;
    }

    public function uri(): string
    {
        return $this->uri;
    }

    public function query(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $default;
    }

    public function post(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $default;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    public function body(?string $key = null, mixed $default = null): mixed
    {
        if ($key === null) {
            return $this->body;
        }
        return $this->body[$key] ?? $default;
    }

    public function all(): array
    {
        return array_merge($this->params, $this->body);
    }

    public function setRouteParams(array $params): void
    {
        $this->routeParams = $params;
    }

    public function param(string $key, mixed $default = null): mixed
    {
        return $this->routeParams[$key] ?? $default;
    }

    public function getParam(string $key, mixed $default = null): mixed
    {
        return $this->params[$key] ?? $this->body[$key] ?? $this->routeParams[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->params[$key] ?? $this->routeParams[$key] ?? $default;
    }

    public function ip(): string
    {
        return $this->server['HTTP_X_FORWARDED_FOR'] ?? $this->server['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    public function header(string $key, mixed $default = null): mixed
    {
        $normalized = 'HTTP_' . strtoupper(str_replace('-', '_', $key));
        if (isset($this->server[$normalized])) {
            return $this->server[$normalized];
        }
        $direct = strtoupper(str_replace('-', '_', $key));
        if (isset($this->server[$direct])) {
            return $this->server[$direct];
        }
        return $default;
    }

    public function isAjax(): bool
    {
        return strtolower((string)$this->header('X-Requested-With', '')) === 'xmlhttprequest'
            || str_contains((string)($this->server['HTTP_ACCEPT'] ?? ''), 'application/json');
    }
}
