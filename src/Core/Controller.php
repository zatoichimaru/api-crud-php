<?php
namespace Core;

class Controller extends Core
{

    protected $view;

    public function __construct()
    {
        $this->view = new View();
    }
}