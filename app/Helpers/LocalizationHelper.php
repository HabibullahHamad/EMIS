<?php

if (!function_exists('htmlLang')) {
    function htmlLang()
    {
        return app()->getLocale();
    }
}

if (!function_exists('htmlDir')) {
    function htmlDir()
    {
        return in_array(app()->getLocale(), ['ps','fa','ar']) ? 'rtl' : 'ltr';
    }
}