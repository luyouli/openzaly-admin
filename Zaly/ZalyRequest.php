<?php
namespace Zaly;

use Zaly\ZalyLog;

/**
 * 处理请求数据
 *
 * @author 尹少爷 2017.12.22
 */
class ZalyRequest
{
	public static $instance;
	protected $_log;

	protected function __construct()
	{
		$this->_log = ZalyLog::init();
	}
	public static function init()
	{
		if(!self::$instance) {
			self::$instance = new ZalyRequest();
		}
		return self::$instance;
	}
	public  function get($key)
	{
		return $this->getParams($key);
	}

	public  function all($key = 'nickname')
	{
		return $this->getParams($key);
	}

	public  function set()
	{

	}

	public function getParams($key = 'nickname')
	{
		$this->_log->info(['key' => $key]);
		$method = $this->getMethod();
		$this->_log->info(['key' => $key, 'method' => $method]);

	    if ($key === '') {
	    	return $method;
	    }

	    $result = isset($method[$key]) ? $method[$key] : '';
		$this->_log->info(['key' => $key, 'method' => $method, 'result' => $result]);
		return $result;
	}

	public function getMethod()
	{
		$method = strtoupper($_SERVER['REQUEST_METHOD']);

		switch ($method) {
			case 'GET':
				$method =  $_GET;
				# code...
				break;
			case 'POST':
				$method =  $_POST;
				# code...
				break;
		}
		return $method;
	}
}