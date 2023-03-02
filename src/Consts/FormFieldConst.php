<?php

namespace Cblink\Service\FormSchema\Consts;

class FormFieldConst
{
    public const TYPE_FORM = 'form';
    public const TYPE_TRADE = 'trade';
    public const TYPE_DECORATE = 'decorate';

    public const TYPES = [
        self::TYPE_FORM => '表单字段/组件',
        self::TYPE_TRADE => '业务字段/组件（后端）',
        self::TYPE_DECORATE => '装修组件',
    ];

}