<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests\TestSupport;

use Yii\Extension\Bootstrap5\Widget;

final class StubWidget extends Widget
{
    protected function run(): string
    {
        return '<run-' . $this->getId() . '>';
    }
}
