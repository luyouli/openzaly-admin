<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_plugin_add.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiPluginAddRequest</code>
 */
class HaiPluginAddRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *需要增加的插件
     *
     * Generated from protobuf field <code>.core.Plugin plugin = 1;</code>
     */
    private $plugin = null;

    public function __construct() {
        \GPBMetadata\Plugin\HaiPluginAdd::initOnce();
        parent::__construct();
    }

    /**
     *需要增加的插件
     *
     * Generated from protobuf field <code>.core.Plugin plugin = 1;</code>
     * @return \Zaly\Services\Plugin
     */
    public function getPlugin()
    {
        return $this->plugin;
    }

    /**
     *需要增加的插件
     *
     * Generated from protobuf field <code>.core.Plugin plugin = 1;</code>
     * @param \Zaly\Services\Plugin $var
     * @return $this
     */
    public function setPlugin($var)
    {
        GPBUtil::checkMessage($var, \Zaly\Services\Plugin::class);
        $this->plugin = $var;

        return $this;
    }

}

