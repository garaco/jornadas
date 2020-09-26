<?php

function resource( $val ) {
    $dir = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $explode = explode("/", $dir);
    $url = "http://{$explode[0]}/{$explode[1]}/public/{$val}";
    return $url;
}

function route( $val ) {
    $dir = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $explode = explode("/", $dir);
	  $val = strtolower($val);
    $url = "http://{$explode[0]}/{$explode[1]}/{$val}";
    return $url;
}

function twig() {
    $loader     = new \Twig_Loader_Filesystem( 'app/Views' );
    $twig       = new \Twig_Environment( $loader );

    $resource   = new Twig_SimpleFunction( 'resource', function( $val ) {
        return resource( $val );
    } );

    $router     = new Twig_SimpleFunction( 'route', function( $val ) {
        return route( $val );
    } );

    $user_nick  = new Twig_SimpleFunction( 'user_nick', function() {
        return @$_SESSION['user'];
    } );

    $user_id  = new Twig_SimpleFunction( 'user_id', function() {
		return @$_SESSION['id'];
	} );

    $twig->addFunction( $resource );
    $twig->addFunction( $router );
    $twig->addFunction( $user_nick );
    $twig->addFunction( $user_id );
	return $twig;
}

function view( $val, $array = [] ) {
    $t = twig();
    return $t->render( $val, $array );
}
