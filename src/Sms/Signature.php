<?php
namespace AestronSdk\Sms;

class Signature {
    public static function sha1($string)
    {
        return sha1($string, true);
    }
}