<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_group_members.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiGroupMembersRequest</code>
 */
class HaiGroupMembersRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *群组ID
     *
     * Generated from protobuf field <code>string group_id = 1;</code>
     */
    private $group_id = '';
    /**
     *分页：第几页
     *
     * Generated from protobuf field <code>int32 page_number = 2;</code>
     */
    private $page_number = 0;
    /**
     *分页：每页条数
     *
     * Generated from protobuf field <code>int32 page_size = 3;</code>
     */
    private $page_size = 0;

    public function __construct() {
        \GPBMetadata\Plugin\HaiGroupMembers::initOnce();
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
     *分页：第几页
     *
     * Generated from protobuf field <code>int32 page_number = 2;</code>
     * @return int
     */
    public function getPageNumber()
    {
        return $this->page_number;
    }

    /**
     *分页：第几页
     *
     * Generated from protobuf field <code>int32 page_number = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setPageNumber($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_number = $var;

        return $this;
    }

    /**
     *分页：每页条数
     *
     * Generated from protobuf field <code>int32 page_size = 3;</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     *分页：每页条数
     *
     * Generated from protobuf field <code>int32 page_size = 3;</code>
     * @param int $var
     * @return $this
     */
    public function setPageSize($var)
    {
        GPBUtil::checkInt32($var);
        $this->page_size = $var;

        return $this;
    }

}

