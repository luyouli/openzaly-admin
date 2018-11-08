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
use Library\ManageBasic;

class ManageController extends BaseController
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
     * 管理后台首页
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function indexAction()
    {
        echo $this->render('platform/index');
    }

    /**
     * 管理后台基本设置-页面
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function basicAction()
    {
        $params = file_get_contents("php://input");

        $getConfigUrl = $this->config['base']['get_site_config_url'];
        $configs      = ManageBasic::getBasicConfig($params, $getConfigUrl);
        echo $this->render('platform/basic/setBasic', $configs);
    }
    /**
     * 管理后台基本设置-修改
     *
     * @author 尹少爷 2018.1.2
     *
     */
    public function setBasicAction()
    {
        $params = file_get_contents("php://input");

        $setSiteConfigUrl = $this->config['base']['set_site_config_url'];
        echo  ManageBasic::setBasicConfig($params, $setSiteConfigUrl);
    }
}
