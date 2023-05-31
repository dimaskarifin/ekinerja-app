<?php

namespace App\Helpers;

class NavigationHelper
{
    public static function isActive(...$uris)
    {
        $currentUri = service('request')->uri;
        foreach ($uris as $uri) {
            if ($currentUri->getPath() == $uri) {
                return 'active';
            }
        }
        return '';
    }
}
