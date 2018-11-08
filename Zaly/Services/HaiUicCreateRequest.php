<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_uic_create.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiUicCreateRequest</code>
 */
class HaiUicCreateRequest extends \Google\Protobuf\Internal\Message
{
    /**
     *一次生成的UIC个数
     *
     * Generated from protobuf field <code>int32 uic_number = 1;</code>
     */
    private $uic_number = 0;

    public function __construct() {
        \GPBMetadata\Plugin\HaiUicCreate::initOnce();
        parent::__construct();
    }

    /**
     *一次生成的UIC个数
     *
     * Generated from protobuf field <code>int32 uic_number = 1;</code>
     * @return int
     */
    public function getUicNumber()
    {
        return $this->uic_number;
    }

    /**
     *一次生成的UIC个数
     *
     * Generated from protobuf field <code>int32 uic_number = 1;</code>
     * @param int $var
     * @return $this
     */
    public function setUicNumber($var)
    {
        GPBUtil::checkInt32($var);
        $this->uic_number = $var;

        return $this;
    }

}
