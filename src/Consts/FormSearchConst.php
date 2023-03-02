<?php

namespace Cblink\Service\FormSchema\Consts;

class FormSearchConst
{
    public const TYPE_EQ = 'eq';
    public const TYPE_IN = 'in';
    public const TYPE_KEYWORD = 'keyword';
    public const TYPE_DATE = 'date';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_LT = 'lt';
    public const TYPE_GT = 'gt';
    public const TYPE_LTE = 'lte';
    public const TYPE_GTE = 'gte';

    const TYPES = [
        self::TYPE_EQ,
        self::TYPE_IN,
        self::TYPE_KEYWORD,
        self::TYPE_DATE,
        self::TYPE_DATETIME,
        self::TYPE_LT,
        self::TYPE_GT,
        self::TYPE_LTE,
        self::TYPE_GTE,
    ];
}