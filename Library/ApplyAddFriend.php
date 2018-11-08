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

use Zaly\Services\HaiFriendApplyRequest;

use Zaly\Encrypt\ZalyAes;
use Zaly\Library\ZalyHelper;
use Zaly\ZalyCurl;
use Zaly\ZalyLog;

class ApplyAddFriend
{
    /**
     * 申请添加好友
     *
     * @author 尹少爷 2017.12.27
     *
     * @param proto $result
     *
     * @param string $applyFriendUrl
     */
    public static function handleApplyAddFriendRequest($params, $applyFriendUrl)
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'    => 'apply add friend',
            'method' => __METHOD__,
            'params' => base64_encode($params),
        ];
        try {
            $log->info($logText);
            $result     = ZalyHelper::getDataFromProxy($params, ZalyAes::USER_SQUER_AUTH_KEY);

            $siteUserId = isset($result['site_user_id']) ? $result['site_user_id'] : '';
            $pluginId   = isset($result['plugin_id']) ? $result['plugin_id'] : '';
            $friendId   = isset($result['data']['site_user_id']) ? $result['data']['site_user_id']: "";
            $reason     = isset($result['data']['apply_reason']) ? $result['data']['apply_reason'] : '';
            return self::sendApplyFriendRequest($siteUserId, $friendId, $pluginId, $reason, $applyFriendUrl);
        } catch (\Exception $e) {
            $message = sprintf("msg:%s file:%s:%d", $e->getMessage(), $e->getFile(), $e->getLine());
            $log->error($message);
        }
    }

    /**
     * 发送申请添加好友
     *
     * @author 尹少爷 2017.12.27
     *
     * @param string $siteUserId 发起人id
     * @param string $friendId  接收好友请求的用户id
     * @param string $reason  添加说明
     * @param string $applyFriendUrl  处理添加好友申请功能的url
     *
     * @return string
     */
    public static function sendApplyFriendRequest($siteUserId, $friendId, $pluginId, $reason, $applyFriendUrl = '')
    {
        $log = ZalyLog::init();
        $logText = [
            'msg'          => 'send apply friend request',
            'method'       => __METHOD__,
            'site_user_id' => $siteUserId,
            'friend_id'    => $friendId,
        ];
        try {
            $log->info($logText);
            $friendApplyRequest  = new HaiFriendApplyRequest();
            $friendApplyRequest->setSiteFriendId($friendId);
            $friendApplyRequest->setApplyReason($reason);
            $msgPacked = $friendApplyRequest->serializeToString();
            $msgPacked = ZalyHelper::generateDataForProxy($siteUserId, $msgPacked,ZalyAes::USER_SQUER_AUTH_KEY);

            $curl    = ZalyCurl::init();
            $result  = $curl->request('post', $applyFriendUrl, $msgPacked, ["site-plugin-id" => $pluginId]);
            $results = ZalyHelper::getDataFromProxyForResponse($result,ZalyAes::USER_SQUER_AUTH_KEY);

            if ($results['error'] == 'error') {
                throw new \Exception($results['msg']);
            }
            $log->info(['return_results' => $results]);
            return "success";
        } catch (\Exception $ex) {
            $message = sprintf("msg:%s file:%s:%d", $ex->getMessage(), $ex->getFile(), $ex->getLine());
            $log->error($message);
            return $ex->getMessage();
        }
    }
}
