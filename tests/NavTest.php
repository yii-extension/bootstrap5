<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use Yiisoft\Yii\Bootstrap5\Dropdown;
use Yii\Extension\Bootstrap5\Nav;

/**
 * Tests for Nav widget.
 *
 * NavTest
 */
final class NavTest extends TestCase
{
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

    public function testRenderItemsDropdown(): void
    {
        Nav::counter(0);

        $html = Nav::widget()
            ->items([
                [
                    'label' => 'Active',
                    'url' => '#',
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => "#", 'active' => true],
                        ['label' => 'Page3', 'content' => 'Page3', 'url' => "#"],
                    ]
                ],
                [
                    'label' => 'Dropdown2',
                    'items' => [
                        ['label' => 'Page2', 'content' => 'Page4','url' => "#"],
                        ['label' => 'Page3', 'content' => 'Page5', 'url' => "#"],
                    ]
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link" href="#">Active</a></li>
        <li id="w1-dropdown" class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a>
        <ul class="dropdown-menu" aria-expanded="false" aria-labelledby="w1-dropdown">
        <li><a class="dropdown-item active" href="#">Page2</a></li>
        <li><a class="dropdown-item" href="#">Page3</a></li>
        </ul>
        </li>
        <li id="w2-dropdown" class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown2</a>
        <ul class="dropdown-menu" aria-expanded="false" aria-labelledby="w2-dropdown">
        <li><a class="dropdown-item" href="#">Page2</a></li>
        <li><a class="dropdown-item" href="#">Page3</a></li>
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
                ],
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page1', 'url' => "/page1"],
                        ['label' => 'Page2', 'content' => 'Page2', 'url' => "/page2"],
                    ]
                ],
                [
                    'label' => 'Dropdown2',
                    'items' => [
                        ['label' => 'Page3', 'content' => 'Page3','url' => "/page3"],
                        ['label' => 'Page4', 'content' => 'Page4', 'url' => "/page4"],
                    ]
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul id="w0-nav" class="nav">
        <li class="nav-item"><a class="nav-link" href="/disable">Disable</a></li>
        <li id="w1-dropdown" class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown1</a>
        <ul class="dropdown-menu" aria-expanded="false" aria-labelledby="w1-dropdown">
        <li><a class="dropdown-item" href="/page1">Page1</a></li>
        <li><a class="dropdown-item" href="/page2">Page2</a></li>
        </ul>
        </li>
        <li id="w2-dropdown" class="dropdown nav-item"><a class="dropdown-toggle nav-link" href="#" data-bs-toggle="dropdown">Dropdown2</a>
        <ul class="dropdown-menu" aria-expanded="false" aria-labelledby="w2-dropdown">
        <li><a class="dropdown-item" href="/page3">Page3</a></li>
        <li><a class="dropdown-item active" href="/page4">Page4</a></li>
        </ul>
        </li>
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
