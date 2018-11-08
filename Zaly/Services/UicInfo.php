<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/uic.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *最简单的用户信息，用于给别人呈现
 *
 * Generated from protobuf message <code>core.UicInfo</code>
 */
class UicInfo extends \Google\Protobuf\Internal\Message
{
    /**
     *uic_id
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
    /**
     *用户id
     *
     * Generated from protobuf field <code>string site_user_id = 3;</code>
     */
    private $site_user_id = '';
    /**
     *用户名称
     *
     * Generated from protobuf field <code>string user_name = 4;</code>
     */
    private $user_name = '';
    /**
     *是否可用的状态
     *
     * Generated from protobuf field <code>.core.UicStatus status = 5;</code>
     */
    private $status = 0;
    /**
     *生成的时间
     *
     * Generated from protobuf field <code>int64 create_time = 6;</code>
     */
    private $create_time = 0;
    /**
     *使用的时间
     *
     * Generated from protobuf field <code>int64 use_time = 7;</code>
     */
    private $use_time = 0;

    public function __construct() {
        \GPBMetadata\Core\Uic::initOnce();
        parent::__construct();
    }

    /**
     *uic_id
     *
     * Generated from protobuf field <code>int32 id = 1;</code>
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *uic_id
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

    /**
     *用户id
     *
     * Generated from protobuf field <code>string site_user_id = 3;</code>
     * @return string
     */
    public function getSiteUserId()
    {
        return $this->site_user_id;
    }

    /**
     *用户id
     *
     * Generated from protobuf field <code>string site_user_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSiteUserId($var)
    {
        GPBUtil::checkString($var, True);
        $this->site_user_id = $var;

        return $this;
    }

    /**
     *用户名称
     *
     * Generated from protobuf field <code>string user_name = 4;</code>
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     *用户名称
     *
     * Generated from protobuf field <code>string user_name = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setUserName($var)
    {
        GPBUtil::checkString($var, True);
        $this->user_name = $var;

        return $this;
    }

    /**
     *是否可用的状态
     *
     * Generated from protobuf field <code>.core.UicStatus status = 5;</code>
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     *是否可用的状态
     *
     * Generated from protobuf field <code>.core.UicStatus status = 5;</code>
     * @param int $var
     * @return $this
     */
    public function setStatus($var)
    {
        GPBUtil::checkEnum($var, \Zaly\Services\UicStatus::class);
        $this->status = $var;

        return $this;
    }

    /**
     *生成的时间
     *
     * Generated from protobuf field <code>int64 create_time = 6;</code>
     * @return int|string
     */
    public function getCreateTime()
    {
        return $this->create_time;
    }

    /**
     *生成的时间
     *
     * Generated from protobuf field <code>int64 create_time = 6;</code>
     * @param int|string $var
     * @return $this
     */
    public function setCreateTime($var)
    {
        GPBUtil::checkInt64($var);
        $this->create_time = $var;

        return $this;
    }

    /**
     *使用的时间
     *
     * Generated from protobuf field <code>int64 use_time = 7;</code>
     * @return int|string
     */
    public function getUseTime()
    {
        return $this->use_time;
    }

    /**
     *使用的时间
     *
     * Generated from protobuf field <code>int64 use_time = 7;</code>
     * @param int|string $var
     * @return $this
     */
    public function setUseTime($var)
    {
        GPBUtil::checkInt64($var);
        $this->use_time = $var;

        return $this;
    }

}

