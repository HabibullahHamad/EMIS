<?php

use Illuminate\Support\Facades\App;

if (! function_exists('isRtl')) {
    function isRtl(): bool
    {
        return in_array(App::getLocale(), ['ps', 'fa']);
    }
}

if (! function_exists('htmlDir')) {
    function htmlDir(): string
    {
        return isRtl() ? 'rtl' : 'ltr';
    }
}

if (! function_exists('htmlLang')) {
    function htmlLang(): string
    {
        return App::getLocale();
    }
}

if (! function_exists('textStart')) {
    function textStart(): string
    {
        return isRtl() ? 'text-end' : 'text-start';
    }
}

if (! function_exists('textEnd')) {
    function textEnd(): string
    {
        return isRtl() ? 'text-start' : 'text-end';
    }
}

if (! function_exists('floatStart')) {
    function floatStart(): string
    {
        return isRtl() ? 'float-end' : 'float-start';
    }
}

if (! function_exists('floatEnd')) {
    function floatEnd(): string
    {
        return isRtl() ? 'float-start' : 'float-end';
    }
}

if (! function_exists('marginStart')) {
    function marginStart(string $size = '2'): string
    {
        return isRtl() ? "me-$size" : "ms-$size";
    }
}

if (! function_exists('marginEnd')) {
    function marginEnd(string $size = '2'): string
    {
        return isRtl() ? "ms-$size" : "me-$size";
    }
}

if (! function_exists('paddingStart')) {
    function paddingStart(string $size = '2'): string
    {
        return isRtl() ? "pe-$size" : "ps-$size";
    }
}

if (! function_exists('paddingEnd')) {
    function paddingEnd(string $size = '2'): string
    {
        return isRtl() ? "ps-$size" : "pe-$size";
    }
}