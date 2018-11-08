<?php
/**
 * opyright 2018-2019 Akaxin Group

 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License ata

 *   http://www.apache.org/licenses/LICENSE-2.0

 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace Zaly\Library;

use Zaly\Services\ConfigKey;

use Zaly\Encrypt\ZalyAes;
use Zaly\ZalyConfig;

class ZalyHelper
{
    CONST SUCCESS = "success";
    CONST FAILED  = "error";
    CONST SITE_MANAGER = "site_manager";
    CONST ADMIN_MANAGER = "admin_manager";


    /**
     * 解析获取proxyPluginPackage数据
     *
     * @author 尹少爷 2018.1.4
     *
     * @param string params
     *
     * @return array['data' => [], 'referer' => '', 'site_user_id' => '', 'req_time_ms' => '']
     *
     */
    /**
     * Generated from protobuf enum <code>CLIENT_VERSION = 0;</code>
     */

    public static function getDataFromProxy($params, $authKeyName = ZalyAes::ADMIN_AUTH_KEY)
    {
        $log     = \Zaly\ZalyLog::init();
        $authKey  = \Zaly\Encrypt\ZalyAes::getAuthKey($authKeyName);
        $logText = [
            'msg'    => 'get params from proxy',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            if(isset($authKey) && $authKey) {
                $params = \Zaly\Encrypt\ZalyAes::decrypt($authKey, $params);
            }
            $proxyPluginPackage = new \Zaly\Services\ProxyPluginPackage();
            $proxyPluginPackage->mergeFromString($params);
            $currentMapArr = $proxyPluginPackage->getPluginHeader();
            $referer    = "";
            $siteUserId = "";
            $pluginId   = "";
            $reqTimeMs  = "";
            foreach ($currentMapArr as $key => $val) {
                switch ($key) {
                    case 1:
                        $siteUserId = $val;
                        break;
                    case 3:
                        $referer = $val;
                        break;
                    case 4:
                        $reqTimeMs = $val;
                        break;
                    case 5:
                        $pluginId = $val;
                        break;
                }
            }
            $output  = [
                'error'        => ZalyHelper::SUCCESS,
                'data'         => json_decode($proxyPluginPackage->getdata(), true),
                'referer'      => $referer,
                'referer_data' => \Zaly\ZalyUrl::parseReferer($referer),
                'site_user_id' => $siteUserId,
                'req_time_ms'  => $reqTimeMs,
                'plugin_id'    => $pluginId,
            ];
            $log->info(['receive_data' => $output]);
            return $output;
        } catch (\Exception $e) {

            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            throw new \Exception($message);
        }
    }

    public static function getDataFromProxyForResponse($params, $authKeyName = ZalyAes::ADMIN_AUTH_KEY)
    {
        $log     = \Zaly\ZalyLog::init();
        $authKey  = \Zaly\Encrypt\ZalyAes::getAuthKey($authKeyName);
        $logText = [
            'msg'    => 'get params from proxy',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            if(isset($authKey) && $authKey) {
                $params = \Zaly\Encrypt\ZalyAes::decrypt($authKey, $params);
            }
            $proxyPluginPackage = new \Zaly\Services\ProxyPluginPackage();
            $proxyPluginPackage->mergeFromString($params);

            $errInfo = $proxyPluginPackage->getErrorInfo();
            if(!$errInfo) {
                throw new \Exception($errInfo);
            }
            $errCode = $errInfo->getCode();
            $errInfo = $errInfo->getInfo();
            if($errCode != ZalyHelper::SUCCESS) {
                throw new \Exception($errInfo);
            }

            $output = [
                'data'  => base64_decode($proxyPluginPackage->getdata()),
                'error' => ZalyHelper::SUCCESS,
            ];

            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['error' => ZalyHelper::FAILED, 'msg' => $e->getMessage()];
        }
    }

    /**
     * 生成proxyPackage数据
     *
     * @author 尹少爷 2018.1.4
     *
     * @param string params
     *
     * @return String encryptData
     *
     */
    public static function generateDataForProxy($siteUserId, $content, $authKeyName = ZalyAes::ADMIN_AUTH_KEY)
    {
        $log     = \Zaly\ZalyLog::init();
        $authKey  = \Zaly\Encrypt\ZalyAes::getAuthKey($authKeyName);

        $logText = [
            'msg'          => 'generate data for proxy',
            'method'       => __METHOD__,
            'params'       => base64_encode($content),
            'authkey_name' => $authKeyName,
            'site_user_id' => $siteUserId,
        ];
        try {
            $log->info($logText);
            $timeMs = time()*1000;
            $proxyPluginPackage = new \Zaly\Services\ProxyPluginPackage();
            $pluginHeader = [1 => $siteUserId, 4 => $timeMs];
            $proxyPluginPackage->setPluginHeader($pluginHeader);
            $proxyPluginPackage->setData(base64_encode($content));
            $proxyPluginPackage = $proxyPluginPackage->serializeToString();
            if(isset($authKey) && $authKey) {
                $proxyPluginPackage = \Zaly\Encrypt\ZalyAes::encrypt($authKey, $proxyPluginPackage);
            }
            return $proxyPluginPackage;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            throw new \Exception($message);
        }
    }

    //校验用户是不是管理员
    public static function judgeIsAdmin($params, $getConfigUrl)
    {
        $log     = \Zaly\ZalyLog::init();
        $logText = [
            'msg'    => 'judgment admin',
            'method' => __METHOD__,
            'params' => base64_encode($params)
        ];
        try {
            $log->info($logText);
            if ($params && strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
                $result = ZalyHelper::getDataFromProxy($params);
                if(!$result) {
                    throw new \Exception('decrypt data failed');
                }
                $siteUserId = $result['site_user_id'];
                $pluginId   = $result['plugin_id'];
            } elseif (!$params && strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') {
                $siteUserId = isset($_GET['siteUserId']) ? $_GET['siteUserId'] : '';
                $pluginId   = isset($_GET['plugin_id']) ? $_GET['plugin_id'] : '';
            }

            if (!isset($siteUserId) || !$siteUserId) {
                $log->info('no siteUserId, Permission denied');
                throw new \Exception('Permission denied');
            }

            $configReq = new \Zaly\Services\HaiSiteGetConfigRequest();
            $configReq = $configReq->serializeToString();
            $configReq = ZalyHelper::generateDataForProxy($siteUserId, $configReq);

            $curl   = \Zaly\ZalyCurl::init();
            $result = $curl->request('post', $getConfigUrl, $configReq, ["site-plugin-id" => $pluginId]);
            $result = ZalyHelper::getDataFromProxyForResponse($result);
            if ($result['error'] == 'error') {
                throw new \Exception('get data failed');
            }
            $data       = $result['data'];
            $configRep  = new \Zaly\Services\HaiSiteGetConfigResponse();
            $configRep->mergeFromString($data);
            $configObjs = $configRep->getSiteConfig();
            if (!$configObjs) {
                throw new \Exception('get config failed');
            }
            $configObjs = $configObjs->getSiteConfig();

            $adminId     = isset($configObjs[ConfigKey::SITE_ADMIN]) ? $configObjs[ConfigKey::SITE_ADMIN] : '' ;
            $siteManager = isset($configObjs[ConfigKey::SITE_MANAGER]) ? $configObjs[ConfigKey::SITE_MANAGER] : '' ;
            $siteManagers = explode(',' , $siteManager);
            if (($adminId == 'ZALY_SHAOYE') ||( $adminId === $siteUserId) ) {
                return ZalyHelper::ADMIN_MANAGER;
            }
            if(in_array($siteUserId, $siteManagers)) {
                return ZalyHelper::SITE_MANAGER;
            }
            return false;
        } catch (\Exception $ex) {
            $log->error($params);
            return false;
        }
    }
    /**
     * 查询当前站点的个人信息
     */
    public static function getUserInfoById($currentSiteUserId, $searchUserId, $originPluginId, $userInfoUrl, $authKeyName=ZalyAes::USER_SQUER_AUTH_KEY)
    {
        $log     = \Zaly\ZalyLog::init();
        $logText = [
            'msg'                  => 'search user info',
            'method'               => __METHOD__,
            'current_site_user_id' => $currentSiteUserId,
            'search_user_id'       => $searchUserId,
            'authkey_name'         => $authKeyName,
            'plugin_id'            => $originPluginId,
        ];
        try{
            $log->info($logText);
            $userProReq = new \Zaly\Services\HaiUserProfileRequest();
            $userProReq->setSiteUserId($searchUserId);
            $userProReq = $userProReq->serializeToString();
            $userProReq = ZalyHelper::generateDataForProxy($currentSiteUserId, $userProReq, $authKeyName);

            $log->info($userProReq);
            $curl    = \Zaly\ZalyCurl::init();

            $result  = $curl->request('post', $userInfoUrl, $userProReq, ["site-plugin-id" => $originPluginId]);
            if (!$result) {
                throw new \Exception('get member info failed');
            }
            $results = ZalyHelper::getDataFromProxyForResponse($result, $authKeyName);
            if (!$result || $results['error'] == 'error') {
                throw new \Exception('get member info failed');
            }
            $data = $results['data'];

            $userProRep = new \Zaly\Services\HaiUserProfileResponse();
            $userProRep->mergeFromString($data);
            $userInfo   = $userProRep->getUserProfile();
            $userInfos  = [];
            $userInfos['user_id']     = $userInfo->getSiteUserId();
            $userInfos['user_name']   = $userInfo->getUserName();
            $userInfos['user_photo']  = $userInfo->getUserPhoto();
            $userInfos['user_desc']   = $userInfo->getSelfIntroduce();
            $userInfos['user_status'] = $userInfo->getUserStatus();

            $log->info(['return_results' => $userInfos]);
            return $userInfos;
        } catch(\Exception $ex){
            $log->error($logText);
            throw new \Exception('get member info failed');
        }
    }
}
