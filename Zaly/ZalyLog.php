<?php
/**
 * 记录log
 *
 * @author 尹少爷 2017.12.26
 */
namespace Zaly;

use Zaly\ZalyConfig;

class ZalyLog
{
	public static $instance;
	public static $config;
	protected  $_logPath = "/akaxin";
	protected  $_logType = 'INFO';
	protected function __construct()
	{
		self::$config = ZalyConfig::init();
	}

	public static function init()
	{
		if(!self::$instance) {
			self::$instance = new ZalyLog();
		}
		return self::$instance;
	}


	public function info($params = [])
	{
		$this->_logType = 'INFO';
		$this->writeLog($params);
	}

	public function error($params = [])
	{
		$this->_logType = 'ERROR';
		$this->writeLog($params);
	}

	public function notice($params = [])
	{
		$this->_logType = 'NOTICE';
		$this->writeLog($params);
	}

	protected function generateLogFile()
	{
		$this->getLogPath();
		$fileName = date('Y-m-d', time());
		return $this->_logPath.'/openzaly_admin'.$fileName.'.log';
	}

	protected function getLogPath()
	{
		//////$this->_logPath = isset(self::$config['base']['log_path']) ? self::$config['base']['log_path'] : dirname(__DIR__).'/logs/';
	}

	protected function writeLog($params)
	{
		try{
			if(!is_string($params)) {
				$params = json_encode($params);
			}
			$logContent ="【".$this->_logType."】【" . date('Y-m-d H:i:s', time()) . " 】【  " . $params . " 】";
			$fileName   = $this->generateLogFile();
			$handler    = fopen($fileName, 'a+');
			fwrite($handler, $logContent);
			fwrite($handler, "\n");
			fclose($handler);
		}catch(\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            error_log('when run Router, unexpected error :' . $message);
		}
	}
}