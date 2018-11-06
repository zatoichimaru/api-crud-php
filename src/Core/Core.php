<?php
namespace Core;

class Core
{

    protected $controller;

    protected $action;

    protected $param;

    public function __construct()
    {
        $this->splitUrl();
        $this->invoke();
    }

    private function splitUrl()
    {
        $path = ltrim($_SERVER['REQUEST_URI'], '/');
        $elements = explode('/', $path);
        
        if (array_key_exists(1, $elements)) {
            $this->controller = ucfirst(strtolower($elements[1]));
        }
        
        if (array_key_exists(2, $elements)) {
            $this->action = strtolower($elements[2]);
        }
        
        if (array_key_exists(3, $elements)) {
            $this->param = $elements[3];
        }
    }

    private function invoke()
    {
        $class = "App\Controller\\" . $this->controller;
        $method = $this->action;
        $obj = new $class();
        $obj->$method();
    }
}