<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Bootstrap5\Modal;
use Yii\Extension\Bootstrap5\Tests\TestSupport\TestTrait;
use Yiisoft\Html\Html;

/**
 * Tests for Modal widget.
 *
 * ModalTest.
 */
final class ModalTest extends TestCase
{
    use TestTrait;

    public function testBodyAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="test-class modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->bodyAttributes(['class' => 'test-class'])->render());
    }

    public function testBodyContent(): void
    {
        Modal::counter(0);

        $expected = <<<HTML
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">Hello!</div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->bodyContent('Hello!')->render());
    }

    public function testCloseButtonAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="test-class btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Modal::widget()->closeButtonAttributes(['class' => 'test-class'])->render(),
        );
    }

    public function testContentAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="test-class modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Modal::widget()->contentAttributes(['class' => 'test-class'])->render(),
        );
    }

    public function testDialogAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="test-class modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->dialogAttributes(['class' => 'test-class'])->render());
    }

    public function testFooter(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer">This is the footer.</div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->footer('This is the footer.')->render());
    }

    public function testFooterAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="test-class modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->footerattributes(['class' => 'test-class'])->render());
    }

    public function testFullScreen(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->fullScreen(Modal::FULL_SCREEN)->render());
    }

    public function testFullScreenException(): void
    {
        Modal::counter(0);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Invalid size. Valid values are: "modal-fullscreen", "modal-fullscreen-sm-down", ' .
            '"modal-fullscreen-md-down", "modal-fullscreen-lg-down", "modal-fullscreen-xl-down", ' .
            '"modal-fullscreen-xxl-down".'
        );
        Modal::widget()->fullScreen('noExist')->render();
    }

    public function testHeaderAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="test-class modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Modal::widget()->headerAttributes(['class' => 'test-class'])->render(),
        );
    }

    public function testHeaderTitle(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"><h5 id="w0-modal-label" class="modal-header">Header title.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->headerTitle('Header title.')->render());
    }

    public function testHeaderTitleAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"><h5 id="w0-modal-label" class="test-class modal-header">Header title.</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Modal::widget()->headerTitle('Header title.')->headerTitleAttributes(['class' => 'test-class'])->render(),
        );
    }

    public function testRender(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->render());
    }

    public function testSize(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->size(Modal::SIZE_LARGE)->render());
    }

    public function testScrollable(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->scrollable()->render());
    }

    public function testStaticBackdrop(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->staticBackdrop()->render());
    }

    public function testSizeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid size. Valid values are: "modal-xl", "modal-lg", "modal-sm".');
        Modal::widget()->size('noExist');
    }

    public function testToggeButtonAttributes(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE(
            $expected,
            Modal::widget()->toggleButtonAttributes(['class' => 'btn btn-primary'])->render(),
        );
    }

    public function testToggeButtonContent(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal">Lanuch demo modal.</button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->toggleButtonContent('Lanuch demo modal.')->render());
    }

    public function testVerticalCenter(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->verticalCenter()->render());
    }

    public function testWithoutCloseButton(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <button type="button" data-bs-toggle="modal" data-bs-target="#w0-modal"></button>
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"></div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->withoutCloseButton()->render());
    }

    public function testwithoutToggleButton(): void
    {
        Modal::counter(0);

        $expected = <<<'HTML'
        <div id="w0-modal" class="modal" aria-labelledby="w0-modal-label" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"></div>
        <div class="modal-footer"></div>
        </div>
        </div>
        </div>
        HTML;
        $this->assertEqualsWithoutLE($expected, Modal::widget()->withoutToggleButton()->render());
    }
}
