<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_user_sealUp.proto

namespace GPBMetadata\Plugin;

class HaiUserSealUp
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Core\User::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0ab5020a1c706c7567696e2f6861695f757365725f7365616c55702e7072" .
            "6f746f1206706c7567696e224e0a14486169557365725365616c55705265" .
            "717565737412140a0c736974655f757365725f696418012001280912200a" .
            "0673746174757318022001280e32102e636f72652e557365725374617475" .
            "7322170a15486169557365725365616c5570526573706f6e7365325d0a14" .
            "486169557365725365616c55705365727669636512450a067365616c5570" .
            "121c2e706c7567696e2e486169557365725365616c557052657175657374" .
            "1a1d2e706c7567696e2e486169557365725365616c5570526573706f6e73" .
            "65423d0a17636f6d2e616b6178696e2e70726f746f2e706c7567696e4212" .
            "486169557365725365616c557050726f746fca020d5a616c795c53657276" .
            "69636573620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

