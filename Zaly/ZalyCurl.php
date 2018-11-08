<?php
namespace Zaly;
/**
 * 处理CurL请求数据
 *
 * @author 尹少爷 2017.12.22
 */
class ZalyCurl
{
    protected $_curlObj = '';

    protected $_bodyContent = '';

    public static $instance = '';

    protected function __construct()
    {

    }
    public static function init()
    {
        if(!self::$instance) {
            self::$instance = new ZalyCurl();
        }
        return self::$instance;
    }
    /**
     * 发送curl请求
     *
     * @author 尹少爷 2017.12.22
     *
     * @param string method
     * @param string url
     * @param array params
     * @param array headers
     *
     * @return bool|mix
     */
    public  function request($method, $url, $params = [], $headers = [])
    {
       try{
            $this->_curlObj = curl_init();
            $this->_getRequestParams($params);
            $this->_setHeader($headers);
            $this->setRequestMethod($method);
            curl_setopt($this->_curlObj, CURLOPT_URL, $url);
            if (($resp = curl_exec($this->_curlObj)) === false) {
                return false;
            }
            curl_close($this->_curlObj);
            return $resp;
       }catch(\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            // error_log('when run Router, unexpected error :' . $message);
       }
    }

    protected function setRequestMethod($method)
    {
        switch (strtoupper($method)) {
            case 'HEAD':
                curl_setopt($this->_curlObj, CURLOPT_NOBODY, true);
                break;
            case 'GET':
                curl_setopt($this->_curlObj, CURLOPT_HTTPGET, true);
                break;
            case 'POST':
                curl_setopt($this->_curlObj, CURLOPT_HEADER, false);
                curl_setopt($this->_curlObj, CURLOPT_NOBODY, false);
                curl_setopt($this->_curlObj, CURLOPT_POST, true);
                curl_setopt($this->_curlObj, CURLOPT_POSTFIELDS, $this->_bodyContent);
                curl_setopt($this->_curlObj, CURLOPT_RETURNTRANSFER, true);
                break;
            default:
                curl_setopt($this->_curlObj, CURLOPT_HTTPGET, true);
        }
    }

    protected  function _getRequestParams($params)
    {
        if (empty($params)) {
            return '';
        }
        $this->_bodyContent = $params;
        if (is_array($params)) {
            $this->_bodyContent = http_build_query($params, '', '&');
        }
    }

    protected function _setHeader($baseHeaders)
    {
        $headers = array();
        if(!$baseHeaders) {
            curl_setopt($this->_curlObj, CURLOPT_HEADER, 0);
            return false;
        }
        foreach ($baseHeaders as $key => $value) {
            $headers[] = $key.': '.$value;
        }
        curl_setopt($this->_curlObj, CURLOPT_HEADER, 1);
        curl_setopt($this->_curlObj, CURLOPT_HTTPHEADER, $headers);
    }
}
