<?php

namespace Fast\Base\Traits;

use Fast\Base\Supports\Enum;

trait EnumCastable
{
    /**
     * @param $key
     * @param $value
     * @return mixed
     */
    protected function castAttribute($key, $value)
    {
        $castedValue = parent::castAttribute($key, $value);

        if ($castedValue === $value && !is_object($value)) {
            $castType = $this->getCasts()[$key];
            if (class_exists($castType) and is_subclass_of($castType, Enum::class)) {
                $castedValue = new $castType($value);
            }
        }

        return $castedValue;
    }
}
