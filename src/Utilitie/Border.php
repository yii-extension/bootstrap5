<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

final class Border
{
    //additive
    public const BORDER_BOTTOM = 'border-bottom';
    public const BORDER_DEFAULT = 'border';
    public const BORDER_END = 'border-end';
    public const BORDER_START = 'border-start';
    public const BORDER_TOP = 'border-top';

    //subtractive
    public const BORDER_DEFAULT_0 = 'border-0';
    public const BORDER_END_0 = 'border-end-0';
    public const BORDER_START_0 = 'border-start-0';
    public const BORDER_TOP_0 = 'border-top-0';
    public const BORDER_BOTTOM_0 = 'border-bottom-0';

    //color
    public const BORDER_DANGER = 'border border-danger';
    public const BORDER_DARK = 'border border-dark';
    public const BORDER_INFO = 'border border-info';
    public const BORDER_LIGHT = 'border border-light';
    public const BORDER_PRIMARY = 'border border-primary';
    public const BORDER_SECONDARY = 'border border-secondary';
    public const BORDER_SUCCESS = 'border border-success';
    public const BORDER_WARNING = 'border border-warning';
    public const BORDER_WHITE = 'border border-white';

    //width
    public const BORDER_WIDTH_1 = 'border border-1';
    public const BORDER_WIDTH_2 = 'border border-2';
    public const BORDER_WIDTH_3 = 'border border-3';
    public const BORDER_WIDTH_4 = 'border border-4';
    public const BORDER_WIDTH_5 = 'border border-5';

    //radius
    public const BORDER_RADIUS = 'rounded';
    public const BORDER_RADIUS_TOP = 'rounded-top';
    public const BORDER_RADIOS_END = 'rounded-end';
    public const BORDER_RADIUS_BOTTOM = 'rounded-bottom';
    public const BORDER_RADIUS_START = 'rounded-start';
    public const BORDER_RADIUS_CIRCLE = 'rounded-circle';
    public const BORDER_RADIUS_PILL = 'rounded-pill';

    //sizes
    public const BORDER_SIZE_0 = 'rounded-0';
    public const BORDER_SIZE_1 = 'rounded-1';
    public const BORDER_SIZE_2 = 'rounded-2';
    public const BORDER_SIZE_3 = 'rounded-3';

    public function getAllAdditives(): array
    {
        return [
            self::BORDER_BOTTOM,
            self::BORDER_DEFAULT,
            self::BORDER_END,
            self::BORDER_START,
            self::BORDER_TOP,
        ];
    }

    public function getAllSubtractives(): array
    {
        return [
            self::BORDER_DEFAULT_0,
            self::BORDER_END_0,
            self::BORDER_START_0,
            self::BORDER_TOP_0,
            self::BORDER_BOTTOM_0,
        ];
    }

    public function getAllColors(): array
    {
        return [
            self::BORDER_DANGER,
            self::BORDER_DARK,
            self::BORDER_INFO,
            self::BORDER_LIGHT,
            self::BORDER_PRIMARY,
            self::BORDER_SECONDARY,
            self::BORDER_SUCCESS,
            self::BORDER_WARNING,
            self::BORDER_WHITE,
        ];
    }

    public function getAllWidths(): array
    {
        return [
            self::BORDER_WIDTH_1,
            self::BORDER_WIDTH_2,
            self::BORDER_WIDTH_3,
            self::BORDER_WIDTH_4,
            self::BORDER_WIDTH_5,
        ];
    }

    public function getAllRadius(): array
    {
        return [
            self::BORDER_RADIUS,
            self::BORDER_RADIUS_TOP,
            self::BORDER_RADIOS_END,
            self::BORDER_RADIUS_BOTTOM,
            self::BORDER_RADIUS_START,
            self::BORDER_RADIUS_CIRCLE,
            self::BORDER_RADIUS_PILL,
        ];
    }

    public function getAllSizes(): array
    {
        return [
            self::BORDER_SIZE_0,
            self::BORDER_SIZE_1,
            self::BORDER_SIZE_2,
            self::BORDER_SIZE_3,
        ];
    }
}
