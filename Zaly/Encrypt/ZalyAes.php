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


namespace Zaly\Encrypt;

use Zaly\ZalyConfig;
use Zaly\ZalyLog;

class ZalyAes
{
	/**
	 * AES加密方式，Electronic Codebook Book
	 */
	CONST METHOD = "AES-128-ECB";
	/**
	 * 如果不设置，OPENSSL_ZERO_PADDING， 默认将会按照PKCS#7填充
	 * OPENSSL_RAW_DATA 按照 raw data解析 ，不然默认是base64
	 */
//    //////CONST OPTION = OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING;
    CONST OPTION = OPENSSL_RAW_DATA;

    CONST KEY_PATH = "/akaxin/phpconfig";

    //后台管理
    CONST ADMIN_AUTH_KEY = "admin_auth_key";

    //用户广场
    CONST USER_SQUER_AUTH_KEY = "user_squer_auth_key";



    public static function getAuthKey($authKeyName)
    {
        $log     = ZalyLog::init();
        $config  = ZalyConfig::init();
        $keyPath = $config['base']['authkey_path'];
        $log->info(["key_path" => $keyPath, "method" => __METHOD__]);

        if(!$keyPath) {
            return self::KEY_PATH;
        }
        $authKeyConfig = ZalyConfig::init($keyPath);
        return $authKeyConfig['authkey'][$authKeyName];
    }
	/**
	 * aes128ecb pkcs5加密数据
	 * mcrypt_encrypt 在php7.2以后弃用
	 *
	 * @author 尹少爷 2018.03.21
	 *
	 * @param string $key  加密key
	 * @param string $data 加密数据
	 *
	 * @return string base64
	 */
	public static function encrypt($key, $data)
	{
        return  openssl_encrypt($data, self::METHOD,  $key, self::OPTION);
	}
	/**
	 * aes128ecb pkcs5解密数据
	 * mcrypt_decrypt 在php7.2以后弃用
	 *
	 * @author 尹少爷 2018.03.21
	 *
	 * @param string $key  解密key
	 * @param string $data 解密数据
	 *
	 * @return string
	 */
	public static function decrypt($key, $data)
	{
		$data = openssl_decrypt($data, self::METHOD, $key, self::OPTION);
		return $data;
	}
}
