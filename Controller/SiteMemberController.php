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
namespace Controller;

use Controller\BaseController;

use Zaly\ZalyRequest;
use Zaly\ZalyCurl;
use Zaly\ZalyConfig;
use Zaly\ZalyLog;
use Library\SiteMemberLists;
use Library\ApplyAddFriend;

class SiteMemberController extends BaseController
{
    public $request;
    public function __construct()
    {
        $this->request = ZalyRequest::init();
        $this->log     = ZalyLog::init();
        $this->config  = ZalyConfig::init();
    }
    /**
     * 站点广场 获取用户数据
     *
     * @author 尹少爷 2017.12.23
     *
     */
    public function membersAction()
    {
        $results = $this->getMembersFromSite();

        if($results['error'] == "error") {
            echo $this->render('siteMember/error');
        } else {
            $originPluginId            = $results['origin_plugin_id'];
            $results['site_user_id']   = $results['current_site_user_id'];
            $results['site_user_name'] = '';
            $siteUserId                = $results['current_site_user_id'];

            $memberInfo = $this->getMemberSelfInfo($siteUserId, $siteUserId, $originPluginId);
            if($memberInfo && isset($memberInfo['user_name'])) {
                $results['site_user_name'] = $memberInfo['user_name'];
            }
            echo $this->render('siteMember/siteMemberList', $results);
        }


    }
    /**
     * 站点广场 获取第一页用户数据
     *
     * @author 尹少爷 2017.12.23
     *
     */
    protected function getMembersFromSite()
    {
        $params = file_get_contents("php://input");

        $getMembersUrl = $this->config['base']['member_relation_list_site'];
        $pageSize      = isset($this->config['base']['page_size']) ? $this->config['base']['page_size'] : 10;

        return  SiteMemberLists::getMembersList($params, $getMembersUrl, $pageSize);
    }
    /**
     * 站点广场 获取自己的用户数据
     *
     * @author 尹少爷 2017.12.23
     *
     */
    protected function getMemberSelfInfo($currentSiteUserId, $searchUserId, $originPluginId)
    {
        $userInfoUrl = $this->config['base']['site_user_info_url'];
        return SiteMemberLists::getSiteMemberInfo($currentSiteUserId, $searchUserId, $originPluginId,  $userInfoUrl);
    }

    /**
     * 发送申请添加好友
     *
     * @author 尹少爷 2017.12.23
     */
    public function applyAddFriendAction()
    {
        $params = file_get_contents("php://input");

        $applyFriendUrl = $this->config['base']['apply_friend_url'];
        $result         = ApplyAddFriend::handleApplyAddFriendRequest($params, $applyFriendUrl);
        echo  $result;
    }

    /**
     * 拉取站点用户列表
     *
     * @author 尹少爷 2017.12.23
     */
    public function pullMemberListAction()
    {
        try {
            $results = $this->getMembersFromSite();
            echo json_encode($results, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $ex) {
            echo [];
        }
    }
}
