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

		$routes['pesquisar'] = array(
			'route' => '/pesquisar',
			'controller' => 'AppController',
			'action' => 'pesquisar'
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

		$routes['frase'] = array(
			'route' => '/frase',
			'controller' => 'AppController',
			'action' => 'frase'
		);

		$routes['setRecado'] = array(
			'route' => '/setRecado',
			'controller' => 'AppController',
			'action' => 'setRecado'
		);
		$routes['create_comunidade'] = array(
			'route' => '/create_comunidade',
			'controller' => 'ComunidadeController',
			'action' => 'createComunidade'
		);
		$routes['editar_perfil'] = array(
			'route' => '/editar_perfil',
			'controller' => 'AppController',
			'action' => 'editar_perfil'
		);
		$routes['addImage'] = array(
			'route' => '/addImage',
			'controller' => 'ImagesController',
			'action' => 'addImage'
		);
		$routes['acao'] = array(
			'route' => '/acao',
			'controller' => 'AppController',
			'action' => 'acao'
		);
		


		

		$this->setRoutes($routes);
	}

}

?>