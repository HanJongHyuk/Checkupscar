<?php

/**
 * @copyright Copyright (c) 2009-2020 ThemeCatcher (https://www.themecatcher.net)
 */
class Quform_Filter_Regex extends Quform_Filter_Abstract
{
    /**
     * Filter any characters matched by the set regular expression pattern
     *
     * If the value provided is not a string, the value will remain unfiltered
     *
     * @param   string  $value  The value to filter
     * @return  string          The filtered value
     */
    public function filter($value)
    {
        if ( ! is_string($value)) {
            return $value;
        }

        if (Quform::isNonEmptyString($this->config('pattern'))) {
            $value = preg_replace($this->config('pattern'), '', $value);
        }

        return $value;
    }

    /**
     * Get the default config for this filter
     *
     * @param   string|null  $key  Get the config by key, if omitted the full config is returned
     * @return  array
     */
    public static function getDefaultConfig($key = null)
    {
        $config = apply_filters('quform_default_config_filter_regex', array(
            'pattern' => ''
        ));

        $config['type'] = 'regex';

        if (Quform::isNonEmptyString($key)) {
            return Quform::get($config, $key);
        }

        return $config;
    }
}