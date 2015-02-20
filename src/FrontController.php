<?php

namespace FrontController;

class FrontController 
{
    private static $instance;
    
    /**
     * @var \Composer\Autoload\ClassLoader
     */
    private $loader;
    
    const PATH_ROUTES = 'routes';
    
    const PATH_CONTROLLERS = 'controllers';
    
    const PATH_MODULES = 'modules';
    
    private function __construct() 
    {}
    
    private function __clone()
    {}
    
    /**
     * 
     * @return self
     */
    public static function getInstance()
    {
        if (! self::$instance) {
            self::$instance = new self;
        }
        
        return self::$instance;
    }
    
    public function setLoader(\Composer\Autoload\ClassLoader $loader)
    {
        $this->loader = $loader;
        
        return $this;
    }
    
    /**
     * @return \Composer\Autoload\ClassLoader
     */
    protected function getLoader()
    {
        return $this->loader;
    }
    
    /**
     * @param string $path
     * @return \FrontController\FrontController
     */
    public function setRoutesPath($path)
    {
        $this->paths[self::PATH_ROUTES] = $path;
        
        return $this;
    }
    
    protected function getRoutesPath()
    {
        return $this->paths[self::PATH_ROUTES];
    }
    
    /**
     * @param string $path
     * @return \FrontController\FrontController
     */
    public function setControllersPath($path)
    {
        $this->paths[self::PATH_CONTROLLERS] = $path;
        
        return $this;
    }
    
    public function setNamespaces(array $namespaces)
    {
        foreach($namespaces as $rule => $paths) {
            $this->getLoader()->add($rule, $paths);
        }
        
        return $this;
    }
    
    public function init()
    {
        $route = $this->getRouter()->getRoute();
        
        $controller = $this->getController($route);
        
        $ordered_parameters = $this->getParameters($route);
        
        echo $controller->{$route['action']}(...$ordered_parameters);
    }
    
    protected function getController($route)
    {
        return new $route['controller'];
    }
    
    protected function getParameters($route)
    {
        $parameters = array_slice($route['matches'], 1);
        
        if (empty($route['order'])) {
            $ordered_parameters = $parameters;
        } else {
            $ordered_parameters = array_combine($route['order'], $parameters);

            ksort($ordered_parameters);
        }
        
        return $ordered_parameters;
    }
    
    protected function getRouter()
    {
        $router = \Router\Router::getInstance();
        $router->setRoutesPath($this->getRoutesPath());
        
        return $router;
    }
}
