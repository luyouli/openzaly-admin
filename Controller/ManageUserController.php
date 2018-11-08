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
use Library\ManageUser;

class ManageUserController extends BaseController
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
     * 管理后台 站点成员管理-第一页
     *
     * @author 尹少爷 2018.1.5
     *
     */
    public function indexAction()
    {
        $getMembersUrl = $this->config['base']['member_list_site'];
        $pageSize      = $this->config['base']['page_size'];
        $params        = file_get_contents("php://input");
        $results       = ManageUser::getSiteUsers($params, $getMembersUrl, $pageSize);
        echo $this->render('platform/user/index', $results);
    }
    /**
     * 管理后台 站点成员管理-拉取站点用户
     *
     * @author 尹少爷 2018.1.5
     *
     */
    public function pullSiteUsersAction()
    {
        $params  = file_get_contents("php://input");

        $getMembersUrl = $this->config['base']['member_list_site'];
        $pageSize      = $this->config['base']['page_size'];
        $results       = ManageUser::getSiteUsers($params, $getMembersUrl, $pageSize);
        echo json_encode($results);
    }
    /**
     * 管理后台 用户管理-管理站点用户状态
     *
     * @author 尹少爷 2018.1.5
     *
     */
    public function sealupSiteUserAction()
    {
        $params = file_get_contents("php://input");

        $sealupSiteUserUrl = $this->config['base']['sealup_site_user_url'];
        echo  ManageUser::sealupSiteUser($params, $sealupSiteUserUrl);
    }
    /**
     * 管理后台 用户管理-更新用户信息页面
     *
     * @author 尹少爷 2018.1.10
     *
     */
    public function getSiteUserInfoAction()
    {
        $params  = file_get_contents("php://input");

        $userInfoUrl = $this->config['base']['site_user_info_url'];
        $info        =  ManageUser::getSiteUserInfo($params, $userInfoUrl);

        if (count($info)>0) {
            echo $this->render('platform/user/update', $info);
        } else {
            echo $this->render('platform/user/error');
        }
    }
    /**
     * 管理后台 用户管理-更新用户信息
     *
     * @author 尹少爷 2018.1.10
     *
     */
    public function updateSiteUserInfoAction()
    {
        $params  = file_get_contents("php://input");

        $updateSiteUserUrl = $this->config['base']['update_site_user_url'];
        echo  ManageUser::updateSiteUserInfo($params, $updateSiteUserUrl);
    }
    /**
     * 管理后台 用户管理-查找用户
     *
     * @author 尹少爷 2018.1.12
     *
     */
    public function searchUserAction()
    {
        $params  = file_get_contents("php://input");

        $searchUserUrl = $this->config['base']['search_site_user_url'];
        $results       = ManageUser::searchUserInfo($params, $searchUserUrl);
        echo json_encode($results);
    }
}
