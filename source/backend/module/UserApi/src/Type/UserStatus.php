<?php

namespace UserApi\Type;

use ReflectionClass;

class UserStatus
{
    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    static public function toArray() {
        $class = new ReflectionClass(__CLASS__);
        $constants = $class->getConstants();
        return array_values($constants);
    }
}
