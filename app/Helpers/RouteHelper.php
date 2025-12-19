<?php

if (!function_exists('localized_route')) {
    /**
     * Generate a URL to a named route with automatic locale parameter.
     *
     * @param  string  $name
     * @param  mixed  $parameters
     * @param  bool  $absolute
     * @return string
     */
    function localized_route($name, $parameters = [], $absolute = true)
    {
        // Handle different parameter types
        if (is_object($parameters)) {
            // If it's a model object, pass it directly with locale
            $parameters = ['locale' => app()->getLocale(), $parameters];
        } elseif (!is_array($parameters)) {
            // If it's a scalar value, convert to array
            $parameters = ['locale' => app()->getLocale(), $parameters];
        } else {
            // It's already an array, just add locale if not present
            if (!isset($parameters['locale'])) {
                $parameters = array_merge(['locale' => app()->getLocale()], $parameters);
            }
        }

        return route($name, $parameters, $absolute);
    }
}
