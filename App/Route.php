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
			'controller' => 'ComunidadeController',
			'action' => 'comunidades'
		);

		$routes['pesquisa_comunidade'] = array(
			'route' => '/pesquisa_comunidade',
			'controller' => 'ComunidadeController',
			'action' => 'pesquisa_comunidade'
		);

		$routes['comunidade_page'] = array(
			'route' => '/comunidade_page',
			'controller' => 'ComunidadeController',
			'action' => 'comunidade_page'
		);

		$routes['novo_topico'] = array(
			'route' => '/novo_topico',
			'controller' => 'ComunidadeController',
			'action' => 'novo_topico'
		);

		$routes['forum'] = array(
			'route' => '/forum',
			'controller' => 'ComunidadeController',
			'action' => 'forum'
		);

		$routes['topico'] = array(
			'route' => '/topico',
			'controller' => 'ComunidadeController',
			'action' => 'topico'
		);

		$routes['encontrar_amigos'] = array(
			'route' => '/encontrar_amigos',
			'controller' => 'AppController',
			'action' => 'encontrar_amigos'
		);

		$routes['sair'] = array(
			'route' => '/sair',
			'controller' => 'AuthController',
			'action' => 'sair'
		);


		$this->setRoutes($routes);
	}

}

?>