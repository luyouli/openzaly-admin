<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/plugin.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>core.Plugin</code>
 */
class Plugin extends \Google\Protobuf\Internal\Message
{
    /**
     * 对于一个特定的Site，plugin.id 是唯一的。
     *
     * Generated from protobuf field <code>string id = 1;</code>
     */
    private $id = '';
    /**
     * 扩展名字，会显示在界面上
     *
     * Generated from protobuf field <code>string name = 2;</code>
     */
    private $name = '';
    /**
     * 落地页地址
     * 以http或https开头，客户端直接以url_page作为网址渲染webview
     * 否则，为api.proxy.page 请求的page参数值，默认为空
     * 如：
     * value= https://www.google.com 直接以此网址加载webview。
     * value= main，代表通过api.proxy.page接口请求main页面。
     * value= 空，代表通过api.proxy.page接口请求空页面（pluginServer自己把空返回默认主页）
     *
     * Generated from protobuf field <code>string url_page = 3;</code>
     */
    private $url_page = '';
    /**
     * api.plugin.proxy 请求转发请求时的目的URL
     * 此URL只能以http或者https开头，如无则为http
     * ====IMPORTANT====
     * 此api是给server用的，不允许传递此值到客户端。如复用此结构必须在传递给客户端之前将此值置空。
     *
     * Generated from protobuf field <code>string api_url = 4;</code>
     */
    private $api_url = '';
    /**
     * 扩展图标文件，会显示在界面上
     * 如果以http开头，则代表着这是一个http协议的文件。
     * 否则，通过site-download功能下载此图片。
     *
     * Generated from protobuf field <code>string icon = 5;</code>
     */
    private $icon = '';
    /**
     * pluginServer 在 请求 siteServer的innerAPI时，使用此值加密数据，以证明身份。
     * 添加扩展时由SiteServer自动生成并记录，为64个[A-Za-z0-9]组成的随机字符串。
     * site 使用auth_key 加密发送给plugin的整个proto
     * 同时 site使用auth_key解析 plugin传递过来的具体proto值
     *
     * Generated from protobuf field <code>string auth_key = 6;</code>
     */
    private $auth_key = '';
    /**
     * site server的innerAPI允许的pluginServer地址。
     * 默认为127.0.0.1，如为空则代表不限制，此外：支持网络掩码的配置方式。
     * 如果有多个ip，以英文逗号[,]隔开。
     *
     * Generated from protobuf field <code>string allowed_ip = 7;</code>
     */
    private $allowed_ip = '';
    /**
     * 扩展的位置【应该为一个枚举】
     * 值：首页、消息帧
     * 本次不允许首页并且消息帧这个类型。
     *
     * Generated from protobuf field <code>.core.PluginPosition position = 8;</code>
     */
    private $position = 0;
    /**
     * 显示顺序
     * 当一个位置，有多个扩展时，此处描述顺序，数字越小，排列越靠前（从上往下，从左往右排列）
     *
     * Generated from protobuf field <code>int32 order = 9;</code>
     */
    private $order = 0;
    /**
     * 展现方式【应该为一个枚举】
     * 默认、浮屏、分屏
     * 目前写死【默认】
     *
     * Generated from protobuf field <code>.core.PluginDisplayMode display_mode = 10;</code>
     */
    private $display_mode = 0;
    /**
     * 可用状态
     * - 禁用
     * - 管理员可用
     * - 全员可用
     *
     * Generated from protobuf field <code>.core.PermissionStatus permission_status = 11;</code>
     */
    private $permission_status = 0;

    public function __construct() {
        \GPBMetadata\Core\Plugin::initOnce();
        parent::__construct();
    }

