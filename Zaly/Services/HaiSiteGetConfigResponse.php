<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_site_getConfig.proto

namespace Zaly\Services;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * Generated from protobuf message <code>plugin.HaiSiteGetConfigResponse</code>
 */
class HaiSiteGetConfigResponse extends \Google\Protobuf\Internal\Message
{
    /**
     *信息配置，Key为SiteConfigKey
     *
     * Generated from protobuf field <code>.core.SiteBackConfig site_config = 1;</code>
     */
    private $site_config = null;

    public function __construct() {
        \GPBMetadata\Plugin\HaiSiteGetConfig::initOnce();
        parent::__construct();
    }

    /**
     *信息配置，Key为SiteConfigKey
     *
     * Generated from protobuf field <code>.core.SiteBackConfig site_config = 1;</code>
     * @return \Zaly\Services\SiteBackConfig
     */
    public function getSiteConfig()
    {
        return $this->site_config;
    }

    /**
     *信息配置，Key为SiteConfigKey
     *
     * Generated from protobuf field <code>.core.SiteBackConfig site_config = 1;</code>
     * @param \Zaly\Services\SiteBackConfig $var
     * @return $this
     */
    public function setSiteConfig($var)
    {
        GPBUtil::checkMessage($var, \Zaly\Services\SiteBackConfig::class);
        $this->site_config = $var;

        return $this;
    }

}

