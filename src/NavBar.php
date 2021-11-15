<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Img;
use Yiisoft\Html\Tag\Span;

/**
 * NavBar renders a navbar HTML component.
 *
 * Any content enclosed between the {@see begin()} and {@see end()} calls of NavBar is treated as the content of the
 * navbar. You may use widgets such as {@see Nav} to build up such content. For example,
 *
 */
final class NavBar extends Widget
{
    private array $brandAttributes = [];
    private string $brandImage = '';
    private string $brandText = '';
    private string $brandUrl = '/';
    private array $collapseAttributes = [];
    private array $containerAttributes = [];
    private string $screenReaderToggleText = 'Toggle navigation';
    private array $togglerAttributes = [];
    private string $togglerContent = '<span class="navbar-toggler-icon"></span>';

    public function begin(): string
    {
        parent::begin();

        $new = clone $this;

        if (!isset($new->attributes['id'])) {
            $new->attributes['id'] = "{$new->getId()}-navbar";
            $new->collapseAttributes['id'] = "{$new->getId()}-collapse";
        }

        $new->loadDefaultAttributes($new);

        return
            Html::openTag('nav', $new->attributes) . PHP_EOL .
            Html::openTag('div', $new->containerAttributes) . PHP_EOL .
            $new->renderBrand() .
            $new->renderToggleButton() .
            Html::openTag('div', $new->collapseAttributes) . PHP_EOL;
    }

    protected function run(): string
    {
        return
            Html::closeTag('div') . PHP_EOL .
            Html::closeTag('div') . PHP_EOL .
            Html::closeTag('nav');
    }

    /**
     * The HTML attributes of the brand link.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function brandAttributes(array $value): self
    {
        $new = clone $this;
        $new->brandAttributes = $value;
        return $new;
    }

    /**
     * Src of the brand image or empty if it's not used. Note that this param will override `$this->brandText` param.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#image
     */
    public function brandImage(string $value): self
    {
        $new = clone $this;
        $new->brandImage = $value;
        return $new;
    }

    /**
     * The text of the brand or empty if it's not used. Note that this is not HTML-encoded.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#text
     */
    public function brandText(string $value): self
    {
        $new = clone $this;
        $new->brandText = $value;
        return $new;
    }

    /**
     * The URL for the brand's hyperlink tag and will be used for the "href" attribute of the brand link. Default value
     * is "/". You may set it to empty string if you want no link at all.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#text
     */
    public function brandUrl(string $value): self
    {
        $new = clone $this;
        $new->brandUrl = $value;
        return $new;
    }

    /**
     * The HTML attributes of the inner container.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function containerAttributes(array $value): self
    {
        $new = clone $this;
        $new->containerAttributes = $value;
        return $new;
    }

    /**
     * The HTML attributes for the container tag. The following special attributes are recognized.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function collapseAttributes(array $value): self
    {
        $new = clone $this;
        $new->collapseAttributes = $value;
        return $new;
    }

    /**
     * Text to show for screen readers for the button to toggle the navbar.
     *
     * @param string $value
     *
     * @return static
     */
    public function screenReaderToggleText(string $value): self
    {
        $new = clone $this;
        $new->screenReaderToggleText = $value;
        return $new;
    }

    /**
     * The HTML attributes of the navbar toggler button.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function togglerAttributes(array $value): self
    {
        $new = clone $this;
        $new->togglerAttributes = $value;
        return $new;
    }

    /**
     * The toggle button content. Defaults to bootstrap 4 default `<span class="navbar-toggler-icon"></span>`.
     *
     * @param string $value
     *
     * @return static
     */
    public function togglerContent(string $value): self
    {
        $new = clone $this;
        $new->togglerContent = $value;
        return $new;
    }

    /**
     * Initializes the widget attributes.
     *
     * This method sets the default values for various attributes.
     */
    private function loadDefaultAttributes(self $new): void
    {
        if (empty($new->attributes['class'])) {
            Html::addCssClass($new->attributes, ['navbar', 'navbar-expand-lg', 'navbar-light', 'bg-light']);
        } else {
            Html::addCssClass($new->attributes, 'navbar');
        }

        if (!isset($new->containerAttributes['class'])) {
            Html::addCssClass($new->containerAttributes, 'container-fluid');
        }

        Html::addCssClass($new->collapseAttributes, ['collapse', 'navbar-collapse']);
    }

    private function renderBrand(): string
    {
        $new = clone $this;

        $brand = '';
        $brandImage = '';

        Html::addCssClass($new->brandAttributes, ['widget' => 'navbar-brand']);

        if ($new->brandImage !== '') {
            $brandImage = Img::tag()->url($new->brandImage)->render();
            $brand = A::tag()
                ->attributes($new->brandAttributes)
                ->content($brandImage)
                ->encode(false)
                ->url($new->brandUrl)
                ->render() . PHP_EOL;
        }

        if ($new->brandText !== '') {
            $brandText = $new->brandText;

            if ($brandImage !== '') {
                $brandText = $brandImage . $new->brandText;
            }

            if (empty($new->brandUrl)) {
                $brand = Span::tag()->attributes($new->brandAttributes)->content($brandText)->render();
            } else {
                $brand = A::tag()
                    ->attributes($new->brandAttributes)
                    ->content($brandText)
                    ->encode(false)
                    ->url($new->brandUrl)
                    ->render() . PHP_EOL;
            }
        }

        return $brand;
    }

    /**
     * Renders collapsible toggle button.
     *
     * @return string the rendering toggle button.
     *
     * @link https://getbootstrap.com/docs/5.0/components/navbar/#toggler
     */
    private function renderToggleButton(): string
    {
        $new = clone $this;

        /** @var string */
        $id = $new->collapseAttributes['id'];

        Html::addCssClass($new->togglerAttributes, ['widget' => 'navbar-toggler']);

        $new->togglerAttributes['aria-controls'] = $id;
        $new->togglerAttributes['aria-expanded'] = false;
        $new->togglerAttributes['aria-label'] = $new->screenReaderToggleText;
        $new->togglerAttributes['data-bs-target'] = "#$id";
        $new->togglerAttributes['data-bs-toggle'] = 'collapse';
        $new->togglerAttributes['type'] = 'button';

        return Button::tag()
            ->attributes($new->togglerAttributes)
            ->content(PHP_EOL . $new->togglerContent . PHP_EOL)
            ->encode(false)
            ->render() . PHP_EOL;
    }
}
