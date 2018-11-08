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

use Zaly\Library\ZalyHelper;

class BaseController
{
    /**
     * 判断是否是管理员
     *
     * @author 尹少爷 2018.1.13
     *
     */
    public function isAdmin()
    {
        $params  = file_get_contents("php://input");

        $getConfigUrl = $this->config['base']['get_site_config_url'];
        $isAdmin      = ZalyHelper::judgeIsAdmin($params, $getConfigUrl);
        if ($isAdmin === false ) {
            echo $this->render('platform/error');
            die();
        }
        putenv("MANAGER_TYPE=$isAdmin");
    }
    /**
     * 渲染页面
     *
     * @author 尹少爷 2018.1.13
     *
     */
    public function render($fileName, $params = [])
    {
        ob_start();
        $path = dirname(__DIR__).'/Views/'.$fileName.'.html';
        $params['host_name']      = getenv('HOST_NAME');
        $params['static_version'] = '?version='.getenv('STATIC_VERSION');
        $params['manager_type']   = getenv("MANAGER_TYPE");
        if ($params) {
            extract($params, EXTR_SKIP);
        }
        $htmlCode = file_get_contents($path);
        preg_match_all('/href-data="Public(.*?)"/', $htmlCode, $matches, PREG_PATTERN_ORDER);
        $cssPath = array_pop($matches);
        $cssFile = dirname(__DIR__).'/Public/'.$cssPath[0];
        $cssCode = file_get_contents($cssFile);
        if ($cssCode) {
            extract(['css_code' => $cssCode], EXTR_SKIP);
        }
        include($path);
        $var = ob_get_contents();
        ob_end_clean();
        return $var;
    }
}
