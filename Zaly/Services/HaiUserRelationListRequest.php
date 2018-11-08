<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_user_relationList.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiUserRelationListRequest</code>
 */
class HaiUserRelationListRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *分页：第几页
     *
     * Generated from protobuf field <code>int32 page_number = 1;</code>
     */
    private $page_number = 0;
    /**
     *分页：每页条数
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     */
    private $page_size = 0;

    public function __construct() {
        \GPBMetadata\Plugin\HaiUserRelationList::initOnce();
        parent::__construct();
    }

    /**
     *分页：第几页
     *
     * Generated from protobuf field <code>int32 page_number = 1;</code>
     * @return int
     */
    public function getPageNumber()
    {
        return $this->page_number;
    }

    /**
     *分页：第几页
     *
     * Generated from protobuf field <code>int32 page_number = 1;</code>
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
     * Generated from protobuf field <code>int32 page_size = 2;</code>
     * @return int
     */
    public function getPageSize()
    {
        return $this->page_size;
    }

    /**
     *分页：每页条数
     *
     * Generated from protobuf field <code>int32 page_size = 2;</code>
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
