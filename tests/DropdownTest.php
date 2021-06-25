<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use InvalidArgumentException;
use Yii\Extension\Bootstrap5\Dropdown;

/**
 * Tests for Dropdown widget.
 */
final class DropdownNavTest extends TestCase
{
    public function testRender(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Action',
                    'url' => '#',
                ],
                [
                    'label' => 'Another action',
                    'url' => '#',
                ],
                [
                    'label' => 'Something else here',
                    'url' => '#',
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item" href="#">Action</a></li>
        <li><a class="dropdown-item" href="#">Another action</a></li>
        <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testMissingLabel(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The "label" option is required.');
        Dropdown::widget()->items([['url' => '#test']])->render();
    }

    public function testSubMenuAttributes(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => 'Dropdown1',
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page2'],
                        ['label' => 'Page2', 'content' => 'Page3'],
                    ],
                ],
                '-',
                [
                    'label' => 'Dropdown2',
                    'items' => [
                        ['label' => 'Page3', 'content' => 'Page4'],
                        ['label' => 'Page4', 'content' => 'Page5'],
                    ],
                    'submenuOptions' => [
                        'class' => 'submenu-override',
                    ],
                ],
            ])
            ->submenuAttributes(['class' => 'submenu-list'])
            ->render();
        $expected = <<<'HTML'
        <ul class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" aria-haspopup="true" role="button">Dropdown1</a>
        <ul>
        <ul class="submenu-list dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul>
        </ul>
        </li>
        <li><div class="dropdown-divider"></div></li>
        <li><a class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" aria-haspopup="true" role="button">Dropdown2</a>
        <ul>
        <ul class="submenu-list dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page3</h6></li>
        <li><h6 class="dropdown-header">Page4</h6></li>
        </ul>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testEncodeLabels(): void
    {
        Dropdown::counter(0);

        $html = Dropdown::widget()
            ->items([
                [
                    'label' => '<span><i class=fas fastest></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page2'],
                        ['label' => 'Page2', 'content' => 'Page3'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" aria-haspopup="true" role="button"><span><i class=fas fastest></i>Dropdown1</span></a>
        <ul>
        <ul class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);

        $html = Dropdown::widget()
            ->withoutEncodeLabels()
            ->items([
                [
                    'label' => '<span><i class=fas fastest></i>Dropdown1</span>',
                    'items' => [
                        ['label' => 'Page1', 'content' => 'Page2'],
                        ['label' => 'Page2', 'content' => 'Page3'],
                    ],
                ],
            ])
            ->render();
        $expected = <<<'HTML'
        <ul class="dropdown-menu" aria-expanded="false">
        <li><a class="dropdown-item dropdown-toggle" href="" data-bs-toggle="dropdown" aria-haspopup="true" role="button"><span><i class=fas fastest></i>Dropdown1</span></a>
        <ul>
        <ul class="dropdown-menu" aria-expanded="false">
        <li><h6 class="dropdown-header">Page1</h6></li>
        <li><h6 class="dropdown-header">Page2</h6></li>
        </ul>
        </ul>
        </li>
        </ul>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