    /**
     * 对于一个特定的Site，plugin.id 是唯一的。
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * 对于一个特定的Site，plugin.id 是唯一的。
     *
     * Generated from protobuf field <code>string id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkString($var, True);
        $this->id = $var;

        return $this;
    }

    /**
     * 扩展名字，会显示在界面上
     *
     * Generated from protobuf field <code>string name = 2;</code>
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 扩展名字，会显示在界面上
     *
     * Generated from protobuf field <code>string name = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setName($var)
    {
        GPBUtil::checkString($var, True);
        $this->name = $var;

        return $this;
    }

    /**
     * 落地页地址
     * 以http或https开头，客户端直接以url_page作为网址渲染webview
     * 否则，为api.proxy.page 请求的page参数值，默认为空
     * 如：
     * value= https://www.google.com 直接以此网址加载webview。
     * value= main，代表通过api.proxy.page接口请求main页面。
     * value= 空，代表通过api.proxy.page接口请求空页面（pluginServer自己把空返回默认主页）
     *
     * Generated from protobuf field <code>string url_page = 3;</code>
     * @return string
     */
    public function getUrlPage()
    {
        return $this->url_page;
    }

    /**
     * 落地页地址
     * 以http或https开头，客户端直接以url_page作为网址渲染webview
     * 否则，为api.proxy.page 请求的page参数值，默认为空
     * 如：
     * value= https://www.google.com 直接以此网址加载webview。
     * value= main，代表通过api.proxy.page接口请求main页面。
     * value= 空，代表通过api.proxy.page接口请求空页面（pluginServer自己把空返回默认主页）
     *
     * Generated from protobuf field <code>string url_page = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setUrlPage($var)
    {
        GPBUtil::checkString($var, True);
        $this->url_page = $var;

        return $this;
    }

    /**
     * api.plugin.proxy 请求转发请求时的目的URL
     * 此URL只能以http或者https开头，如无则为http
     * ====IMPORTANT====
     * 此api是给server用的，不允许传递此值到客户端。如复用此结构必须在传递给客户端之前将此值置空。
     *
     * Generated from protobuf field <code>string api_url = 4;</code>
     * @return string
     */
    public function getApiUrl()
    {
        return $this->api_url;
    }

    /**
     * api.plugin.proxy 请求转发请求时的目的URL
     * 此URL只能以http或者https开头，如无则为http
     * ====IMPORTANT====
     * 此api是给server用的，不允许传递此值到客户端。如复用此结构必须在传递给客户端之前将此值置空。
     *
     * Generated from protobuf field <code>string api_url = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setApiUrl($var)
    {
        GPBUtil::checkString($var, True);
        $this->api_url = $var;

        return $this;
    }

    /**
     * 扩展图标文件，会显示在界面上
     * 如果以http开头，则代表着这是一个http协议的文件。
     * 否则，通过site-download功能下载此图片。
     *
     * Generated from protobuf field <code>string icon = 5;</code>
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * 扩展图标文件，会显示在界面上
     * 如果以http开头，则代表着这是一个http协议的文件。
     * 否则，通过site-download功能下载此图片。
     *
     * Generated from protobuf field <code>string icon = 5;</code>
     * @param string $var
     * @return $this
     */
    public function setIcon($var)
    {
        GPBUtil::checkString($var, True);
        $this->icon = $var;

        return $this;
    }

    /**
     * pluginServer 在 请求 siteServer的innerAPI时，使用此值加密数据，以证明身份。
     * 添加扩展时由SiteServer自动生成并记录，为64个[A-Za-z0-9]组成的随机字符串。
     * site 使用auth_key 加密发送给plugin的整个proto
     * 同时 site使用auth_key解析 plugin传递过来的具体proto值
     *
     * Generated from protobuf field <code>string auth_key = 6;</code>
     * @return string
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * pluginServer 在 请求 siteServer的innerAPI时，使用此值加密数据，以证明身份。
     * 添加扩展时由SiteServer自动生成并记录，为64个[A-Za-z0-9]组成的随机字符串。
     * site 使用auth_key 加密发送给plugin的整个proto
     * 同时 site使用auth_key解析 plugin传递过来的具体proto值
     *
     * Generated from protobuf field <code>string auth_key = 6;</code>
     * @param string $var
     * @return $this
     */
    public function setAuthKey($var)
    {
        GPBUtil::checkString($var, True);
        $this->auth_key = $var;

        return $this;
    }

