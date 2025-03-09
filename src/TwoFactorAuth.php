<?php

namespace AzozzAlfiras\TwoFactorAuth;

class TwoFactorAuth
{
    private $secretKey;
    private $email;
    private $issuer;

    // Constructor is removed, initialization happens via initialize method

    // Method to initialize email, issuer, and secret key
    public function initialize($secretKey = null, $email = null, $issuer = null)
    {
        // Set the email and issuer if provided, otherwise use default values
        $this->email = $email ?? 'default@example.com'; // Default value if email is not passed
        $this->issuer = $issuer ?? 'MyApp'; // Default value if issuer is not passed

        // If no secretKey is provided, generate it
        if (!$secretKey) {
            $this->secretKey = $this->generateSecretKey();
        } else {
            $this->secretKey = $secretKey; // Use the provided secretKey
        }
    }

    // Method to generate a random 16-character secret key
    private function generateSecretKey()
    {
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567';
        $secretKey = '';

        for ($i = 0; $i < 16; $i++) {
            $secretKey .= $characters[random_int(0, 31)];
        }

        return $secretKey;
    }

    // Getter for secretKey
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    // Generates the OTP
    public function generateOtp()
    {
        $otp = new Otp($this->secretKey);
        return $otp->generateOtp();
    }

    // Verifies OTP
    public function verifyOtp($enteredOtp)
    {
        $otp = new Otp($this->secretKey);
        return $otp->verifyOtp($enteredOtp);
    }

    // Generates QR Code URL
    public function generateQrCodeUrl($size = 200)
    {
        $otpauthUrl = "otpauth://totp/{$this->issuer}:{$this->email}?secret={$this->secretKey}&issuer={$this->issuer}";
        $encodedUrl = urlencode($otpauthUrl);
        $qrCodeApiUrl = "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data={$encodedUrl}";
        return $qrCodeApiUrl; // Return the QR Code URL
    }
}
