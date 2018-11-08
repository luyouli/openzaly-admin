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

namespace Library;

use Zaly\Services\ProxyPackage;
use Zaly\Services\ConfigKey;
use Zaly\Services\PluginPackage;
use Zaly\Services\HaiSiteGetConfigRequest;
use Zaly\Services\HaiSiteUpdateConfigRequest;
use Zaly\Services\HaiSiteGetConfigResponse;
use Zaly\Services\SiteBackConfig;
use Zaly\ZalyCurl;
use Zaly\ZalyLog;
use Zaly\Library\ZalyHelper;

class ManageBasic
{
    /**
     * 基本设置-获取基础设置配置
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function getBasicConfig($params, $getConfigUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'get site basic',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result     = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $configReq      = new HaiSiteGetConfigRequest();
            $configReq      = $configReq->serializeToString();
            $configReq      = ZalyHelper::generateDataForProxy($siteUserId, $configReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $getConfigUrl, $configReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get data error');
            }
            $data = $results['data'];
            $siteConfig = [
                'site_ip'              => '',
                'site_port'            => '',
                'site_http_port'       => '',
                'site_http_address'    => '',
                'site_name'            => '',
                'site_logo'            => '',
                'site_desc'            => '',
                'site_reister_way'     => 0,
                'pic_size'             => 1,
                'pic_path'             => '/akaxin',
                'group_members_count'  => 100,
                'u2_encryption_status' => 1,
                'push_client_status'   => 0,
                'log_level'            => '',
                'subgenus_admin'       => ''
            ];
            if (isset($data)) {
                $configRep = new HaiSiteGetConfigResponse();
                $configRep->mergeFromString($data);
                $configObj = $configRep->getSiteConfig();
                if (!$configObj) {
                    $log->info(['not_results_return_default' => $siteConfig]);
                    return $siteConfig;
                }
                $configObjs = $configObj->getSiteConfig();
                $siteConfig = [
                    'site_ip'              => isset($configObjs[ConfigKey::SITE_ADDRESS]) ? $configObjs[ConfigKey::SITE_ADDRESS] : '',
                    'site_port'            => isset($configObjs[ConfigKey::SITE_PORT]) ? $configObjs[ConfigKey::SITE_PORT] : '',
                    'site_http_address'    => isset($configObjs[ConfigKey::SITE_HTTP_ADDRESS]) ? $configObjs[ConfigKey::SITE_HTTP_ADDRESS] : '',
                    'site_http_port'       => isset($configObjs[ConfigKey::SITE_HTTP_PORT]) ? $configObjs[ConfigKey::SITE_HTTP_PORT] : '',
                    'site_name'            => isset($configObjs[ConfigKey::SITE_NAME]) ? $configObjs[ConfigKey::SITE_NAME] : '',
                    'site_logo'            => isset($configObjs[ConfigKey::SITE_LOGO]) ? $configObjs[ConfigKey::SITE_LOGO] : '',
                    'site_desc'            => isset($configObjs[ConfigKey::SITE_INTRODUCTION]) ? $configObjs[ConfigKey::SITE_INTRODUCTION] : '',
                    'site_reister_way'     => isset($configObjs[ConfigKey::REGISTER_WAY]) ? $configObjs[ConfigKey::REGISTER_WAY] : 0,
                    'pic_size'             => isset($configObjs[ConfigKey::PIC_SIZE]) ? $configObjs[ConfigKey::PIC_SIZE] : 1,
                    'pic_path'             => isset($configObjs[ConfigKey::PIC_PATH]) ? $configObjs[ConfigKey::PIC_PATH] : '/akaxin',
                    'group_members_count'  => isset($configObjs[ConfigKey::GROUP_MEMBERS_COUNT]) ? $configObjs[ConfigKey::GROUP_MEMBERS_COUNT] : 100,
                    'u2_encryption_status' => isset($configObjs[ConfigKey::U2_ENCRYPTION_STATUS]) ? $configObjs[ConfigKey::U2_ENCRYPTION_STATUS] : 1,
                    'push_client_status'   => isset($configObjs[ConfigKey::PUSH_CLIENT_STATUS]) ? $configObjs[ConfigKey::PUSH_CLIENT_STATUS] : 0 ,
                    'log_level'            => isset($configObjs[ConfigKey::LOG_LEVEL]) ? $configObjs[ConfigKey::LOG_LEVEL] : "DEBUG",
                    'subgenus_admin'       =>isset($configObjs[ConfigKey::SITE_MANAGER]) ? $configObjs[ConfigKey::SITE_MANAGER] : '',
                ];
            }
            $log->info(['return_results' => $siteConfig]);
            return $siteConfig;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return false;
        }
    }
    /**
     * 基本设置-修改基础设置配置
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function setBasicConfig($params, $setSiteConfigUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'get site basic',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);
            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $data           = isset($result['data']) ? $result['data'] : [];
            $upData         = [];
            foreach ($data as $key => $val) {
                $val              = mb_convert_encoding($val, 'utf-8');
                $keyname          = constant(ConfigKey::class.'::'.strtoupper($key));
                if(strtoupper($key) === 'SITE_MANAGER') {
                    $val = str_replace('，', ',', $val);
                }
                $upData[$keyname] = $val;
            }
            $log->info(['update_data' => $upData]);
            $siteBackConfig = new SiteBackConfig();
            $siteBackConfig->setSiteConfig($upData);
            $configReq      = new HaiSiteUpdateConfigRequest();
            $configReq->setSiteConfig($siteBackConfig);
            $configReq      = $configReq->serializeToString();
            $configReq      = ZalyHelper::generateDataForProxy($siteUserId, $configReq);
            $log->info($configReq);
            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $setSiteConfigUrl, $configReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            $log->info('update site info ');
            if ($results['error'] == 'fail') {
                throw new \Exception('update site info failed');
            }
            $log->info(['return_results' => 'success']);
            return 'success';
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }
}