    /**
     * site server的innerAPI允许的pluginServer地址。
     * 默认为127.0.0.1，如为空则代表不限制，此外：支持网络掩码的配置方式。
     * 如果有多个ip，以英文逗号[,]隔开。
     *
     * Generated from protobuf field <code>string allowed_ip = 7;</code>
     * @return string
     */
    public function getAllowedIp()
    {
        return $this->allowed_ip;
    }

    /**
     * site server的innerAPI允许的pluginServer地址。
     * 默认为127.0.0.1，如为空则代表不限制，此外：支持网络掩码的配置方式。
     * 如果有多个ip，以英文逗号[,]隔开。
     *
     * Generated from protobuf field <code>string allowed_ip = 7;</code>
     * @param string $var
     * @return $this
     */
    public function setAllowedIp($var)
    {
        GPBUtil::checkString($var, True);
        $this->allowed_ip = $var;

        return $this;
    }

    /**
     * 扩展的位置【应该为一个枚举】
     * 值：首页、消息帧
     * 本次不允许首页并且消息帧这个类型。
     *
     * Generated from protobuf field <code>.core.PluginPosition position = 8;</code>
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * 扩展的位置【应该为一个枚举】
     * 值：首页、消息帧
     * 本次不允许首页并且消息帧这个类型。
     *
     * Generated from protobuf field <code>.core.PluginPosition position = 8;</code>
     * @param int $var
     * @return $this
     */
    public function setPosition($var)
    {
        GPBUtil::checkEnum($var, \Zaly\Services\PluginPosition::class);
        $this->position = $var;

        return $this;
    }

    /**
     * 显示顺序
     * 当一个位置，有多个扩展时，此处描述顺序，数字越小，排列越靠前（从上往下，从左往右排列）
     *
     * Generated from protobuf field <code>int32 order = 9;</code>
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * 显示顺序
     * 当一个位置，有多个扩展时，此处描述顺序，数字越小，排列越靠前（从上往下，从左往右排列）
     *
     * Generated from protobuf field <code>int32 order = 9;</code>
     * @param int $var
     * @return $this
     */
    public function setOrder($var)
    {
        GPBUtil::checkInt32($var);
        $this->order = $var;

        return $this;
    }

    /**
     * 展现方式【应该为一个枚举】
     * 默认、浮屏、分屏
     * 目前写死【默认】
     *
     * Generated from protobuf field <code>.core.PluginDisplayMode display_mode = 10;</code>
     * @return int
     */
    public function getDisplayMode()
    {
        return $this->display_mode;
    }

    /**
     * 展现方式【应该为一个枚举】
     * 默认、浮屏、分屏
     * 目前写死【默认】
     *
     * Generated from protobuf field <code>.core.PluginDisplayMode display_mode = 10;</code>
     * @param int $var
     * @return $this
     */
    public function setDisplayMode($var)
    {
        GPBUtil::checkEnum($var, \Zaly\Services\PluginDisplayMode::class);
        $this->display_mode = $var;

        return $this;
    }

    /**
     * 可用状态
     * - 禁用
     * - 管理员可用
     * - 全员可用
     *
     * Generated from protobuf field <code>.core.PermissionStatus permission_status = 11;</code>
     * @return int
     */
    public function getPermissionStatus()
    {
        return $this->permission_status;
    }

    /**
     * 可用状态
     * - 禁用
     * - 管理员可用
     * - 全员可用
     *
     * Generated from protobuf field <code>.core.PermissionStatus permission_status = 11;</code>
     * @param int $var
     * @return $this
     */
    public function setPermissionStatus($var)
    {
        GPBUtil::checkEnum($var, \Zaly\Services\PermissionStatus::class);
        $this->permission_status = $var;

        return $this;
    }

}
