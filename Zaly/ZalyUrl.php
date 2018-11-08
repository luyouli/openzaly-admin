<?php

namespace Zaly;

class ZalyUrl {

    public static $scheme = [
        "zaly",
        "zalys"
    ];
    public static $goto = "/goto";
    public static $defaultScheme = "zaly";

    public static function parseReferer($referer)
    {
        try{
            $urlParams = parse_url($referer);

            if(isset($urlParams['scheme']) && !in_array($urlParams['scheme'], self::$scheme)){
                return [];
            }
            if(!isset($urlParams['path']) && $urlParams['path'] != self::$goto) {
                return [];
            }
            $urlScheme = isset($urlParams['scheme']) ? $urlParams['scheme'] : self::$defaultScheme;
            $urlHost   = isset($urlParams['host'])?$urlParams['host']: '';
            $urlPort   = isset($urlParams['port'])? $urlParams['port'] : '';
            $urlPath   = isset($urlParams['path'])? $urlParams['path'] : '';
            $urlQuery  = isset($urlParams['query'])? $urlParams['query'] : '' ;
            parse_str($urlQuery, $urlQueryParams);

            $urlParams = [
                'scheme' => $urlScheme,
                'host'   => $urlHost,
                'port'   => $urlPort,
                'path'   => $urlPath,
                'query'  => $urlQueryParams
            ];

            return $urlParams;
        }catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
             error_log('when run Url, unexpected error :' . $message);
            return [];
        }
    }

}