<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: core/user.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>core.UserRelationProfile</code>
 */
class UserRelationProfile extends \Google\Protobuf\Internal\Message
{
    /**
     *用户的个人资料
     *
     * Generated from protobuf field <code>.core.SimpleUserProfile profile = 1;</code>
     */
    private $profile = null;
    /**
     *用户A与B的关系
     *
     * Generated from protobuf field <code>.core.UserRelation relation = 2;</code>
     */
    private $relation = 0;

    public function __construct() {
        \GPBMetadata\Core\User::initOnce();
        parent::__construct();
    }

    /**
     *用户的个人资料
     *
     * Generated from protobuf field <code>.core.SimpleUserProfile profile = 1;</code>
     * @return \Zaly\Services\SimpleUserProfile
     */
    public function getProfile()
    {
        return $this->profile;
    }

    /**
     *用户的个人资料
     *
     * Generated from protobuf field <code>.core.SimpleUserProfile profile = 1;</code>
     * @param \Zaly\Services\SimpleUserProfile $var
     * @return $this
     */
    public function setProfile($var)
    {
        GPBUtil::checkMessage($var, \Zaly\Services\SimpleUserProfile::class);
        $this->profile = $var;

        return $this;
    }

    /**
     *用户A与B的关系
     *
     * Generated from protobuf field <code>.core.UserRelation relation = 2;</code>
     * @return int
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     *用户A与B的关系
     *
     * Generated from protobuf field <code>.core.UserRelation relation = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setRelation($var)
    {
        GPBUtil::checkEnum($var, \Zaly\Services\UserRelation::class);
        $this->relation = $var;

        return $this;
    }

}

