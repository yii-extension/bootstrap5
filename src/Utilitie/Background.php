<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

final class Background
{
    // Background color
    public const COLOR_BODY = 'bg-body';
    public const COLOR_DANGER = 'bg-danger';
    public const COLOR_DARK = 'bg-dark';
    public const COLOR_INFO = 'bg-info';
    public const COLOR_LIGHT = 'bg-light';
    public const COLOR_PRIMARY = 'bg-primary';
    public const COLOR_SECONDARY = 'bg-secondary';
    public const COLOR_SUCCESS = 'bg-success';
    public const COLOR_TRANSPARENT = 'bg-transparent';
    public const COLOR_WARNING = 'bg-warning';
    public const COLOR_WHITE = 'bg-white';

    // Background gradient
    public const GRADIENT_DANGER = 'bg-danger bg-gradient';
    public const GRADIENT_DARK = 'bg-dark bg-gradient';
    public const GRADIENT_INFO = 'bg-info bg-gradient';
    public const GRADIENT_LIGHT = 'bg-light bg-gradient';
    public const GRADIENT_PRIMARY = 'bg-primary bg-gradient';
    public const GRADIENT_SECONDARY = 'bg-secondary bg-gradient';
    public const GRADIENT_SUCCESS = 'bg-success bg-gradient';
    public const GRADIENT_WARNING =  'bg-warning bg-gradient';

    public function getAllColors(): array
    {
        return [
            self::COLOR_BODY,
            self::COLOR_DANGER,
            self::COLOR_DARK,
            self::COLOR_INFO,
            self::COLOR_LIGHT,
            self::COLOR_PRIMARY,
            self::COLOR_SECONDARY,
            self::COLOR_SUCCESS,
            self::COLOR_TRANSPARENT,
            self::COLOR_WARNING,
            self::COLOR_WHITE,
        ];
    }

    public function getAllGradients(): array
    {
        return [
            self::GRADIENT_DANGER,
            self::GRADIENT_DARK,
            self::GRADIENT_INFO,
            self::GRADIENT_LIGHT,
            self::GRADIENT_PRIMARY,
            self::GRADIENT_SECONDARY,
            self::GRADIENT_SUCCESS,
            self::GRADIENT_WARNING,
        ];
    }
}
