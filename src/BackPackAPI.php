<?php

namespace ViralsBackpack\BackPackAPI;

class BackPackAPI
{
    public static function resource($name, $controller, array $options = [])
    {
        return new CrudRouter($name, $controller, $options);
    }
}