<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Bootstrap5\Tests\TestSupport\StubWidget;

final class WidgetTest extends TestCase
{
    public function testAutoIdPrefix(): void
    {
        StubWidget::counter(0);

        $id = StubWidget::widget()->autoIdPrefix('t')->render();

        $this->assertSame('<run-t0>', $id);
    }

    public function testGetId(): void
    {
        StubWidget::counter(0);

        $id = StubWidget::widget()->render();

        $this->assertSame('<run-w0>', $id);
    }

    public function testId(): void
    {
        StubWidget::counter(0);

        $id = StubWidget::widget()->id('test-2')->withoutAutoGenerateId()->render();

        $this->assertSame('<run-test-2>', $id);
    }

}
