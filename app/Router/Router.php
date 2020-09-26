<?php

namespace App\Router;

use App\Config\Request;
use App\Middleware\Middle;

class Router{
    protected $request;
    protected $url;
    protected $controller;
    protected $action;
    protected $type;
    protected $namespace;
    protected $middleware;

    public function __construct() {
        $this->request      = new Request();
        $this->middleware   = new Middle();
        $this->url          = $this->getUrl();
        $this->controller   = $this->getCtrl();
        $this->action       = $this->getAction();
		    $this->type         = $this->getType();
        $this->namespace    = "App\\Controllers\\";
        $this->middleware->isAuth($this->getType(), $this->url);
    }
    public function getUrl() {
        $url = $this->request->resolve();
        return $url['url'];
    }
    public function getCtrl() {
        $array = $this->request->resolve();
        $controller = explode( '@', $array['ctrl'] );
        return $controller[0];
    }
    public function getAction() {
        $array = $this->request->resolve();
        $action = explode( '@', $array['ctrl'] );
        return $action[1];
    }
    public function getType() {
        $type = $this->request->resolve();
        return $type['type'];
    }
    public function run() {
        $obj = $this->namespace.$this->controller;
        $obj = new $obj();
        return call_user_func( array($obj, $this->action) );
    }
}
