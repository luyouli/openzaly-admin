<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_plugin_list.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiPluginListResponse</code>
 */
class HaiPluginListResponse extends \Google\Protobuf\Internal\Message
{
    /**
     *获取插件列表数据
     *
     * Generated from protobuf field <code>repeated .core.Plugin plugin = 1;</code>
     */
    private $plugin;

    public function __construct() {
        \GPBMetadata\Plugin\HaiPluginList::initOnce();
        parent::__construct();
    }

    /**
     *获取插件列表数据
     *
     * Generated from protobuf field <code>repeated .core.Plugin plugin = 1;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     *获取插件列表数据
     *
     * Generated from protobuf field <code>repeated .core.Plugin plugin = 1;</code>
     * @param \Zaly\Services\Plugin[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setPlugin($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Zaly\Services\Plugin::class);
        $this->plugin = $arr;

        return $this;
    }

}

