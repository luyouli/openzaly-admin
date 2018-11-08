<?php

namespace Zaly;

use Zaly\ZalyConfig;
use Zaly\Loader;

class ZalyApplication
{
	private $instace = [];
	private $controllerName = 'Manage';
	private $functionName = 'index';
	public static $loader;
	public static $config;
	public static $instance;

	public static function init()
	{
		try{
			spl_autoload_register(function($className){
				$className = str_replace('\\', '/', $className);
				$lists 	   = explode('Zaly/', $className);
				$fileName  = count($lists)>=2 ? dirname(__DIR__) . '/'  . $className . '.php' : dirname(__DIR__). '/' . $className . '.php'  ;
			    if (file_exists($fileName)) {
			        require $fileName;
			        return true;
			    }
			    return false;
			});

			if(!self::$instance) {
				self::$instance = new ZalyApplication();
			}

			return self::$instance;
		}catch(\Exception $ex) {
			$message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
			echo $message;
			// error_log('when run Router, unexpected error :' . $message);
		}
	}

	public function run()
	{
		try{
			$uri    = $_SERVER['REQUEST_URI'];
			$reqUri = array_filter(explode('?', $uri));
			$uris   = array_filter(explode('/', array_shift($reqUri)));
			$this->setControllerAndFunctionName($uris);
			$controllerName = $this->getControllerName();
			$functionName   = $this->getFunctionName();
			$controller     = new $controllerName();
			$controller->$functionName();
		}catch(\Exception $e) {
			$message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
			// error_log('when run Router, unexpected error :' . $message);
			echo $message;
		}
	}

	public function setControllerAndFunctionName($uris)
	{
		switch (count($uris)) {
				case '0' :
					$this->controllerName = self::$config['base']['controller_namespace'] . '\\' . $this->controllerName.self::$config['suffix']['controller_suffix'];
			 		$this->functionName   = $this->functionName.self::$config['suffix']['function_suffix'];
			 		break;
			 	case '1':
			 		# code...
			 		$this->controllerName = self::$config['base']['controller_namespace'] . '\\' . ucfirst(array_shift($uris)).self::$config['suffix']['controller_suffix'];
			 		$this->functionName   = $this->functionName.self::$config['suffix']['function_suffix'];
			 		break;
			 	case '2':
			 		# code...
			 		$this->controllerName = self::$config['base']['controller_namespace'] . '\\' . ucfirst(array_shift($uris)).self::$config['suffix']['controller_suffix'];
			 		$this->functionName   = ucfirst(array_shift($uris)).self::$config['suffix']['function_suffix'];
			 		break;
			}
		return true;
	}

	public function getControllerName()
	{
		return $this->controllerName;
	}

	public function getFunctionName()
	{
		return $this->functionName;
	}

	public function getConfig()
	{
		if(!self::$config) {
			self::$config = ZalyConfig::init();
		}
		return self::$config;
	}
}