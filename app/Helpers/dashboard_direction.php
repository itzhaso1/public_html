<?php

/**
 * check app locale and change class from bottom-start to bottom-end
 * if app locale is arabic change class from bottom-start to bottom-end else change class from bottom-end to bottom-start
 */
if (! function_exists('bottomStartDirectionClass')) {
    function bottomStartDirectionClass()
    {
        $class = 'bottom-start';
        if (app()->getLocale() == 'ar') {
            $class = 'bottom-end';
        }

        return $class;
    }
}

if (! function_exists('bottomEndDirectionClass')) {
    function bottomEndDirectionClass()
    {
        $class = 'bottom-end';
        if (app()->getLocale() == 'ar') {
            $class = 'bottom-start';
        }

        return $class;
    }
}

if (! function_exists('rightStartDirectionClass')) {
    function rightStartDirectionClass()
    {
        $class = 'right-start';
        if (app()->getLocale() == 'ar') {
            $class = 'left-start';
        }

        return $class;
    }
}

if (! function_exists('leftStartDirectionClass')) {
    function leftStartDirectionClass()
    {
        $class = 'left-start';
        if (app()->getLocale() == 'ar') {
            $class = 'right-start';
        }

        return $class;
    }
}
