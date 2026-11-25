<?php

namespace App\Core;

class Router
{
    protected array $routes = [];
    protected array $namedRoutes = [];
    protected array $middlewareGroups = [];

    public function get(string $path, mixed $handler, array $middleware = []): void
    {
        $this->addRoute('GET', $path, $handler, $middleware);
    }

    public function post(string $path, mixed $handler, array $middleware = []): void
    {
        $this->addRoute('POST', $path, $handler, $middleware);
    }

    public function put(string $path, mixed $handler, array $middleware = []): void
    {
        $this->addRoute('PUT', $path, $handler, $middleware);
    }

    public function delete(string $path, mixed $handler, array $middleware = []): void
    {
        $this->addRoute('DELETE', $path, $handler, $middleware);
    }

    protected function addRoute(string $method, string $path, mixed $handler, array $middleware = []): void
    {
        $normalizedPath = '/' . trim($path, '/');
        if ($normalizedPath !== '/' && str_ends_with($normalizedPath, '/')) {
            $normalizedPath = rtrim($normalizedPath, '/');
        }

        $this->routes[] = [
            'method' => strtoupper($method),
            'path' => $normalizedPath,
            'handler' => $handler,
            'middleware' => $middleware,
        ];
    }

    public function dispatch(Request $request): Response
    {
        $requestMethod = $request->method();
        $requestUri = $request->uri();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            $pattern = $this->compileRoutePattern($route['path']);
            if (preg_match($pattern, $requestUri, $matches)) {
                $params = [];
                foreach ($matches as $k => $v) {
                    if (is_string($k)) {
                        $params[$k] = $v;
                    }
                }
                $request->setRouteParams($params);

                // Run Middleware pipeline
                foreach ($route['middleware'] as $mw) {
                    $mwInstance = is_string($mw) ? new $mw() : $mw;
                    $result = $mwInstance->handle($request);
                    if ($result instanceof Response) {
                        return $result;
                    }
                }

                // Execute handler
                $handler = $route['handler'];
                if (is_callable($handler)) {
                    $res = call_user_func($handler, $request, $params);
                } elseif (is_array($handler) && count($handler) === 2) {
                    [$class, $method] = $handler;
                    $controller = new $class();
                    $res = call_user_func([$controller, $method], $request, $params);
                } else {
                    throw new \RuntimeException('Invalid route handler specified.');
                }

                if ($res instanceof Response) {
                    return $res;
                }
                if (is_string($res)) {
                    return (new Response())->html($res);
                }
                if (is_array($res)) {
                    return (new Response())->json($res);
                }
                return new Response();
            }
        }

        // 404 Not Found
        $response = new Response();
        $response->status(404);
        try {
            return $response->html(View::render('errors.404', ['title' => 'Page Not Found', 'uri' => $requestUri]), 404);
        } catch (\Throwable $e) {
            return $response->json(['error' => '404 Not Found', 'path' => $requestUri], 404);
        }
    }

    protected function compileRoutePattern(string $path): string
    {
        // Replace {param} with named regex capture groups
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $path);
        return '#^' . $pattern . '$#';
    }
}
