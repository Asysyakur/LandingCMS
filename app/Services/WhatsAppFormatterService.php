<?php

namespace App\Services;

class WhatsAppFormatterService
{
    /**
     * Format phone number to WhatsApp click-to-chat link
     *
     * @param string $phoneNumber
     * @param string|null $message
     * @return string
     */
    public static function formatWhatsAppLink(string $phoneNumber, ?string $message = null): string
    {
        // Clean phone number
        $cleanNumber = self::cleanPhoneNumber($phoneNumber);
        
        // Build base URL
        $url = 'https://wa.me/' . $cleanNumber;
        
        // Add message if provided
        if ($message) {
            $url .= '?text=' . urlencode($message);
        }
        
        return $url;
    }
    
    /**
     * Clean and validate phone number
     *
     * @param string $phoneNumber
     * @return string
     */
    public static function cleanPhoneNumber(string $phoneNumber): string
    {
        // Remove all non-numeric characters
        $cleanNumber = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Remove leading zeros
        $cleanNumber = ltrim($cleanNumber, '0');
        
        // Add country code if missing (assuming Indonesia +62)
        if (strlen($cleanNumber) <= 12 && strlen($cleanNumber) >= 9) {
            // Check if it's an Indonesian number without country code
            if (substr($cleanNumber, 0, 1) === '8') {
                $cleanNumber = '62' . $cleanNumber;
            }
        }
        
        return $cleanNumber;
    }
    
    /**
     * Validate phone number
     *
     * @param string $phoneNumber
     * @return array
     */
    public static function validatePhoneNumber(string $phoneNumber): array
    {
        $cleanNumber = self::cleanPhoneNumber($phoneNumber);
        
        // Basic validation
        if (empty($cleanNumber)) {
            return [
                'valid' => false,
                'error' => 'Phone number cannot be empty'
            ];
        }
        
        // Check minimum length (including country code)
        if (strlen($cleanNumber) < 10) {
            return [
                'valid' => false,
                'error' => 'Phone number is too short'
            ];
        }
        
        // Check maximum length
        if (strlen($cleanNumber) > 15) {
            return [
                'valid' => false,
                'error' => 'Phone number is too long'
            ];
        }
        
        // Check if it starts with valid country code
        $validCountryCodes = ['62', '1', '44', '91', '81', '86', '49', '33', '39', '34'];
        $countryCode = substr($cleanNumber, 0, 2);
        
        if (!in_array($countryCode, $validCountryCodes)) {
            return [
                'valid' => false,
                'error' => 'Invalid country code. Supported: ' . implode(', ', $validCountryCodes)
            ];
        }
        
        return [
            'valid' => true,
            'clean_number' => $cleanNumber,
            'formatted' => self::formatPhoneNumber($cleanNumber)
        ];
    }
    
    /**
     * Format phone number for display
     *
     * @param string $phoneNumber
     * @return string
     */
    public static function formatPhoneNumber(string $phoneNumber): string
    {
        $cleanNumber = self::cleanPhoneNumber($phoneNumber);
        
        // Format Indonesian numbers
        if (substr($cleanNumber, 0, 2) === '62') {
            $localNumber = substr($cleanNumber, 2);
            
            if (strlen($localNumber) === 11) {
                // Format: +62 812-3456-7890
                return '+62 ' . substr($localNumber, 0, 3) . '-' . substr($localNumber, 3, 4) . '-' . substr($localNumber, 7);
            } elseif (strlen($localNumber) === 10) {
                // Format: +62 812-3456-789
                return '+62 ' . substr($localNumber, 0, 3) . '-' . substr($localNumber, 3, 4) . '-' . substr($localNumber, 7);
            } else {
                return '+62 ' . $localNumber;
            }
        }
        
        // Format US numbers
        if (substr($cleanNumber, 0, 1) === '1' && strlen($cleanNumber) === 11) {
            $areaCode = substr($cleanNumber, 1, 3);
            $firstThree = substr($cleanNumber, 4, 3);
            $lastFour = substr($cleanNumber, 7);
            
            return '+1 (' . $areaCode . ') ' . $firstThree . '-' . $lastFour;
        }
        
        // Default format
        return '+' . $cleanNumber;
    }
    
    /**
     * Generate WhatsApp share link with pre-filled message
     *
     * @param string $phoneNumber
     * @param string $message
     * @param array $variables
     * @return string
     */
    public static function generateShareLink(string $phoneNumber, string $message, array $variables = []): string
    {
        // Replace variables in message
        $formattedMessage = $message;
        foreach ($variables as $key => $value) {
            $formattedMessage = str_replace('{' . $key . '}', $value, $formattedMessage);
        }
        
        return self::formatWhatsAppLink($phoneNumber, $formattedMessage);
    }
    
    /**
     * Create QR code data for WhatsApp
     *
     * @param string $phoneNumber
     * @param string|null $message
     * @return string
     */
    public static function createQRCodeData(string $phoneNumber, ?string $message = null): string
    {
        return self::formatWhatsAppLink($phoneNumber, $message);
    }
    
    /**
     * Extract phone number from WhatsApp link
     *
     * @param string $whatsappLink
     * @return string|null
     */
    public static function extractPhoneNumber(string $whatsappLink): ?string
    {
        // Parse wa.me links
        if (str_contains($whatsappLink, 'wa.me/')) {
            $parts = parse_url($whatsappLink);
            if (isset($parts['path'])) {
                $phoneNumber = ltrim($parts['path'], '/');
                return $phoneNumber;
            }
        }
        
        // Parse web.whatsapp.com links
        if (str_contains($whatsappLink, 'web.whatsapp.com')) {
            if (preg_match('/phone=([0-9]+)/', $whatsappLink, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }
    
    /**
     * Check if phone number is WhatsApp compatible
     *
     * @param string $phoneNumber
     * @return array
     */
    public static function checkWhatsAppCompatibility(string $phoneNumber): array
    {
        $validation = self::validatePhoneNumber($phoneNumber);
        
        if (!$validation['valid']) {
            return [
                'compatible' => false,
                'reason' => $validation['error']
            ];
        }
        
        $cleanNumber = $validation['clean_number'];
        
        // Check for known incompatible patterns
        $incompatiblePatterns = [
            '/^000/', // Emergency numbers
            '/^123/', // Service numbers
            '/^555/', // Fictional numbers
        ];
        
        foreach ($incompatiblePatterns as $pattern) {
            if (preg_match($pattern, $cleanNumber)) {
                return [
                    'compatible' => false,
                    'reason' => 'Number format not supported by WhatsApp'
                ];
            }
        }
        
        return [
            'compatible' => true,
            'phone_number' => $cleanNumber,
            'whatsapp_link' => self::formatWhatsAppLink($cleanNumber)
        ];
    }
    
    /**
     * Format multiple phone numbers
     *
     * @param array $phoneNumbers
     * @return array
     */
    public static function formatMultipleNumbers(array $phoneNumbers): array
    {
        $results = [];
        
        foreach ($phoneNumbers as $index => $phoneNumber) {
            $results[$index] = [
                'original' => $phoneNumber,
                'validation' => self::validatePhoneNumber($phoneNumber),
                'whatsapp_link' => self::formatWhatsAppLink($phoneNumber)
            ];
        }
        
        return $results;
    }
}
