<?php
namespace App\Asset;

Class Manager {
	protected $source=[];
	protected $source_from_app=[];
	protected $css,$js;
	public function __construct() {
		//--
	}

	public function add($source=[]) {
		$this->source=array_merge($source,$this->source);
	}

	public function addFrom($app,$source=[]) {
		if(array_key_exists($app, $this->source_from_app)) {
			$this->source_from_app[$app]=array_merge($source,$this->source_from_app[$app]);
		}
		else {
			$this->source_from_app[$app]=$source;
		}
	}

	public function importJs($js) {
		for($i=0;$i<count($js);$i++) {
			$this->js=$this->js."<script type='text/javascript' src='$js[$i]'></script>\n";
		}
	}

	public function load() {
		$readycss='';
		$readyjs='';
		$host=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'];
		for($i=0;$i<count($this->source);$i++) {
			if(strrchr($this->source[$i], '.') == '.css') {
				$readycss=$readycss."<link rel='stylesheet' type='text/css' href='".$host."/asset?source=".$this->source[$i]."'>\n";
			}
			if(strrchr($this->source[$i], '.') == '.js') {
				$readyjs=$readyjs."<script type='text/javascript' src='".$host."/asset?source=".$this->source[$i]."'></script>\n";
			}
		}
		foreach($this->source_from_app as $a => $b) {;
			for($i=0;$i<count($b);$i++) {
				if(strrchr($b[$i], '.') == '.css') {
					$readycss=$readycss."<link rel='stylesheet' type='text/css' href='".$host."/asset?source=".$b[$i]."&app=".$a."'>\n";
				}
				if(strrchr($b[$i], '.') == '.js') {
					$readyjs=$readyjs."<script type='text/javascript' src='".$host."/asset?source=".$b[$i]."&app=".$a."'></script>\n";
				}
			}
		}
		$this->css=$this->css.$readycss;
		$this->js=$this->js.$readyjs;
		return $this->css."\n".$this->js;
	}
}
?>