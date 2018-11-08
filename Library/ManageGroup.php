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

use Zaly\Services\HaiGroupListRequest;
use Zaly\Services\HaiGroupListResponse;
use Zaly\Services\HaiGroupUpdateProfileRequest;
use Zaly\Services\HaiGroupProfileRequest;
use Zaly\Services\HaiGroupProfileResponse;
use Zaly\Services\HaiGroupMembersResponse;
use Zaly\Services\HaiGroupDeleteRequest;
use Zaly\Services\HaiGroupRemoveMemberRequest;
use Zaly\Services\HaiGroupMembersRequest;
use Zaly\Services\HaiGroupAddMemberRequest;
use Zaly\Services\HaiGroupNonmembersRequest;
use Zaly\Services\HaiGroupNonmembersResponse;
use Zaly\Services\GroupProfile;
use Zaly\ZalyCurl;
use Zaly\ZalyLog;
use Zaly\Library\ZalyHelper;

class ManageGroup
{
    /**
     * 群管理-获取站点下群组列表
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function getGroupLists($params, $groupListUrl, $pageSize = 12)
    {
        $log     = ZalyLog::init();
        $loading = true;
        $logText = [
            'msg'    => 'get site group list',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $page           = isset($result['data']['page']) ? $result['data']['page'] : 1;
            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $groupListReq = new HaiGroupListRequest();
            $groupListReq->setPageNumber($page);
            $groupListReq->setPageSize($pageSize);
            $groupListReq = $groupListReq->serializeToString();
            $groupListReq = ZalyHelper::generateDataForProxy($siteUserId, $groupListReq);

            $curl    =  ZalyCurl::init();
            $result  = $curl->request('post', $groupListUrl, $groupListReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get group list is failed');
            }
            $data = $results['data'];
            $groupListRep = new HaiGroupListResponse();
            $groupListRep->mergeFromString($data);
            $groupLists   = $groupListRep->getGroupProfile();
            $lists = [];
            foreach ($groupLists as $key => $group) {
                $lists[$key]['group_id']   = $group->getGroupId();
                $lists[$key]['group_name'] = $group->getGroupName();
                $lists[$key]['group_icon'] = $group->getGroupIcon();
            }
            if (count($lists) >= 12) {
                $loading = false;
            }
            $output = ['results' => $lists, 'loading' => $loading];
            $log->info(['return_results' => $output]);
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['results' => [], 'loading' => $loading];
        }
    }
    /**
     * 群管理-获取站点下单个群组的群成员
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function getGroupMembers($params, $groupMembersUrl, $pageSize = 30)
    {
        $log    = ZalyLog::init();
        $loading = true;
        $logText = [
            'msg'    => 'get group members',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $groupId        = isset($result['data']['group_id']) ? $result['data']['group_id'] : '';
            $page           = isset($result['data']['page']) ? $result['data']['page'] : 1;
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $groupMemberReq = new HaiGroupMembersRequest();
            $groupMemberReq->setGroupId($groupId);
            $groupMemberReq->setPageNumber($page);
            $groupMemberReq->setPageSize($pageSize);
            $groupMemberReq = $groupMemberReq->serializeToString();
            $groupMemberReq = ZalyHelper::generateDataForProxy($siteUserId, $groupMemberReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $groupMembersUrl, $groupMemberReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            $log->info(['get_results' => $results]);
            if ($results['error'] == 'fail') {
                throw new \Exception('get group member failed');
            }
            $data = $results['data'];
            $groupMembersRep = new HaiGroupMembersResponse();
            $groupMembersRep->mergeFromString($data);
            $membersLists = $groupMembersRep->getGroupMember();

            $lists = [];
            foreach ($membersLists as $key => $member) {
                $memberInfo = $member->getProfile();
                $lists[$key]['site_user_id'] = $memberInfo->getSiteUserId();
                $lists[$key]['user_photo']   = $memberInfo->getUserPhoto();
                $lists[$key]['user_desc']    = $memberInfo->getSelfIntroduce();
                $lists[$key]['user_name']    = $memberInfo->getUserName();
                $lists[$key]['group_id']     = $groupId;
            }
            if (count($lists)>=12) {
                $loading = false;
            }
            $output = ['results' => $lists, 'loading' => $loading, 'group_id' => $groupId];
            $log->info(['return_results' => $output]);
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['results' => [], 'loading' => $loading, 'group_id' => ''];
        }
    }

    /**
     * 群管理-获取站点下单个群组的群成员
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function getGroupId($params)
    {
        $log    = ZalyLog::init();
        $loading = true;
        $logText = [
            'msg'    => 'get group id',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result     = ZalyHelper::getDataFromProxy($params);
            $groupId    = isset($result['data']['group_id']) ? $result['data']['group_id'] : '';
            $groupName  = isset($result['data']['group_name']) ? $result['data']['group_name'] : '';
            $output     = ['group_id' => $groupId, 'group_name' => $groupName];
            $log->info(['return_results' => $output]);
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['group_id' => '', 'group_name' => ''];
        }
    }
    /**
     * 群管理-删除群成员
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function removeGroupMember($params, $removeGroupUserUrl)
    {
        $log     = ZalyLog::init();
        $logText = [
            'msg'    => 'remove group member',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId       = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $removeSiteUserId = isset($result['data']['remove_site_user_id']) ? $result['data']['remove_site_user_id'] : '';
            $groupId          = isset($result['data']['group_id']) ? $result['data']['group_id'] : '';
            $originPluginId   = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $removeMemberReq  = new HaiGroupRemoveMemberRequest();
            $removeMemberReq->setGroupId($groupId);
            $removeMemberReq->setGroupMember($removeSiteUserId);
            $removeMemberReq  = $removeMemberReq->serializeToString();
            $removeMemberReq  = ZalyHelper::generateDataForProxy($siteUserId, $removeMemberReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $removeGroupUserUrl, $removeMemberReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('remove group member failed');
            }
            $log->info(['return_results' => 'success']);
            return "success";
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return "fail";
        }
    }
    /**
     * 群管理-添加群成员
     *
     * @author 尹少爷 2018.1.14
     *
     * @param proto $result
     *
     */
    public static function addGroupUser($params, $addUserToGroupUrl)
    {
        $log    = ZalyLog::init();
        $logText = [
            'msg'    => 'add site member to  group',
            'method' => __METHOD__,
            'params' =>base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $groupId        = isset($result['data']['group_id']) ? $result['data']['group_id'] : '';
            $addSiteUserId  = isset($result['data']['add_site_user_id']) ? $result['data']['add_site_user_id'] : '';
            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $addMemberReq  = new HaiGroupAddMemberRequest();
            $addMemberReq->setGroupId($groupId);
            $addMemberReq->setGroupMember($addSiteUserId);
            $addMemberReq  = $addMemberReq->serializeToString();
            $addMemberReq  = ZalyHelper::generateDataForProxy($siteUserId, $addMemberReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $addUserToGroupUrl, $addMemberReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('add group member failed');
            }
            $log->info(['return_results' => 'success']);
            return "success";
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }

    /**
     * 群管理-解散群
     *
     * @author 尹少爷 2018.1.5
     *
     * @param proto $result
     *
     */
    public static function disbandGroup($params, $disbandGroupUrl)
    {
        $log    = ZalyLog::init();
        $logText = [
            'msg'    => 'disband group',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $groupId        = isset($result['data']['group_id']) ? $result['data']['group_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $disbandGroupReq = new HaiGroupDeleteRequest();
            $disbandGroupReq->setGroupId($groupId);
            $disbandGroupReq = $disbandGroupReq->serializeToString();
            $disbandGroupReq = ZalyHelper::generateDataForProxy($siteUserId, $disbandGroupReq);
            $log->info([$result, $disbandGroupUrl]);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $disbandGroupUrl, $disbandGroupReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            $log->info(['get_results' => $results]);
            if ($results['error'] == 'fail') {
                throw new \Exception('disband group failed');
            }
            $log->info(['return_results' => 'success']);
            return "success";
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }
    /**
     * 群管理-得到群信息【名称 头像 公告】
     *
     * @author 尹少爷 2018.1.13
     *
     * @param proto $result
     *
     */
    public static function getGroupInfo($params, $groupInfoUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'get group info',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $groupId        = isset($result['data']['group_id']) ?$result['data']['group_id'] : '' ;

            $groupProfileReq = new HaiGroupProfileRequest();
            $groupProfileReq->setGroupId($groupId);
            $groupProfileReq = $groupProfileReq->serializeToString();
            $groupProfileReq = ZalyHelper::generateDataForProxy($siteUserId, $groupProfileReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $groupInfoUrl, $groupProfileReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get group info failed');
            }
            $data = $results['data'];

            $groupProfileRep = new HaiGroupProfileResponse();
            $groupProfileRep->mergeFromString($data);
            $groupProfile    = $groupProfileRep->getProfile();

            $list = [
                    'group_name'   => $groupProfile->getName(),
                    'group_id'     => $groupProfile->getId(),
                    'group_icon'   => $groupProfile->getIcon(),
                    'group_notice' => $groupProfile->getGroupNotice(),
            ];
            $log->info(['return_results' => $list]);
            return $list;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return [];
        }
    }
    /**
     * 群管理-修改群信息
     *
     * @author 尹少爷 2018.1.13
     *
     * @param proto $result
     *
     */
    public static function setGroupInfo($params, $updateGroupInfoUrl)
    {
        $log    = ZalyLog::init();
        $logText = [
            'msg'    => 'update group info',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $groupName      = isset($result['data']['group_name']) ? $result['data']['group_name'] : '';
            $groupId        = isset($result['data']['group_id']) ? $result['data']['group_id'] : '';
            $groupIcon      = isset($result['data']['group_icon']) ? $result['data']['group_icon'] : '';
            $groupNotice    = isset($result['data']['group_notice']) ? $result['data']['group_notice'] : '';

            $groupProfile = new GroupProfile();
            $groupProfile->setId($groupId);
            $groupProfile->setName($groupName);
            $groupProfile->setGroupNotice($groupNotice);
            $groupProfile->setIcon($groupIcon);
            $groupUpdateReq = new HaiGroupUpdateProfileRequest();
            $groupUpdateReq->setProfile($groupProfile);
            $groupUpdateReq = $groupUpdateReq->serializeToString();
            $groupUpdateReq = ZalyHelper::generateDataForProxy($siteUserId, $groupUpdateReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $updateGroupInfoUrl, $groupUpdateReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('update group info failed');
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
     * 群管理-获取不在群中的站点用户
     *
     * @author 尹少爷 2018.1.14
     *
     * @param Array $result
     *
     */
    public static function getSiteUsers($params, $getMembersUrl, $pageSize)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'get site users not in the group',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $loading = true;
            $result  = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $groupId        = isset($result['data']['group_id']) ?  $result['data']['group_id'] : '';
            $page           = isset($result['data']['page']) ? $result['data']['page'] : 1;

            $nonmemberReq = new HaiGroupNonmembersRequest();
            $nonmemberReq->setGroupId($groupId);
            $nonmemberReq->setPageSize($pageSize);
            $nonmemberReq->setPageNumber($page);
            $nonmemberReq = $nonmemberReq->serializeToString();
            $nonmemberReq = ZalyHelper::generateDataForProxy($siteUserId, $nonmemberReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $getMembersUrl, $nonmemberReq, ["site-plugin-id" => $originPluginId ]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get members failed');
            }
            $data         = $results['data'];
            $nonmemberRep = new HaiGroupNonmembersResponse();
            $nonmemberRep->mergeFromString($data);
            $lists  = $nonmemberRep->getGroupMember();
            $output = [];
            foreach ($lists as $key => $val) {
                $userProfile = $val->getProfile();
                $output[$key]['site_user_id']     = $userProfile->getSiteUserId();
                $output[$key]['site_user_name']   = $userProfile->getUserName();
                $output[$key]['site_user_photo']  = $userProfile->getUserPhoto();
                $output[$key]['site_user_status'] = $userProfile->getUserStatus();
            }
            if (count($output) >= 12) {
                $loading = false;
            }
            $log->info(['return_results' => $output]);
            return ["data" => $output, "loading" => $loading, 'group_id' => $groupId];
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['results' => [], 'loading' => true, 'group_id' => ''];
        }
    }
}
