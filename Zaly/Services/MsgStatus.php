<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/core.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 **
 * msg_status:1 发送成功
 * msg_status:0 默认状态
 * msg_status:-1 用户非好友关系，二人消息发送失败
 * msg_status:-2 用户非群成员，群消息发送失败
 *
 * Generated from protobuf message <code>core.MsgStatus</code>
 */
class MsgStatus extends \Google\Protobuf\Internal\Message
{
    /**
     * Generated from protobuf field <code>string msg_id = 1;</code>
     */
    private $msg_id = '';
    /**
     * Generated from protobuf field <code>int32 msg_status = 2;</code>
     */
    private $msg_status = 0;
    /**
     * msg_server_time 等于此条消息在服务器数据库的值
     * 如果是发送成功的状态，此值有效。
     * 为什么不使用服务器下发这条请求时的即时时间？
     * 这样的话，可以脱离状态，随意的重发来保证成功。
     * &#64;since v2
     * &#64;todo 补充v2之前版本对此字段的处理逻辑（默认使用msg_time_send的值）
     *
     * Generated from protobuf field <code>int64 msg_server_time = 3;</code>
     */
    private $msg_server_time = 0;

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
     * Generated from protobuf field <code>int32 msg_status = 2;</code>
     * @return int
     */
    public function getMsgStatus()
    {
        return $this->msg_status;
    }

    /**
     * Generated from protobuf field <code>int32 msg_status = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setMsgStatus($var)
    {
        GPBUtil::checkInt32($var);
        $this->msg_status = $var;

        return $this;
    }

    /**
     * msg_server_time 等于此条消息在服务器数据库的值
     * 如果是发送成功的状态，此值有效。
     * 为什么不使用服务器下发这条请求时的即时时间？
     * 这样的话，可以脱离状态，随意的重发来保证成功。
     * &#64;since v2
     * &#64;todo 补充v2之前版本对此字段的处理逻辑（默认使用msg_time_send的值）
     *
     * Generated from protobuf field <code>int64 msg_server_time = 3;</code>
     * @return int|string
     */
    public function getMsgServerTime()
    {
        return $this->msg_server_time;
    }

    /**
     * msg_server_time 等于此条消息在服务器数据库的值
     * 如果是发送成功的状态，此值有效。
     * 为什么不使用服务器下发这条请求时的即时时间？
     * 这样的话，可以脱离状态，随意的重发来保证成功。
     * &#64;since v2
     * &#64;todo 补充v2之前版本对此字段的处理逻辑（默认使用msg_time_send的值）
     *
     * Generated from protobuf field <code>int64 msg_server_time = 3;</code>
     * @param int|string $var
     * @return $this
     */
    public function setMsgServerTime($var)
    {
        GPBUtil::checkInt64($var);
        $this->msg_server_time = $var;

        return $this;
    }

}
