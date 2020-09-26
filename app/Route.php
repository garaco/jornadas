<?php

namespace App;

class Route{
    public function run(){
        $route = array(
            //url
          ['url' => '/', 	        						'ctrl' => 'AuthController@index', 						'type' => 'guest'],

          ['url' => 'login', 						'ctrl' => 'AuthController@index', 						      'type' => 'guest'],

          ['url' => 'home',					    'ctrl' => 'homeController@index',	    				      'type' => 'admin,vendedor'],

           ['url' => 'usuarios',					    'ctrl' => 'usuariosController@index',	    				'type' => 'admin'],
  			   ['url' => 'usuarios/save',				'ctrl' => 'usuariosController@save',	    					'type' => 'admin'],
           ['url' => 'usuarios/del',				    'ctrl' => 'usuariosController@del',  						'type' => 'admin'],

           ['url' => 'empleados',					    'ctrl' => 'empleadosController@index',	    				'type' => 'admin'],
  			   ['url' => 'empleados/save',				'ctrl' => 'empleadosController@save',	    					'type' => 'admin'],
           ['url' => 'empleados/del',				    'ctrl' => 'empleadosController@del',  						'type' => 'admin'],

           ['url' => 'logout', 					        'ctrl' => 'AuthController@logout', 					    	'type' => 'admin'],
    		   ['url' => 'auth', 						        'ctrl' => 'AuthController@login', 				    		'type' => 'admin'],

           ['url' => 'visualiza',					    'ctrl' => 'VisualizaController@index',	    				'type' => 'admin,vendedor'],

           ['url' => 'informe', 					        	'ctrl' => 'InformacionController@index',		    			'type' => 'admin,vendedor'],
           ['url' => 'grafico', 					        	'ctrl' => 'InformacionController@informe',		    			'type' => 'admin,vendedor'],

          ['url' => '404', 					        	'ctrl' => 'ErrorController@error404',		    			'type' => 'guest'],
			    ['url' => '403', 						        'ctrl' => 'ErrorController@error403', 	    				'type' => 'guest']
        );
        return $route;
    }
}
