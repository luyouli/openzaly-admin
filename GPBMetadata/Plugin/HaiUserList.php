<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: plugin/hai_user_list.proto

namespace GPBMetadata\Plugin;

class HaiUserList
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Core\User::initOnce();
        $pool->internalAddGeneratedFile(hex2bin(
            "0ac4020a1a706c7567696e2f6861695f757365725f6c6973742e70726f74" .
            "6f1206706c7567696e223c0a12486169557365724c697374526571756573" .
            "7412130a0b706167655f6e756d62657218012001280512110a0970616765" .
            "5f73697a6518022001280522440a13486169557365724c69737452657370" .
            "6f6e7365122d0a0c757365725f70726f66696c6518012003280b32172e63" .
            "6f72652e53696d706c655573657250726f66696c6532550a124861695573" .
            "65724c69737453657276696365123f0a046c697374121a2e706c7567696e" .
            "2e486169557365724c697374526571756573741a1b2e706c7567696e2e48" .
            "6169557365724c697374526573706f6e7365423b0a17636f6d2e616b6178" .
            "696e2e70726f746f2e706c7567696e4210486169557365724c6973745072" .
            "6f746fca020d5a616c795c5365727669636573620670726f746f33"
        ));

        static::$is_initialized = true;
    }
}

