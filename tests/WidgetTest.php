<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Bootstrap5\Tests\TestSupport\StubWidget;

final class WidgetTest extends TestCase
{
    public function testAddAttributes(): void
    {
        StubWidget::counter(0);
        $html = StubWidget::widget()->addAttribute('name', 'test-name')->render();
        $this->assertSame('<run id="w0" name="test-name">', $html);
    }

    public function testAutoIdPrefix(): void
    {
        StubWidget::counter(0);
        $html = StubWidget::widget()->autoIdPrefix('t')->render();
        $this->assertSame('<run id="t0">', $html);
    }

    public function testGenerateId(): void
    {
        StubWidget::counter(0);
        $html = StubWidget::widget()->render();
        $this->assertSame('<run id="w0">', $html);
    }

    public function testId(): void
    {
        StubWidget::counter(0);
        $html = StubWidget::widget()->id('test-2')->render();
        $this->assertSame('<run id="test-2">', $html);
    }
}
