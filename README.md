# AzozzAlfiras 2FA Google - PHP Package

This PHP package provides a simple implementation for Google 2-Factor Authentication (2FA) using the Time-based One-Time Password (TOTP) algorithm. It includes functionalities for generating OTPs, verifying OTPs, and creating QR codes for authentication setup.

## Installation

You can install this package via Composer:

```bash
composer require azozzalfiras/2fa-google
```

## Usage

### Setup and Configuration

To use this package, instantiate the `TwoFactorAuth` class with the secret key, user, and issuer. Optionally, you can customize the user and issuer values.

```php
<?php

use AzozzAlfiras\TwoFactorAuth\TwoFactorAuth;

// Create a new instance of TwoFactorAuth without passing email and issuer initially
$twoFactorAuth = new TwoFactorAuth();  // Constructor does not require parameters anymore

// Generate or get the secret key externally (e.g., stored or retrieved from a database)
$generatedSecretKey = $twoFactorAuth->getSecretKey();  // This will get the generated secret key

// Initialize the object with secretKey, email, and issuer
$twoFactorAuth->initialize($generatedSecretKey, 'user@example.com', 'MyAppIssuer');

// Generate the QR code URL
$qrCodeUrl = $twoFactorAuth->generateQrCodeUrl();
echo "QR Code URL: " . $qrCodeUrl . "\n";
```

### Step-by-step Usage

To use the `Otp` class from the **AzozzAlfiras\TwoFactorAuth** namespace, follow these steps:

1. **Instantiate the Otp Class**: First, you need to create an instance of the `Otp` class. This class requires the secret key (Base32 encoded) as a parameter.
2. **Generate OTP**: Use the `generateOtp()` method to generate a one-time password (OTP) based on the provided secret key.
3. **Verify OTP**: Use the `verifyOtp()` method to verify if the entered OTP matches the generated OTP.
4. **Generate QR Code URL**: Use the `generateQrCodeUrl()` method to generate the URL needed to generate the QR code for Google Authenticator.

## Features

- **Instantiate the Otp Class**: Create an instance of the `Otp` class with the secret key.
- **Generate OTP**: Generate a one-time password using the `generateOtp()` method.
- **Verify OTP**: Verify the OTP using the `verifyOtp()` method.
- **Generate QR Code URL**: Generate the URL for the QR code using the `generateQrCodeUrl()` method.

## Example Usage

```php
<?php

require 'vendor/autoload.php'; // Include Composer autoload if you're using Composer

use AzozzAlfiras\TwoFactorAuth\Otp;

// Define the secret key (Base32 encoded secret)
$secretKey = ''; // get the secretKey from .env  

// Create an instance of the Otp class
$otp = new Otp($secretKey);

// Generate OTP
$generatedOtp = $otp->generateOtp();
echo "Generated OTP: " . $generatedOtp . "\n";

// Verify the OTP (for example, entered by the user)
$enteredOtp = '123456';  // Replace with the OTP entered by the user
$isVerified = $otp->verifyOtp($enteredOtp);

if ($isVerified) {
    echo "OTP is valid!\n";
} else {
    echo "Invalid OTP!\n";
}
?>
```

## Explanation

- **Instantiate Otp**: The `Otp` class requires a Base32 encoded secret key. This secret key can be generated using the `TwoFactorAuth` class and is used to generate and verify OTPs.
- **Generate OTP**: The `generateOtp()` method calculates a one-time password based on the current time and the secret key.
- **Verify OTP**: The `verifyOtp()` method compares the OTP entered by the user with the generated OTP to confirm its validity.
- **Generate QR Code URL**: The `generateQrCodeUrl()` method provides a URL that can be used to generate a QR code for the user to scan using Google Authenticator or another authenticator app.

## License

This package is open-source and available under the MIT License.

### Key Highlights

- Sections like **Installation**, **Usage**, **Features**, and **Example Usage** are clearly defined with headers.
- Code examples are surrounded by triple backticks (```), making it easy to copy and understand.
- The **Step-by-step Usage** section explains each part of the process clearly.
- The **Features** section outlines the key functionalities of the package.

This `README.md` should provide everything needed for a user to understand, install, and use the package effectively.
