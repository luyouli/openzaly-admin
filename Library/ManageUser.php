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

use Zaly\Services\HaiUserSealUpRequest;
use Zaly\Services\HaiUserUpdateRequest;
use Zaly\Services\UserProfile;
use Zaly\Services\UserStatus;
use Zaly\Services\HaiUserListRequest;
use Zaly\Services\HaiUserListResponse;
use Zaly\ZalyCurl;
use Zaly\ZalyLog;
use Zaly\Library\ZalyHelper;
use Zaly\Encrypt\ZalyAes;

class ManageUser
{
    /**
     * 成员管理-站点成员管理
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function getSiteUsers($params, $getMembersUrl, $pageSize = 12)
    {
        $log    = ZalyLog::init();
        $logText = [
            'msg'    => 'get site members',
            'method' => __METHOD__,
            'params' =>base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $page           = isset($result['data']['page']) ? $result['data']['page'] : 1;

            $results = self::getMembersList($siteUserId, $originPluginId, $getMembersUrl, $page, $pageSize);
            $log->info(['return_results' => $results]);
            return $results;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return [];
        }
    }

    /**
     * 成员管理-站点成员管理-用户状态修改
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function sealupSiteUser($params, $sealupSiteUserUrl)
    {
        $log    = ZalyLog::init();
        $logText = [
            'msg'    => 'update site members status',
            'method' => __METHOD__,
            'params' =>base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);
            $sealupSiteUserId = isset($result['data']['site_user_id']) ? $result['data']['site_user_id'] : '';
            $siteUserId       = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId   = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $sealupUserReq = new HaiUserSealUpRequest();
            if ($result['data']['type'] == 'unfreeze') {
                $status = UserStatus::NORMAL;
            } else {
                $status = UserStatus::SEALUP;
            }
            $log->info("update user status is ".$status);
            $sealupUserReq->setStatus($status);
            $sealupUserReq->setSiteUserId($sealupSiteUserId);
            $sealupUserReq = $sealupUserReq->serializeToString();
            $sealupUserReq = ZalyHelper::generateDataForProxy($siteUserId, $sealupUserReq);

            $curl   = ZalyCurl::init();
            $result = $curl->request('post', $sealupSiteUserUrl, $sealupUserReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('update user info failed');
            }
            $log->info(['return_results' => $results]);
            return  'success';
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return  'fail';
        }
    }
    /**
     * 成员管理-站点成员管理-查看站点用户信息
     *
     * @author 尹少爷 2018.1.11
     *
     * @param proto $result
     *
     */
    public static function getSiteUserInfo($params, $userInfoUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => "get member info",
            'method' => __METHOD__,
            'params' =>base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $searchUserId    = isset($result['data']['site_user_id']) ?  $result['data']['site_user_id'] : '';
            $siteUserId      = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId  = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $userInfos = ZalyHelper::getUserInfoById($siteUserId, $searchUserId,  $originPluginId, $userInfoUrl, ZalyAes::ADMIN_AUTH_KEY);
            $log->info(['return_results' => $userInfos]);
            return $userInfos;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return[];
        }
    }
    /**
     * 成员管理-站点成员管理-更新用户信息
     *
     * @author 尹少爷 2018.1.10
     *
     * @param proto $result
     *
     */
    public static function updateSiteUserInfo($params, $updateSiteUserUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => "update member info",
            'method' => __METHOD__,
            'params' =>base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);
            $originPluginId  = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $userName        = isset($result['data']['user_name']) ? $result['data']['user_name'] : '';
            $siteUserId      = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $editSiteUserId  = isset($result['data']['site_user_id']) ? $result['data']['site_user_id'] : '';
            $userPhoto       = isset($result['data']['user_photo']) ? $result['data']['user_photo'] : '';

            $userProfile  = new UserProfile();
            $userProfile->setSiteUserId($editSiteUserId);
            $userProfile->setUserName($userName);
            $userProfile->setUserPhoto($userPhoto);
            $updateUserReq = new HaiUserUpdateRequest();
            $updateUserReq->setUserProfile($userProfile);
            $updateUserReq = $updateUserReq->serializeToString();
            $updateUserReq = ZalyHelper::generateDataForProxy($siteUserId, $updateUserReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $updateSiteUserUrl, $updateUserReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('update member info failed');
            }
            $log->info(['return_results' => 'success']);
            return "success";
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return  "fail";
        }
    }

    /**
     * 站点广场 获取用户数据
     *
     * @author 尹少爷 2017.12.27
     *
     * @param string siteUserId
     * @param string getMembersUrl
     * @param string page
     * @param string pageSize
     *
     * @return array
     */
    public static function getMembersList($siteUserId, $originPluginId, $getMembersUrl = '', $page = 1, $pageSize = 20)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'          => "pull member info",
            'method'       => __METHOD__,
            'site_user_id' => $siteUserId,
        ];
        try {
            $log->info($logText);
            $reqMemberLists = new HaiUserListRequest();
            $reqMemberLists->setPageNumber($page);
            $reqMemberLists->setPageSize($pageSize);
            $msgPacked  = $reqMemberLists->serializeToString();
            $msgPacked  = ZalyHelper::generateDataForProxy($siteUserId, $msgPacked);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $getMembersUrl, $msgPacked, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);

            $output   = [];
            $loading  = true;
            if ($results['error'] !== 'success') {
                $output = ["data" => $output, "loading" => $loading];
                return $output;
            }
            $data      = $results['data'];
            $response  = new HaiUserListResponse();
            $response->mergeFromString($data);
            $userInfos = $response->getUserProfile();
            if ($userInfos) {
                foreach ($userInfos as $key => $userInfo) {
                    $output[$key]['site_user_id']     = $userInfo->getSiteUserId();
                    $output[$key]['site_user_name']   = $userInfo->getUserName();
                    $output[$key]['site_user_photo']  = $userInfo->getUserPhoto();
                    $output[$key]['site_user_status'] = $userInfo->getUserStatus();
                }
            }
            if (count($output) >= 12) {
                $loading = false;
            }
            $output = ["data" => $output, "loading" => $loading];
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ["data" => [], "loading" => false];
        }
    }
}
