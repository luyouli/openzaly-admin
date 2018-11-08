<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_group_profile.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiGroupProfileRequest</code>
 */
class HaiGroupProfileRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *当前用户获取群组ID的资料信息
     *
     * Generated from protobuf field <code>string group_id = 1;</code>
     */
    private $group_id = '';

    public function __construct() {
        \GPBMetadata\Plugin\HaiGroupProfile::initOnce();
        parent::__construct();
    }

    /**
     *当前用户获取群组ID的资料信息
     *
     * Generated from protobuf field <code>string group_id = 1;</code>
     * @return string
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     *当前用户获取群组ID的资料信息
     *
     * Generated from protobuf field <code>string group_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setGroupId($var)
    {
        GPBUtil::checkString($var, True);
        $this->group_id = $var;

        return $this;
    }

}

