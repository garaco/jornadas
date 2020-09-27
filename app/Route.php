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

           ['url' => 'categorias',					    'ctrl' => 'categoriasController@index',	    				'type' => 'admin'],
  			   ['url' => 'categorias/save',				'ctrl' => 'categoriasController@save',	    					'type' => 'admin'],
           ['url' => 'categorias/del',				    'ctrl' => 'categoriasController@del',  						'type' => 'admin'],


           ['url' => 'horarios',					    'ctrl' => 'HorariosController@index',	    				'type' => 'admin'],
  			   ['url' => 'horarios/save',				'ctrl' => 'HorariosController@save',	    					'type' => 'admin'],
           ['url' => 'horarios/del',				    'ctrl' => 'HorariosController@del',  						'type' => 'admin'],

           ['url' => 'descansos',					    'ctrl' => 'DescansosController@index',	    				'type' => 'admin'],
          ['url' => 'descansos/save',				'ctrl' => 'DescansosController@save',	    					'type' => 'admin'],
           ['url' => 'descansos/del',				    'ctrl' => 'DescansosController@del',  						'type' => 'admin'],

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
