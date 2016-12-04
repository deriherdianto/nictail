<?php
namespace System\Core;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use System\Core\AppContainer;

Abstract Class App   {
	use AppContainer;
	public $extends=[
		'place_before_navbar_menu'			=> '',
		'place_before_left_menu'			=> ''
	];
	protected $current_app;
	protected $render_merge=[];

	public function __construct() {
		// ---
		$app=explode('/',$this->config()['path']);
		$app=end($app);
		$this->current_app=$app;
		return $this;
	}

	public function appExec($controller,$arguments){
		return call_user_func_array($controller, $arguments);
	}

	public function show() {
		$twig=$this->container->get('twig.environment');
		$template=$this->config()['template'];
		if($template == "blank.twig") {
			return new Response($twig->render($template,$this->prepare('blank')));
		}
		$this->container->get('twig.loader')->addPath($this->config()['path'].'/template',$this->current_app);
		return new Response($twig->render('@'.$this->current_app.'/'.$template,$this->prepare()));
	}

	# @Return array
	private function prepare($blank="") {
		if(empty($blank)) {
			$this->container->get('app.asset-manager')->add(['global.css','/uikit/css/uikit.gradient.min.css','/uikit/css/components/sticky.min.css','jquery-2.2.3.min.js','/uikit/js/uikit.min.js','/uikit/js/components/sticky.min.js','global.js']);

			// Prepare
			$render=[
				'head_asset'	=>	$this->container->get('app.asset-manager')->load()
			];
			return array_merge($this->extends,$render,$this->render);
		}
		return $this->render;
	}

	abstract function config();
	abstract function render();
}
?>
