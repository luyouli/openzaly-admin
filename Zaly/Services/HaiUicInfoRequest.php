<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_uic_info.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiUicInfoRequest</code>
 */
class HaiUicInfoRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *当前uic的id
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     */
    private $id = 0;
    /**
     *uic
     *
     * Generated from protobuf field <code>string uic = 2;</code>
     */
    private $uic = '';

    public function __construct() {
        \GPBMetadata\Plugin\HaiUicInfo::initOnce();
        parent::__construct();
    }

    /**
     *当前uic的id
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *当前uic的id
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setId($var)
    {
        GPBUtil::checkInt32($var);
        $this->id = $var;

        return $this;
    }

    /**
     *uic
     *
     * Generated from protobuf field <code>string uic = 2;</code>
     * @return string
     */
    public function getUic()
    {
        return $this->uic;
    }

    /**
     *uic
     *
     * Generated from protobuf field <code>string uic = 2;</code>
     * @param string $var
     * @return $this
     */
    public function setUic($var)
    {
        GPBUtil::checkString($var, True);
        $this->uic = $var;

        return $this;
    }

}
