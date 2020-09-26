<?php

namespace App\Config;

use App\Route;

class Request {
    protected $req;
    protected $routes;
    protected $type;

    public function __construct() {
        $this->req      = isset($_GET['url']) ? $_GET['url']: null;
        $this->routes   = new Route();
    }

    public function request() {
        foreach ( $this->routes->run() as $route ) {
            if ( !isset($_GET['url'])) {
                $url    = '/';
                $ctrl   = $route['ctrl'];
                $type   = $route['type'];
                return compact('url', 'ctrl', 'type');
                break;
            } elseif ( strtolower($_GET['url']) == $route['url'] ) {
                $url    = $route['url'];
                $ctrl   = $route['ctrl'];
                $type   = $route['type'];
                return compact('url', 'ctrl', 'type');
                break;
            }
        }
    }

    public function valid() {
        if ( $this->request() == null ) {
            return false;
        } else { 
            return true;
        }
    }

    public function resolve() {
        $req = $this->request();
        if ( $this->valid() ) {
            $url    = $req['url'];
            $ctrl   = $req['ctrl'];
            $type   = $req['type'];
            return compact('url', 'ctrl', 'type');
        } else {
            $url    = $req['not-found'];
            //$type   = $req['type'];
            $ctrl   = "ErrorController@error404";
            $type	= "guest";
			return compact('url', 'ctrl', 'type');
        }
    }
}