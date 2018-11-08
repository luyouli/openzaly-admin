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

use Zaly\Services\HaiUserRelationListRequest;
use Zaly\Services\HaiUserRelationListResponse;
use Zaly\Library\ZalyHelper;
use Zaly\ZalyCurl;
use Zaly\ZalyLog;
use Zaly\Encrypt\ZalyAes;

class SiteMemberLists
{

    /**
     * 站点广场 获取用户数据
     *
     * @author 尹少爷 2017.12.27
     *
     * @param string siteUserId 站点用户请求id
     * @param string getMembersUrl 站点地址
     * @param string page 站点地址
     * @param string pageSize 站点地址
     *
     * @return array
     */
    public static function getMembersList($params, $getMembersUrl = '', $pageSize = 20)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'          => "get site member list",
            'method'       => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params, ZalyAes::USER_SQUER_AUTH_KEY);

            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $page           = isset($result['data']['page']) ? $result['data']['page'] : 1;

            $reqMemberLists = new HaiUserRelationListRequest();
            $reqMemberLists->setPageNumber($page);
            $reqMemberLists->setPageSize($pageSize);
            $msgPacked = $reqMemberLists->serializeToString();
            $msgPacked = ZalyHelper::generateDataForProxy($siteUserId, $msgPacked, ZalyAes::USER_SQUER_AUTH_KEY);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $getMembersUrl, $msgPacked, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result,ZalyAes::USER_SQUER_AUTH_KEY);

            $output  = [];
            $loading = true;
            if ($results['error'] !== 'success') {
                throw new \Exception("请求失败");
            }
            $data = $results['data'];
            $response  = new HaiUserRelationListResponse();
            $response->mergeFromString($data);
            $userInfos = $response->getUserProfile();

            if ($userInfos) {
                foreach ($userInfos as $key => $userInfo) {
                    $output[$key]['site_user_relation'] = $userInfo->getRelation();
                    $userInfo = $userInfo->getProfile();
                    $output[$key]['site_user_id']    = $userInfo->getSiteUserId();
                    $output[$key]['site_user_name']  = $userInfo->getUserName();
                    $output[$key]['site_user_photo'] = $userInfo->getUserPhoto();
                }
            }
            if (count($output) >= 12) {
                $loading = false;
            }
            $output = ["error" => "success", "data" => $output, "loading" => $loading, 'current_site_user_id' => $siteUserId, 'origin_plugin_id' => $originPluginId ];
            $log->info(['return_results' => $output]);
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ["error" => "error", "data" => [], "loading" => false, 'current_site_user_id' => '','origin_plugin_id' => ''];
        }
    }
    /**
     * 用户广场-查看自己的用户信息
     *
     * @author 尹少爷 2018.02.23
     *
     * @param proto $result
     *
     */
    public static function getSiteMemberInfo($currentSiteUserId,  $searchUserId, $originPluginId, $userInfoUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'                  => "get member info",
            'method'               => __METHOD__,
            'current_site_user_id' => $currentSiteUserId,
            'search_user_id'       => $searchUserId,
        ];
        try {
            $log->info($logText);
            $userInfos = ZalyHelper::getUserInfoById($currentSiteUserId, $searchUserId, $originPluginId, $userInfoUrl,ZalyAes::USER_SQUER_AUTH_KEY);
            $log->info(['return_results' => $userInfos]);
            return $userInfos;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return [];
        }
    }
}
