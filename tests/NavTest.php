<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use InvalidArgumentException;
use Yii\Extension\Bootstrap5\Nav;

/**
 * Tests for Nav widget.
 *
 * NavTest
 */
final class NavTest extends TestCase
{
    /**
     * @link https://github.com/yiisoft/yii2-bootstrap/issues/96
     * @link https://github.com/yiisoft/yii2-bootstrap/issues/157
     */
    public function testDeepActivateParents(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->activateParents()
            ->items([
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Sub-dropdown',
                            'items' => [
                                ['label' => 'Page', 'url' => '#', 'active' => true],
                            ],
                        ],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item dropdown">
        <a id="w2-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" active aria-labelledby="w2-dropdown">
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Sub-dropdown</a>
        <ul class="dropdown-menu" active aria-labelledby="w1-dropdown">
        <a class="dropdown-item active" href="#">Page</a>
        </ul>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/162
     */
    public function testExplicitActive(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->withoutActivateItems()
            ->items([
                [
                    'label' => 'Item1',
                    'active' => true,
                ],
                [
                    'label' => 'Item2',
                    'url' => '/site/index',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link" href="#">Item1</a></li>
        <li class="nav-item"><a class="nav-link" href="/site/index">Item2</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testFillAndJustify(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
            ])
            ->fillAndJustify()
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav-pills nav-fill nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testHorizontal(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->horizontal()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="justify-content-center nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("The 'label' option is required.");
        Nav::widget()->items([['content' => 'Page1']])->render();
    }

    public function testPills(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
            ])
            ->pills()
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav-pills nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRender(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
                [
                    'label' => 'Not visible',
                    'url' => '#',
                    'visible' => false,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

        /**
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/96
     * @see https://github.com/yiisoft/yii2-bootstrap/issues/157
     */
    public function testRenderItemsDeepActivateParents(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->activateParents()
            ->items([
                [
                    'label' => 'Dropdown',
                    'items' => [
                        [
                            'label' => 'Sub-Dropdown-1',
                            'items' => [
                                ['label' => 'Page', 'content' => 'Page', 'url' => "#", 'active' => true],
                            ],
                        ],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item dropdown">
        <a id="w2-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" active aria-labelledby="w2-dropdown">
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Sub-Dropdown-1</a>
        <ul class="dropdown-menu" active aria-labelledby="w1-dropdown">
        <a class="dropdown-item active" href="#">Page</a>
        </ul>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderItemsEncodeLabels(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Encode & Labels',
                    'url' => '#',
                    'encode' => true,
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link" href="#">Encode &amp; Labels</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderItemsDropdown(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Disable',
                    'url' => '#',
                    'disabled' => true,
                ],
                [
                    'label' => 'Dropdown 1',
                    'items' => [
                        ['label' => 'Page 1', 'url' => "#", 'active' => true],
                        ['label' => 'Page 2', 'url' => "#"],
                    ]
                ],
                [
                    'label' => 'Dropdown 2',
                    'items' => [
                        ['label' => 'Page 3', 'url' => "#"],
                        ['label' => 'Page 4', 'url' => "#"],
                    ]
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disable</a></li>
        <li class="nav-item dropdown">
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown 1</a>
        <ul class="dropdown-menu" aria-labelledby="w1-dropdown">
        <a class="dropdown-item active" href="#">Page 1</a>
        <a class="dropdown-item" href="#">Page 2</a>
        </ul>
        </li>
        <li class="nav-item dropdown">
        <a id="w2-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown 2</a>
        <ul class="dropdown-menu" aria-labelledby="w2-dropdown">
        <a class="dropdown-item" href="#">Page 3</a>
        <a class="dropdown-item" href="#">Page 4</a>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderItemsDropdownCurrentPath(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->currentPath('/page4')
            ->items([
                [
                    'label' => 'Disable',
                    'url' => '/disable',
                    'disabled' => true,
                ],
                [
                    'label' => 'Dropdown 1',
                    'items' => [
                        ['label' => 'Page 1', 'url' => "/page1"],
                        ['label' => 'Page 2', 'url' => "/page2"],
                    ],
                ],
                [
                    'label' => 'Dropdown 2',
                    'items' => [
                        ['label' => 'Page 3', 'url' => "/page3"],
                        ['label' => 'Page 4', 'url' => "/page4"],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link disabled" href="/disable" tabindex="-1" aria-disabled="true">Disable</a></li>
        <li class="nav-item dropdown">
        <a id="w1-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown 1</a>
        <ul class="dropdown-menu" aria-labelledby="w1-dropdown">
        <a class="dropdown-item" href="/page1">Page 1</a>
        <a class="dropdown-item" href="/page2">Page 2</a>
        </ul>
        </li>
        <li class="nav-item dropdown">
        <a id="w2-dropdown" class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" role="button">Dropdown 2</a>
        <ul class="dropdown-menu" aria-labelledby="w2-dropdown">
        <a class="dropdown-item" href="/page3">Page 3</a>
        <a class="dropdown-item active" href="/page4">Page 4</a>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testRenderItemsIcon(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->currentPath('/page4')
            ->items([

                    [
                        'label' => 'Active',
                        'icon' => 'fas fa-home',
                        'iconAttributes' => ['class' => 'me-1'],
                        'url' => '#',
                        'active' => true,
                    ],
                    [
                        'label' => 'Link',
                        'icon' => 'fas fa-link',
                        'iconAttributes' => ['class' => 'me-1'],
                        'url' => '#',
                    ],
                    [
                        'label' => 'Disabled',
                        'url' => '#',
                        'disabled' => true,
                    ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page"><span class="me-1"><i class="fas fa-home"></i></span>Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><span class="me-1"><i class="fas fa-link"></i></span>Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }


    public function testTabs(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
            ])
            ->tabs()
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav-tabs nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testVertical(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
            ])
            ->vertical()
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="flex-column nav">
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testWithoutContainer(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                    'active' => true,
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Link',
                    'url' => '#',
                ],
                [
                    'label' => 'Disabled',
                    'url' => '#',
                    'disabled' => true,
                ],
            ])
            ->withoutContainer()
            ->render();
        $expected = <<<'HTML'
        <li class="nav-item"><a class="nav-link active" href="#" aria-current="page">Active</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item"><a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a></li>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
