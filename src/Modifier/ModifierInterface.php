<?php

namespace App\Modifier;

/**
 * Interface ModifierInterface
 * @package App\Modifier
 */
interface ModifierInterface
{
    public function modify(string $field, $value, object $object);
}