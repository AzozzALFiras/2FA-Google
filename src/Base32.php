<?php

namespace AzozzAlfiras\TwoFactorAuth;

class Base32
{
    private static $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
    private static $mask = 0b11111;

    public static function encode($data)
    {
        $result = '';
        $buffer = 0;
        $bufferLength = 0;

        for ($i = 0; $i < strlen($data); $i++) {
            $buffer = ($buffer << 8) | ord($data[$i]);
            $bufferLength += 8;

            while ($bufferLength >= 5) {
                $bufferLength -= 5;
                $index = ($buffer >> $bufferLength) & self::$mask;
                $result .= self::$chars[$index];
            }
        }

        if ($bufferLength > 0) {
            $buffer <<= (5 - $bufferLength);
            $index = $buffer & self::$mask;
            $result .= self::$chars[$index];
        }

        return $result;
    }

    public static function decode($base32)
    {
        $lookup = array_flip(str_split(self::$chars));
        $buffer = 0;
        $bufferLength = 0;
        $result = '';

        for ($i = 0; $i < strlen($base32); $i++) {
            $value = $lookup[$base32[$i]];
            $buffer = ($buffer << 5) | $value;
            $bufferLength += 5;

            while ($bufferLength >= 8) {
                $bufferLength -= 8;
                $result .= chr(($buffer >> $bufferLength) & 0xFF);
            }
        }

        return $result;
    }
}
