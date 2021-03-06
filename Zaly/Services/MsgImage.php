<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/core.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *普通图片消息
 *
 * Generated from protobuf message <code>core.MsgImage</code>
 */
class MsgImage extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string msg_id = 1;</code>
     */
    private $msg_id = '';
    /**
     * Generated from protobuf field <code>string site_user_id = 2;</code>
     */
    private $site_user_id = '';
    /**
     * Generated from protobuf field <code>string site_friend_id = 3;</code>
     */
    private $site_friend_id = '';
    /**
     * Generated from protobuf field <code>string imageId = 4;</code>
     */
    private $imageId = '';
    /**
     *消息时间，单位ms
     *
     * Generated from protobuf field <code>int64 time = 7;</code>
     */
    private $time = 0;

    public function __construct() {
        \GPBMetadata\Core\Core::initOnce();
        parent::__construct();
    }

    /**
     * Generated from protobuf field <code>string msg_id = 1;</code>
     * @return string
     */
    public function getMsgId()
    {
        return $this->msg_id;
    }

    /**
     * Generated from protobuf field <code>string msg_id = 1;</code>
     * @param string $var
     * @return $this
     */
    public function setMsgId($var)
    {
        GPBUtil::checkString($var, True);
        $this->msg_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string site_user_id = 2;</code>
     * @return string
     */
    public function getSiteUserId()
    {
        return $this->site_user_id;
    }

    /**
     * Generated from protobuf field <code>string site_user_id = 2;</code>
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
     * Generated from protobuf field <code>string site_friend_id = 3;</code>
     * @return string
     */
    public function getSiteFriendId()
    {
        return $this->site_friend_id;
    }

    /**
     * Generated from protobuf field <code>string site_friend_id = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSiteFriendId($var)
    {
        GPBUtil::checkString($var, True);
        $this->site_friend_id = $var;

        return $this;
    }

    /**
     * Generated from protobuf field <code>string imageId = 4;</code>
     * @return string
     */
    public function getImageId()
    {
        return $this->imageId;
    }

    /**
     * Generated from protobuf field <code>string imageId = 4;</code>
     * @param string $var
     * @return $this
     */
    public function setImageId($var)
    {
        GPBUtil::checkString($var, True);
        $this->imageId = $var;

        return $this;
    }

    /**
     *消息时间，单位ms
     *
     * Generated from protobuf field <code>int64 time = 7;</code>
     * @return int|string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     *消息时间，单位ms
     *
     * Generated from protobuf field <code>int64 time = 7;</code>
     * @param int|string $var
     * @return $this
     */
    public function setTime($var)
    {
        GPBUtil::checkInt64($var);
        $this->time = $var;

        return $this;
    }

}

