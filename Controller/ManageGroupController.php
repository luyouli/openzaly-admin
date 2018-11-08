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
use Zaly\ZalyConfig;
use Zaly\ZalyLog;
use Library\ManageGroup;

class ManageGroupController extends BaseController
{
    public $log;
    public $config;

    public function __construct()
    {
        $this->log     = ZalyLog::init();
        $this->config  = ZalyConfig::init();
        $this->isAdmin();
    }
    /**
     * 管理后台 群管理-群列表
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function indexAction()
    {
        $params  = file_get_contents("php://input");
        $groupListUrl = $this->config['base']['group_list_url'];
        $pageSize = $this->config['base']['page_size'];
        $lists = ManageGroup::getGroupLists($params, $groupListUrl, $pageSize);
        echo $this->render('platform/group/index', $lists);
    }

    /**
     * 管理后台 群管理-群列表-pull
     *
     * @author 尹少爷 2018.1.13
     *
     */
    public function pullListAction()
    {
        $params  = file_get_contents("php://input");
        $groupListUrl = $this->config['base']['group_list_url'];
        $pageSize = $this->config['base']['page_size'];
        $lists = ManageGroup::getGroupLists($params, $groupListUrl, $pageSize);
        echo json_encode($lists);
    }
    /**
     * 管理后台 群管理-群管理界面
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function groupAdminAction()
    {
        $params  = file_get_contents("php://input");
        $results = ManageGroup::getGroupId($params);
        echo $this->render('platform/group/groupAdmin', $results);
    }

    /**
     * 管理后台 群管理-群成员列表
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function groupMembersAction()
    {
        $params  = file_get_contents("php://input");

        $pageSize        = $this->config['base']['page_size'];
        $groupMembersUrl = $this->config['base']['group_members_url'];
        $results         = ManageGroup::getGroupMembers($params, $groupMembersUrl, $pageSize);
        echo $this->render('platform/group/groupMember', $results);
    }
    /**
     * 管理后台 群管理-拉取群成员列表
     *
     * @author 尹少爷 2018.1.14
     *
     */
    public function pullGroupMembersAction()
    {
        $params  = file_get_contents("php://input");
        $pageSize = $this->config['base']['page_size'];
        $groupMembersUrl = $this->config['base']['group_members_url'];
        $results = ManageGroup::getGroupMembers($params, $groupMembersUrl, $pageSize);
        echo json_encode($results);
    }
    /**
     * 管理后台 群管理-删除群成员
     *
     * @author 尹少爷 2018.1.14
     *
     */
    public function removeGroupMemberAction()
    {
        $params  = file_get_contents("php://input");

        $removeGroupMemberUrl = $this->config['base']['group_remove_members_url'];
        echo ManageGroup::removeGroupMember($params, $removeGroupMemberUrl);
    }
    /**
     * 管理后台 群管理-添加群成员
     *
     * @author 尹少爷 2018.1.14
     *
     */
    public function addGroupUserAction()
    {
        $params = file_get_contents("php://input");

        $addUserToGroupUrl = $this->config['base']['group_add_members_url'];
        echo ManageGroup::addGroupUser($params, $addUserToGroupUrl);
    }

    /**
     * 管理后台 群管理-修改群名称页面
     *
     * @author 尹少爷 2018.1.5
     *
     */
    public function groupInfoAction()
    {
        $params  = file_get_contents("php://input");

        $groupInfoUrl = $this->config['base']['group_info_url'];
        $results      = ManageGroup::getGroupInfo($params, $groupInfoUrl);
        echo $this->render('platform/group/groupInfo', $results);
    }
    /**
     * 管理后台 群管理-修改群名称
     *
     * @author 尹少爷 2018.1.13
     *
     */
    public function setGroupInfoAction()
    {
        $params = file_get_contents("php://input");

        $updateGroupUrl = $this->config['base']['group_update_url'];
        echo ManageGroup::setGroupInfo($params, $updateGroupUrl);
    }

    /**
     * 管理后台 群管理-解散群
     *
     * @author 尹少爷 2018.1.14
     *
     */
    public function disbandGroupAction()
    {
        $params = file_get_contents("php://input");

        $disbandGroupUrl = $this->config['base']['group_delete_url'];
        echo ManageGroup::disbandGroup($params, $disbandGroupUrl);
    }

    /**
     * 管理后台 站点成员管理-第一页
     *
     * @author 尹少爷 2018.1.5
     *
     */
    public function siteUserAction()
    {
        $params  = file_get_contents("php://input");

        $getMembersUrl = $this->config['base']['group_nonmember_list_site'];
        $pageSize      = $this->config['base']['page_size'];
        $results       = ManageGroup::getSiteUsers($params, $getMembersUrl, $pageSize);
        echo $this->render('platform/group/siteUser', $results);
    }
    /**
     * 管理后台 站点成员管理-拉取布局
     *
     * @author 尹少爷 2018.1.5
     *
     */
    public function pullSiteUsersAction()
    {
        $params = file_get_contents("php://input");

        $getMembersUrl = $this->config['base']['group_nonmember_list_site'];
        $pageSize      = $this->config['base']['page_size'];
        $results       = ManageGroup::getSiteUsers($params, $getMembersUrl, $pageSize);
        echo json_encode($results);
    }
}
