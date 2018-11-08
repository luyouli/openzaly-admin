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
use Library\ManageInviteCode;

class ManageInviteCodeController extends BaseController
{
    public $log;
    public $config;
    public $pageSize;

    public function __construct()
    {
        $this->log      = ZalyLog::init();
        $this->config   = ZalyConfig::init();
        $this->pageSize = $this->config['base']['page_size'];
        $this->isAdmin();
    }

    /**
     * 管理后台邀请码列表
     *
     * @author 尹少爷 2018.1.13
     *
     */
    public function indexAction()
    {
        echo $this->render('platform/code/index');
    }

    /**
     * 管理后台邀请码列表
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function codeUnusedListAction()
    {
        $params = file_get_contents("php://input");
        $uidUrl = $this->config['base']['uic_list_url'];
        $lists  = ManageInviteCode::getVerifyCodeLists($params, $uidUrl, $this->pageSize);
        echo $this->render('platform/code/unused_list', $lists);
    }
    /**
     * 管理后台邀请码列表
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function codeUsedListAction()
    {
        $params = file_get_contents("php://input");
        $uidUrl = $this->config['base']['uic_list_url'];
        $lists  = ManageInviteCode::getVerifyCodeLists($params, $uidUrl, $this->pageSize);
        echo $this->render('platform/code/used_list', $lists);
    }
    /**
     * 管理后台邀请码列表
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function pullInviteCodeAction()
    {
        $params = file_get_contents("php://input");
        $uidUrl = $this->config['base']['uic_list_url'];
        $lists  = ManageInviteCode::getVerifyCodeLists($params, $uidUrl, $this->pageSize);
        echo json_encode($lists);
    }
    /**
     * 管理后台-生成邀请码
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function generateInviteCodeAction()
    {
        $params = file_get_contents("php://input");

        $generateVerifyUrl = $this->config['base']['uic_generate_url'];
        echo ManageInviteCode::generateVerifyCodes($params, $generateVerifyUrl);
    }
}
