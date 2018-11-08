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

use Zaly\Services\HaiPluginListRequest;
use Zaly\Services\HaiPluginListResponse;
use Zaly\Services\HaiPluginDeleteRequest;
use Zaly\Services\Plugin;
use Zaly\Services\PluginStatus;
use Zaly\Services\HaiPluginAddRequest;
use Zaly\Services\HaiPluginUpdateRequest;
use Zaly\Services\HaiPluginProfileRequest;
use Zaly\Services\HaiPluginProfileResponse;

use Zaly\ZalyCurl;
use Zaly\ZalyLog;
use Zaly\Library\ZalyHelper;

class ManagePlugin
{
    /**
     * 基本设置-获取插件列表
     *
     * @author 尹少爷 2018.1.11
     *
     * @param proto $result
     *
     */
    public static function pluginList($params, $pluginListUrl, $pageSize = 12)
    {
        $log     = ZalyLog::init();
        $loading = true;
        $logText = [
            'msg'    => 'get plugin list',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result     = ZalyHelper::getDataFromProxy($params);
            $siteUserId = isset($result['site_user_id']) ? $result['site_user_id']: '';
            $page       = isset($result['data']['page']) ? $result['data']['page'] : 1;
            $pluginId   = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $pluginReq = new HaiPluginListRequest();
            $pluginReq->setPageNumber($page);
            $pluginReq->setPageSize($pageSize);
            $pluginReq = $pluginReq->serializeToString();
            $pluginReq = ZalyHelper::generateDataForProxy($siteUserId, $pluginReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $pluginListUrl, $pluginReq, ["site-plugin-id" => $pluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get plugin list failed');
            }
            $data        = $results['data'];
            $pluginRep   = new HaiPluginListResponse();
            $pluginRep->mergeFromString($data);
            $pluginLists = $pluginRep->getPlugin();

            $lists = [];
            foreach ($pluginLists as $key => $plugin) {
                $lists[$key]['id']           = $plugin->getId();
                $lists[$key]['name']         = $plugin->getName();
                $lists[$key]['url_page']     = $plugin->getUrlPage();
                $lists[$key]['url_api']      = $plugin->getApiUrl();
                $lists[$key]['auth_key']     = $plugin->getAuthKey();
                $lists[$key]['plugin_icon']  = $plugin->getIcon();
                $lists[$key]['position']     = $plugin->getPosition();
                $lists[$key]['order_num']    = $plugin->getOrder();
                $lists[$key]['display_mode'] = $plugin->getDisplayMode();
                $lists[$key]['per_status']   = $plugin->getPermissionStatus();
            }
            if (count($lists) >= 12) {
                $loading = false;
            }
            $output = ['results' => $lists, 'loading' => $loading];
            $log->info(['return_results'=> $output]);
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['results' => [], 'loading' => $loading];
        }
    }

    /**
     * 基本设置-删除插件
     *
     * @author 尹少爷 2018.1.11
     *
     * @param proto $result
     *
     */
    public static function deletePlugin($params, $delPluginUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'delete plugin',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id']: '';
            $pluginId       = isset($result['data']['plugin_id']) ? $result['data']['plugin_id'] : '';

            $delPluginReq = new HaiPluginDeleteRequest();
            $delPluginReq->setPluginId($pluginId);
            $delPluginReq = $delPluginReq->serializeToString();
            $delPluginReq = ZalyHelper::generateDataForProxy($siteUserId, $delPluginReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $delPluginUrl, $delPluginReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('delete plugin failed');
            }
            $log->info(['return_results' => 'success']);
            return 'success';
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }

    /**
     * 基本设置-更新插件
     *
     * @author 尹少爷 2018.1.11
     *
     * @param proto $result
     *
     */
    public static function updatePlugin($params, $updatePluginUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'update plugin',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);
            $log->info([$result]);
            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id']: '';
            $pluginId       = isset($result['data']['plugin_id']) ? $result['data']['plugin_id'] : '';
            $urlPage        = isset($result['data']['url_page']) ? $result['data']['url_page'] : '';
            $name           = isset($result['data']['name']) ? $result['data']['name'] : '';
            $apiUrl         = isset($result['data']['api_url'])? $result['data']['api_url'] :'';
            $pluginIcon     = isset($result['data']['plugin_icon']) ? $result['data']['plugin_icon'] : '';
            $position       = isset($result['data']['position']) ? $result['data']['position'] : '';
            $orderNum       = isset($result['data']['order_num']) ? $result['data']['order_num'] : 0;
            $perStatus      = isset($result['data']['per_status']) ? $result['data']['per_status'] : 0;
            $order          = isset($result['data']['order']) ? $result['data']['order'] : 0;
            $allowIp        = isset($result['data']['allow_ip']) ? $result['data']['allow_ip'] : "127.0.0.1";
            $allowIp        = str_replace('，',",", $allowIp);

            $plugin = new Plugin();
            $plugin->setPosition($position);
            $plugin->setId($pluginId);
            $plugin->setName($name);
            $plugin->setUrlPage($urlPage);
            $plugin->setApiUrl($apiUrl);
            $plugin->setIcon($pluginIcon);
            $plugin->setOrder($orderNum);
            $plugin->setPermissionStatus($perStatus);
            $plugin->setOrder($order);
            $plugin->setAllowedIp($allowIp);

            $upPluginReq = new HaiPluginUpdateRequest();
            $upPluginReq->setPlugin($plugin);
            $upPluginReq = $upPluginReq->serializeToString();
            $upPluginReq = ZalyHelper::generateDataForProxy($siteUserId, $upPluginReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $updatePluginUrl, $upPluginReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('update plugin info failed');
            }
            $log->info(['return_results' => 'success']);
            return 'success';
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }
    /**
     * 基本设置-添加插件
     *
     * @author 尹少爷 2018.1.11
     *
     * @param proto $result
     *
     */
    public static function addPlugin($params, $pluginAddUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'add plugin',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id']: '';
            $name           = isset($result['data']['name']) ? $result['data']['name'] : '';
            $urlPage        = isset($result['data']['url_page']) ? $result['data']['url_page'] : '';
            $apiUrl         = isset($result['data']['api_url']) ? $result['data']['api_url'] : '';
            $pluginIcon     = isset($result['data']['plugin_icon']) ? $result['data']['plugin_icon'] : '';
            $perStatus      = isset($result['data']['per_status']) ? $result['data']['per_status'] : 0;
            $position       = isset($result['data']['position']) ? $result['data']['position'] : 0;
            $order          = isset($result['data']['order']) ? $result['data']['order'] : 0;
            $allowIp        = isset($result['data']['allow_ip']) ? $result['data']['allow_ip'] : "127.0.0.1";

            $allowIp = str_replace('，',",", $allowIp);
            $plugin = new Plugin();
            $plugin->setName($name);
            $plugin->setUrlPage($urlPage);
            $plugin->setApiUrl($apiUrl);
            $plugin->setIcon($pluginIcon);
            $plugin->setPosition($position);
            $plugin->setPermissionStatus($perStatus);
            $plugin->setOrder($order);
            $plugin->setAllowedIp($allowIp);

            $pluginAddReq = new HaiPluginAddRequest();
            $pluginAddReq->setPlugin($plugin);
            $pluginAddReq = $pluginAddReq->serializeToString();
            $pluginAddReq = ZalyHelper::generateDataForProxy($siteUserId, $pluginAddReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $pluginAddUrl, $pluginAddReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('添加插件失败');
            }
            $log->info(['return_results' => $results]);
            return 'success';
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }
    /**
     * 基本设置-获取插件信息
     *
     * @author 尹少爷 2018.1.11
     *
     * @param proto $result
     *
     */
    public static function pluginInfo($params, $pluginInfoUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'get plugin info',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id']: '';
            $pluginId       = isset($result['data']['plugin_id']) ? $result['data']['plugin_id'] : '';

            $pluginInfoReq = new HaiPluginProfileRequest();
            $pluginInfoReq->setPluginId($pluginId);
            $pluginInfoReq = $pluginInfoReq->serializeToString();
            $pluginInfoReq = ZalyHelper::generateDataForProxy($siteUserId, $pluginInfoReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $pluginInfoUrl, $pluginInfoReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get plugin info failed');
            }
            $data          = $results['data'];
            $pluginInfoRep = new HaiPluginProfileResponse();
            $pluginInfoRep->mergeFromString($data);
            $pluginInfo    = $pluginInfoRep->getPlugin();

            $lists = [];
            $lists['id']          = $pluginInfo->getId();
            $lists['name']        = $pluginInfo->getName();
            $lists['url_page']    = $pluginInfo->getUrlPage();
            $lists['api_url']     = $pluginInfo->getApiUrl();
            $lists['plugin_icon'] = $pluginInfo->getIcon();
            $lists['per_status']  = $pluginInfo->getPermissionStatus();
            $lists['position']    = $pluginInfo->getPosition();
            $lists['order']       = $pluginInfo->getOrder();
            $lists['allow_ip']    = $pluginInfo->getAllowedIp();

            $log->info(['return_results' => $lists]);
            return $lists;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return [];
        }
    }
}
