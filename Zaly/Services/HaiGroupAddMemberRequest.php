<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_group_addMember.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiGroupAddMemberRequest</code>
 */
class HaiGroupAddMemberRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *群组ID
     *
     * Generated from protobuf field <code>string group_id = 1;</code>
     */
    private $group_id = '';
    /**
     *群组中需要增加的用户ID
     *
     * Generated from protobuf field <code>repeated string group_member = 2;</code>
     */
    private $group_member;

    public function __construct() {
        \GPBMetadata\Plugin\HaiGroupAddMember::initOnce();
        parent::__construct();
    }

    /**
     *群组ID
     *
     * Generated from protobuf field <code>string group_id = 1;</code>
     * @return string
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     *群组ID
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

    /**
     *群组中需要增加的用户ID
     *
     * Generated from protobuf field <code>repeated string group_member = 2;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getGroupMember()
    {
        return $this->group_member;
    }

    /**
     *群组中需要增加的用户ID
     *
     * Generated from protobuf field <code>repeated string group_member = 2;</code>
     * @param string[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setGroupMember($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::STRING);
        $this->group_member = $arr;

        return $this;
    }

}

