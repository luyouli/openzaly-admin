<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/core.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 *消息通知：二人消息文本通知消息
 *
 * Generated from protobuf message <code>core.U2MsgNotice</code>
 */
class U2MsgNotice extends \Google\Protobuf\Internal\Message
{
    /**
     *通知可能的发送方
     *
     * Generated from protobuf field <code>string site_user_id = 1;</code>
     */
    private $site_user_id = '';
    /**
     *消息的接收方
     *
     * Generated from protobuf field <code>string site_friend_id = 2;</code>
     */
    private $site_friend_id = '';
    /**
     *消息通知内容
     *
     * Generated from protobuf field <code>bytes text = 3;</code>
     */
    private $text = '';
    /**
     *消息时间，单位ms
     *
     * Generated from protobuf field <code>int64 time = 4;</code>
     */
    private $time = 0;

    public function __construct() {
        \GPBMetadata\Core\Core::initOnce();
        parent::__construct();
    }

    /**
     *通知可能的发送方
     *
     * Generated from protobuf field <code>string site_user_id = 1;</code>
     * @return string
     */
    public function getSiteUserId()
    {
        return $this->site_user_id;
    }

    /**
     *通知可能的发送方
     *
     * Generated from protobuf field <code>string site_user_id = 1;</code>
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
     *消息的接收方
     *
     * Generated from protobuf field <code>string site_friend_id = 2;</code>
     * @return string
     */
    public function getSiteFriendId()
    {
        return $this->site_friend_id;
    }

    /**
     *消息的接收方
     *
     * Generated from protobuf field <code>string site_friend_id = 2;</code>
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
     *消息通知内容
     *
     * Generated from protobuf field <code>bytes text = 3;</code>
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     *消息通知内容
     *
     * Generated from protobuf field <code>bytes text = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setText($var)
    {
        GPBUtil::checkString($var, False);
        $this->text = $var;

        return $this;
    }

    /**
     *消息时间，单位ms
     *
     * Generated from protobuf field <code>int64 time = 4;</code>
     * @return int|string
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     *消息时间，单位ms
     *
     * Generated from protobuf field <code>int64 time = 4;</code>
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

