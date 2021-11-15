<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5\Tests;

use PHPUnit\Framework\TestCase;
use Yii\Extension\Bootstrap5\Nav;
use Yii\Extension\Bootstrap5\NavBar;
use Yii\Extension\Bootstrap5\Tests\TestSupport\TestTrait;

/**
 * Tests for NavBar widget.
 *
 * NavBarTest
 */
final class NavBarTest extends TestCase
{
    use TestTrait;

    public function testRender(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->attributes([
                'class' => 'navbar-inverse navbar-static-top navbar-frontend',
            ])
            ->brandText('My Company')
            ->brandUrl('/')
            ->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar-inverse navbar-static-top navbar-frontend navbar">
        <div class="container-fluid">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandImage(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandImage('/images/test.jpg')->brandUrl('/')->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg"></a>',
            $html
        );
    }

    public function testbrandUrl(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('Yii Framework')->brandUrl('/index.php')->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/index.php">Yii Framework</a>',
            $html
        );
    }

    public function testBrandText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('Yii Framework')->brandUrl('')->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<span class="navbar-brand">Yii Framework</span>',
            $html
        );
    }

    public function testBrandImageText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()
            ->brandText('Yii Framework')
            ->brandImage('/images/test.jpg')
            ->begin();
        $html .= NavBar::end();

        $this->assertStringContainsString(
            '<a class="navbar-brand" href="/"><img src="/images/test.jpg">Yii Framework</a>',
            $html
        );
    }

    public function testNavAndForm(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('My Company')->brandUrl('/')->begin();
        $html .= Nav::widget()
            ->attributes(['class' => ['navbar-nav me-auto mb-2 mb-lg-0']])
            ->items([
                ['label' => 'Home', 'url' => '#'],
                ['label' => 'Link', 'url' => '#'],
                [
                    'label' => 'Dropdown',
                    'items' => [
                        ['label' => 'Action', 'url' => '#'],
                        ['label' => 'Another action', 'url' => '#'],
                        '-',
                        ['label' => 'Something else here', 'url' => '#'],
                    ],
                    'urlAttributes' => ['class' => 'nav-link'],
                ],
            ])
            ->render();
        $html .= <<<'HTML'

        <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>

        HTML;
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="navbar-brand" href="/">My Company</a>
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        <ul id="w2-nav" class="navbar-nav me-auto mb-2 mb-lg-0 nav">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Link</a></li>
        <li class="nav-item dropdown">
        <a id="w3-dropdown" class="nav-link dropdown-item dropdown-toggle" href data-bs-toggle="dropdown" role="button">Dropdown</a>
        <ul class="dropdown-menu" aria-labelledby="w3-dropdown">
        <a class="dropdown-item" href="#">Action</a>
        <a class="dropdown-item" href="#">Another action</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#">Something else here</a>
        </ul>
        </li>
        </ul>
        <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testCollapseAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->collapseAttributes(['class' => 'testMe'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="testMe collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testBrandAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->brandText('My App')->brandAttributes(['class' => 'text-dark'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <a class="text-dark navbar-brand" href="/">My App</a>
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testScreenReaderToggleText(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->screenReaderToggleText('Toggler navigation')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggler navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTogglerContent(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->togglerContent('<div class="navbar-toggler-icon"></div>')->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <div class="navbar-toggler-icon"></div>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testTogglerAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->togglerAttributes(['class' => 'testMe'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
        <button type="button" class="testMe navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }

    public function testcontainerAttributes(): void
    {
        NavBar::counter(0);

        $html = NavBar::widget()->containerAttributes(['class' => 'text-link'])->begin();
        $html .= NavBar::end();
        $expected = <<<'HTML'
        <nav id="w0-navbar" class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="text-link">
        <button type="button" class="navbar-toggler" aria-controls="w1-collapse" aria-label="Toggle navigation" data-bs-target="#w1-collapse" data-bs-toggle="collapse">
        <span class="navbar-toggler-icon"></span>
        </button>
        <div id="w1-collapse" class="collapse navbar-collapse">
        </div>
        </div>
        </nav>
        HTML;
        $this->assertEqualsWithoutLE($expected, $html);
    }
}
