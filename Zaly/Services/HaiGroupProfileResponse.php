<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_group_profile.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiGroupProfileResponse</code>
 */
class HaiGroupProfileResponse extends \Google\Protobuf\Internal\Message
{
    /**
     *群组资料页信息
     *
     * Generated from protobuf field <code>.core.GroupProfile profile = 1;</code>
     */
    private $profile = null;

    public function __construct() {
        \GPBMetadata\Plugin\HaiGroupProfile::initOnce();
        parent::__construct();
    }

    /**
     *群组资料页信息
     *
     * Generated from protobuf field <code>.core.GroupProfile profile = 1;</code>
     * @return \Zaly\Services\GroupProfile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     *群组资料页信息
     *
     * Generated from protobuf field <code>.core.GroupProfile profile = 1;</code>
     * @param \Zaly\Services\GroupProfile $var
     * @return $this
     */
    public function setProfile($var)
    {
        GPBUtil::checkMessage($var, \Zaly\Services\GroupProfile::class);
        $this->profile = $var;

        return $this;
    }

}
