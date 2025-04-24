<?php
class Router {
    protected array $routes = [];

    protected function add($url, $controller, $method) {
        $this->routes[] = [
            'url' => $url,
            'Controller' => $controller,
            'method' => strtoupper($method)
        ];
        return $this;
    }

    public function get($url, $controller) {
        return $this->add($url, $controller, 'GET');
    }

    public function post($url, $controller) {
        return $this->add($url, $controller, 'POST');
    }

    public function put($url, $controller) {
        return $this->add($url, $controller, 'PUT');
    }

    public function delete($url, $controller) {
        return $this->add($url, $controller, 'DELETE');
    }

    public function patch($url, $controller) {
        return $this->add($url, $controller, 'PATCH');
    }

    public function route($uri, $method) {
        foreach ($this->routes as $route) {
            if ($route['method'] !== strtoupper($method)) {
                continue;
            }

            // Convert URL pattern to regex
            $pattern = str_replace('/', '\/', $route['url']);
            $pattern = preg_replace('#:([a-zA-Z0-9_]+)#', '(?<$1>[^/]+)', $pattern);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                $parameters = [];
                foreach ($matches as $key => $value) {
                    if (!is_int($key)) {
                        $parameters[$key] = $value;
                    }
                }

                // Ensure the controller exists
                [$class, $method] = $route['Controller'];
                if (!class_exists($class)) {
                    throw new Exception("Controller $class not found");
                }
                if (!method_exists($class, $method)) {
                    throw new Exception("Method $method not found in $class");
                }

                $instance = new $class();
                return $instance->$method($parameters);
            }
        }

        http_response_code(404);
        echo "Page not found";
        exit();
    }
}
?>
