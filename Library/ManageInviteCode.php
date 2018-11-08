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

use Zaly\Services\HaiUicListRequest;
use Zaly\Services\HaiUicListResponse;
use Zaly\Services\HaiUicCreateRequest;
use Zaly\Services\UicStatus;
use Zaly\ZalyCurl;
use Zaly\ZalyLog;
use Zaly\Library\ZalyHelper;

class ManageInviteCode
{

    /**
     * 邀请码-获取邀请码列表
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function getVerifyCodeLists($params, $getUicUrl, $pageSize = 12)
    {
        $log     = ZalyLog::init();
        $loading = true;
        $logText = [
            'msg'    => 'get invite code list',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $page           = isset($result['data']['page']) ? $result['data']['page'] : 1;
            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $statusKey      = isset($result['data']['code_status']) ? $result['data']['code_status'] : 'used';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $uicReq = new HaiUicListRequest();
            $uicReq->setPageNumber($page);
            $uicReq->setPageSize($pageSize);
            $status = constant(UicStatus::class."::".strtoupper($statusKey));
            $uicReq->setStatus($status);
            $uicReq = $uicReq->serializeToString();
            $uicReq = ZalyHelper::generateDataForProxy($siteUserId, $uicReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $getUicUrl, $uicReq, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('get invite code failed');
            }
            $data     = $results['data'];
            $uicRep   = new HaiUicListResponse();
            $uicRep->mergeFromString($data);
            $uidLists = $uicRep->getUicInfo();
            $lists    = [];
            foreach ($uidLists as $key => $uic) {
                $lists[$key]['code'] = $uic->getUic();
                $lists[$key]['use_site_user_name'] = $uic->getUserName();
                $lists[$key]['code_status'] = $uic->getStatus();
            }
            if (count($lists) >= 12) {
                $loading = false;
            }
            $output = ['results' => $lists, 'loading' =>$loading];
            $log->info(['return_results'=> $output]);
            return $output;
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return ['results' => [], 'loading' =>$loading];
        }
    }
    /**
     * 邀请码-生成新的邀请码列表
     *
     * @author 尹少爷 2018.1.4
     *
     * @param proto $result
     *
     */
    public static function generateVerifyCodes($params, $generateVerifyUrl, $uicNumber = 20)
    {
        $log     = ZalyLog::init();
        $logText = [
            'msg'    => 'get invite code list',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result = ZalyHelper::getDataFromProxy($params);

            $siteUserId     = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $originPluginId = isset($result['plugin_id']) ? $result['plugin_id'] : '';

            $uicCreateReq  = new HaiUicCreateRequest();
            $uicCreateReq->setUicNumber($uicNumber);
            $uicCreateReq  = $uicCreateReq->serializeToString();
            $uicCreateReqs = ZalyHelper::generateDataForProxy($siteUserId, $uicCreateReq);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $generateVerifyUrl, $uicCreateReqs, ["site-plugin-id" => $originPluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result);
            if ($results['error'] == 'fail') {
                throw new \Exception('generate invite code failed');
            }
            $log->info(['return_results' => 'success']);
            return 'success';
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
            return 'fail';
        }
    }
}
