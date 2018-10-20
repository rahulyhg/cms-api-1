<?php

namespace Application\Service;

class Utility
{
    const ERR_CODE_INVALID_PARAMETER = 100;
    const ERR_MSG_INVALID_PARAMETER = 'Invalid Parameters';

    /**
     * @param array $ids
     *
     * @internal param int[] $items
     */
    public static function isArrayOfIds(array $ids): void
    {
        $filtered = array_filter($ids, function($id) {
            return is_int($id) && $id > 0;
        });
        if ($ids !== $filtered) {
            throw new \RuntimeException(static::ERR_MSG_INVALID_PARAMETER, static::ERR_CODE_INVALID_PARAMETER);
        }
    }

    /**
     * Dump variable and Die
     *
     * @param      $variable
     * @param bool $isDie
     */
    public static function D($variable, bool $isDie = true): void
    {
        var_dump($variable);
        if ($isDie) {
            die;
        }
    }
}
