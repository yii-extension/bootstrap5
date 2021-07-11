<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Yii\Extension\Bootstrap5\Dropdown;
use Yii\Extension\Bootstrap5\Tests\TestSupport\TestTrait;

/**
 * Tests for Dropdown widget.
 */
final class DropdownTest extends TestCase
{
    use TestTrait;

    public function testMissingLabel(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Dropdown::widget()->items([['url' => '#test']])->render();
    }

    public function testRender(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => '<span class=dropdown-item>Action</span>',
                    'enclose' => false,
                ],
                [
                    'label' => 'Another action',
                    'url' => '#',
                ],
                [
                    'label' => 'Something else here',
                    'url' => '#',
                ],
                [
                    'label' => '-',
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        ['label' => 'Dropdown Options: '],
                        '-',
                        ['label' => 'Option 1', 'url' => "/page1"],
                        ['label' => 'Option 2', 'url' => "/page2"],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <span class=dropdown-item>Action</span>
        <a class="dropdown-item" href="#">Another action</a>
        <a class="dropdown-item" href="#">Something else here</a>
        <div class="dropdown-divider"></div>
        <a id="w0-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" aria-labelledby="w0-dropdown">
        <h6 class="dropdown-header">Dropdown Options: </h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="/page1">Option 1</a>
        <a class="dropdown-item" href="/page2">Option 2</a>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderItemsIcon(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Icon',
                    'url' => "#",
                    'icon' => 'fas fa-home',
                    'iconAttribute' => 'icon',
                ],
            ])
            ->render();
        $this->assertStringContainsString(
            '<a class="dropdown-item" href="#"><span><i class="fas fa-home"></i></span>Icon</a>',
            $html
        );
    }

    public function testRenderItemsEncodeLabels(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Encode & Labels',
                    'url' => '#',
                    'encode' => true,
                ],
            ])
            ->render();
        $this->assertStringContainsString('<a class="dropdown-item" href="#">Encode &amp; Labels</a>', $html);
    }

    public function testRenderSubMenu(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Disable',
                    'url' => '#',
                    'disable' => true,
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Sub-Dropdown 1',
                            'items' => [
                                ['label' => 'Option 1', 'url' => "/page1"],
                                ['label' => 'Option 2', 'url' => "/page2"],
                            ],
                        ],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Disable</a>
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" aria-labelledby="w1-dropdown">
        <a id="w0-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Sub-Dropdown 1</a>
        <ul class="dropdown-menu" aria-labelledby="w0-dropdown">
        <a class="dropdown-item" href="/page1">Option 1</a>
        <a class="dropdown-item" href="/page2">Option 2</a>
        </ul>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderSubMenuAttributes(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Disable',
                    'url' => '#',
                    'disable' => true,
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Sub-Dropdown 1',
                            'items' => [
                                ['label' => 'Option 1', 'url' => "/page1"],
                                ['label' => 'Option 2', 'url' => "/page2"],
                            ],
                        ],
                    ],
                ],
            ])
            ->submenuAttributes(['class' => 'testMe'])
            ->render();
        $expected = <<<'HTML'
        <a class="dropdown-item disabled" href="#" tabindex="-1" aria-disabled="true">Disable</a>
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" aria-labelledby="w1-dropdown">
        <a id="w0-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Sub-Dropdown 1</a>
        <ul class="testMe dropdown-menu" aria-labelledby="w0-dropdown">
        <a class="dropdown-item" href="/page1">Option 1</a>
        <a class="dropdown-item" href="/page2">Option 2</a>
        </ul>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderSubMenuDeepLevel(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Action',
                    'url' => '#',
                ],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Level 1',
                            'items' => [
                                [
                                    'label' =>  'Level 2',
                                    'items' => [
                                        ['label' => 'Option 1', 'url' => "/page1"],
                                        ['label' => 'Option 2', 'url' => "/page2"],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <a class="dropdown-item" href="#">Action</a>
        <a id="w2-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" aria-labelledby="w2-dropdown">
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Level 1</a>
        <ul class="dropdown-menu" aria-labelledby="w1-dropdown">
        <a id="w0-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Level 2</a>
        <ul class="dropdown-menu" aria-labelledby="w0-dropdown">
        <a class="dropdown-item" href="/page1">Option 1</a>
        <a class="dropdown-item" href="/page2">Option 2</a>
        </ul>
        </ul>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
