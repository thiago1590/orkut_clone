<?php

namespace App;

use MF\Init\Bootstrap;

class Route extends Bootstrap {

	protected function initRoutes() {

		$routes['home'] = array(
			'route' => '/',
			'controller' => 'indexController',
			'action' => 'index'
		);

		$routes['registrar'] = array(
			'route' => '/registrar',
			'controller' => 'indexController',
			'action' => 'registrar'
		);

		$routes['autenticar'] = array(
			'route' => '/autenticar',
			'controller' => 'AuthController',
			'action' => 'autenticar'
		);

		$routes['timeline'] = array(
			'route' => '/timeline',
			'controller' => 'AppController',
			'action' => 'timeline'
		);

		$routes['perfil'] = array(
			'route' => '/perfil',
			'controller' => 'AppController',
			'action' => 'perfil'
		);

		$routes['recados'] = array(
			'route' => '/recados',
			'controller' => 'AppController',
			'action' => 'recados'
		);

		$routes['amigos'] = array(
			'route' => '/amigos',
			'controller' => 'AppController',
			'action' => 'amigos'
		);

		$routes['comunidades'] = array(
			'route' => '/comunidades',
			'controller' => 'AppController',
			'action' => 'comunidades'
		);

		$routes['pesquisa_comunidade'] = array(
			'route' => '/pesquisa_comunidade',
			'controller' => 'AppController',
			'action' => 'pesquisa_comunidade'
		);


		$this->setRoutes($routes);
	}

}

?>