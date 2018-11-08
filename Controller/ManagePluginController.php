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
use Library\ManagePlugin;

class ManagePluginController extends BaseController
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
     * 管理后台 插件管理-页面
     *
     * @author 尹少爷 2018.1.6
     *
     */
    public function indexAction()
    {
        echo $this->render('platform/plugin/index');
    }
    /**
     * 管理后台 插件管理-插件列表
     *
     * @author 尹少爷 2018.1.6
     *
     */
    public function pluginListAction()
    {
        $params = file_get_contents("php://input");

        $pluginListUrl = $this->config['base']['plugin_list_url'];
        $results       = ManagePlugin::pluginList($params, $pluginListUrl, $this->pageSize);
        echo $this->render('platform/plugin/list', $results);
    }
    /**
     * 管理后台 插件管理-插件列表拉取
     *
     * @author 尹少爷 2018.1.6
     *
     */
    public function pullPluginListAction()
    {
        $params = file_get_contents("php://input");

        $pluginListUrl = $this->config['base']['plugin_list_url'];
        $results       = ManagePlugin::pluginList($params, $pluginListUrl, $this->pageSize);
        echo json_encode($results);
    }

    /**
     * 插件管理-插件列表-添加插件列表页面
     *
     * @author 尹少爷 2018.1.6
     *
     * @param proto $result
     *
     */
    public function addPluginHtmlAction()
    {
        echo $this->render('platform/plugin/add');
    }
    /**
     * 插件管理-插件列表-添加插件
     *
     * @author 尹少爷 2018.1.6
     *
     * @param proto $result
     *
     */
    public function addPluginAction()
    {
        $params = file_get_contents("php://input");

        $pluginAddUrl = $this->config['base']['plugin_add_url'];
        $results      = ManagePlugin::addPlugin($params, $pluginAddUrl);
        echo $results;
    }

    /**
     * 插件管理-插件列表-删除插件
     *
     * @author 尹少爷 2018.1.6
     *
     * @param proto $result
     *
     */
    public function deletePluginAction()
    {
        $params = file_get_contents("php://input");

        $delPluginUrl = $this->config['base']['plugin_delete_url'];
        $results      = ManagePlugin::deletePlugin($params, $delPluginUrl);
        echo $results;
    }

    /**
     * 插件管理-插件列表-更新插件信息
     *
     * @author 尹少爷 2018.1.12
     *
     * @param proto $result
     *
     */
    public function updatePluginAction()
    {
        $params = file_get_contents("php://input");

        $updatePluginUrl = $this->config['base']['plugin_update_url'];
        $results         = ManagePlugin::updatePlugin($params, $updatePluginUrl);
        echo $results;
    }

    /**
     * 插件管理-插件列表-获取插件信息
     *
     * @author 尹少爷 2018.1.12
     *
     * @param proto $result
     *
     */
    public function pluginInfoAction()
    {
        $params = file_get_contents("php://input");

        $pluginInfoUrl = $this->config['base']['plugin_profile_url'];
        $results       = ManagePlugin::pluginInfo($params, $pluginInfoUrl);

        if (count($results)) {
            echo $this->render('platform/plugin/update', $results);
        } else {
            echo $this->render('platform/plugin/error');
        }
    }
}
