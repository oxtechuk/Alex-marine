<?php

namespace App\Helpers;

class WhatsAppHelper
{
    /**
     * Clean and format phone number for WhatsApp international URL.
     */
    public static function cleanPhone(?string $phone): string
    {
        if (empty($phone)) {
            return '';
        }

        // Strip non-digit characters
        $cleaned = preg_replace('/[^\d]/', '', $phone);

        // Convert common Egyptian phone formats
        if (str_starts_with($cleaned, '0020')) {
            $cleaned = substr($cleaned, 2);
        } elseif (str_starts_with($cleaned, '01')) {
            $cleaned = '20'.substr($cleaned, 1);
        } elseif (str_starts_with($cleaned, '1') && strlen($cleaned) === 10) {
            $cleaned = '20'.$cleaned;
        }

        return $cleaned;
    }

    /**
     * Generate direct WhatsApp link with pre-filled message.
     */
    public static function link(?string $phone, string $message = ''): string
    {
        $clean = self::cleanPhone($phone);
        if (empty($clean)) {
            return '#';
        }

        $url = 'https://wa.me/'.$clean;
        if (! empty($message)) {
            $url .= '?text='.urlencode($message);
        }

        return $url;
    }
}
