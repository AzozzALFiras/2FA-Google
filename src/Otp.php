<?php

namespace AzozzAlfiras\TwoFactorAuth;

class Otp
{
    private $secretKey;

    public function __construct($secretKey)
    {
        $this->secretKey = $secretKey;
    }

    public function generateOtp()
    {
        $time = floor(time() / 30); // Time step is 30 seconds
        $secretKey = Base32::decode($this->secretKey);
        $time = pack('N*', 0) . pack('N*', $time); // Time as a 64-bit integer

        // HMAC-SHA1
        $hmac = hash_hmac('sha1', $time, $secretKey, true);
        $offset = ord($hmac[19]) & 0x0F;
        $code = (ord($hmac[$offset]) & 0x7F) << 24
            | (ord($hmac[$offset + 1]) & 0xFF) << 16
            | (ord($hmac[$offset + 2]) & 0xFF) << 8
            | (ord($hmac[$offset + 3]) & 0xFF);

        // Truncate the result to a 6-digit OTP
        return str_pad($code % 1000000, 6, '0', STR_PAD_LEFT);
    }

    public function verifyOtp($enteredOtp)
    {
        // Generate OTP from the secret key
        $generatedOtp = $this->generateOtp();

        // Compare entered OTP with generated OTP
        return $enteredOtp === $generatedOtp;
    }


}
