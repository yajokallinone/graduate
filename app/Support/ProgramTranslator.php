<?php

namespace App\Support;

class ProgramTranslator
{
    /**
     * Get translated value from program/plan item
     * Handles both string values and arrays (which become <ul><li> lists)
     *
     * @param array $item
     * @param string $key
     * @param string|null $lang (use locale() if null)
     * @return string
     */
    public static function translate($item, $key, $lang = null)
    {
        $lang = $lang ?? app()->getLocale();

        // Try the locale-specific key first
        if ($lang === 'en') {
            $keyEn = $key . '_en';
            if (isset($item[$keyEn])) {
                return static::formatValue($item[$keyEn]);
            }
        }

        // Fallback to base key
        if (isset($item[$key])) {
            return static::formatValue($item[$key]);
        }

        return '';
    }

    /**
     * Format value: arrays become <ul><li> lists, strings stay as-is
     *
     * @param mixed $value
     * @return string
     */
    private static function formatValue($value)
    {
        if (is_array($value)) {
            return '<ul><li>' . implode('</li><li>', $value) . '</li></ul>';
        }
        return $value;
    }
}
