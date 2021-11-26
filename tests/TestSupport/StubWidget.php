<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests\TestSupport;

use Yii\Extension\Bootstrap5\Widget;
use Yiisoft\Html\Html;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        $this->attributes['id'] = $this->getId() === '' ? $this->generateId() : $this->getId();
        return '<run' . Html::renderTagAttributes($this->attributes) . '>';
    }
}
