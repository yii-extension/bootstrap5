<?php

declare(strict_types=1);

namespace Yii\Extension\Widgets;

use InvalidArgumentException;
use Yii\Extension\Widget\SimpleWidget;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;

/**
 * Provide contextual feedback messages for typical user actions with the handful of available and flexible alert
 * messages.
 *
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 */
final class Alert extends SimpleWidget
{
    private array $buttonAttributes = [];
    private string $buttonClass = '';
    private string $buttonLabel = '&times;';
    private string $buttonOnClick = '';
    private array $body = [];
    private string $header = '';
    private array $iconAttributes = [];
    private array $iconContainerAttributes = [];
    private string $iconContainerClass = '';
    private string $iconClass = '';
    private string $iconText = '';
    private array $parts = [];

    /**
     * Returns a new instance with the specified message content in the alert component.
     *
     * @param array $values The content of the alert component.
     *
     * @return self
     */
    public function body(string ...$values): self
    {
        $new = clone $this;
        $new->body = $value;
        return $new;
    }

    /**
     * Returns a new instance with the specified attributes for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window.
     *
     * @param array $values Attribute values indexed by attribute names.
     *
     * @return self
     *
     * {@see \Yiisoft\Html\Html::renderTagAttributes()} For details on how attributes are being rendered.
     */
    public function buttonAttributes(array $value): self
    {
        $new = clone $this;
        $new->buttonAttributes = $values;
        return $new;
    }

    /**
     * The CSS class for the close button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonClass(string $value): self
    {
        $new = clone $this;
        $new->buttonClass = $value;
        return $new;
    }

    /**
     * The label for the close button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonLabel(string $value = ''): self
    {
        $new = clone $this;
        $new->buttonLabel = $value;
        return $new;
    }

    /**
     * The onclick JavaScript for the close button.
     *
     * @param string $value
     *
     * @return static
     */
    public function buttonOnClick(string $value = ''): self
    {
        $new = clone $this;
        $new->buttonOnClick = $value;
        return $new;
    }

    /**
     * The header content in the alert component. Alert widget will also be treated as the header content, and will be
     * rendered before this.
     *
     * @param string $value
     *
     * @return static
     */
    public function header(string $value): self
    {
        $new = clone $this;
        $new->header = $value;
        return $new;
    }

    /**
     * The attributes for rendering the i tag for icons alerts.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function iconAttributes(array $value): self
    {
        $new = clone $this;
        $new->iconAttributes = $value;
        return $new;
    }

    /**
     * Set icon css class in the alert component.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconClass(string $value): self
    {
        $new = clone $this;
        $new->iconClass = $value;
        return $new;
    }

    /**
     * The attributes for rendering the container i tag.
     *
     * The rest of the options will be rendered as the HTML attributes of the i tag.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function iconContainerAttributes(array $value): self
    {
        $new = clone $this;
        $new->iconContainerAttributes = $value;
        return $new;
    }

    /**
     * The CSS class for the container i tag.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconContainerClass(string $value): self
    {
        $new = clone $this;
        $new->iconContainerClass = $value;
        return $new;
    }

    /**
     * Set icon text in the alert component.
     *
     * @param string $value
     *
     * @return static
     */
    public function iconText(string $value): self
    {
        $new = clone $this;
        $new->iconText = $value;
        return $new;
    }


    protected function run(): string
    {
        $new = clone $this;
        return $new->renderAlert($new);
    }

    /**
     * Render Alert.
     */
    private function renderAlert(self $new): string
    {
        $attributes = $new->getAttributes();
        $class = $new->getClass();

        $attributes['role'] = 'alert';

        if (!isset($attributes['id'])) {
            $attributes['id'] = "{$new->getId()}-alert";
        }

        if (!isset($new->parts['{button}'])) {
            $new->renderCloseButton($new);
        }

        if (!isset($new->parts['{icon}'])) {
            $new->renderIcon($new);
        }

        if (!isset($new->parts['{body}'])) {
            $new->renderBody($new);
        }

        if (!isset($new->parts['{header}'])) {
            $new->renderHeader($new);
        }

        $contentAlert = $new->renderHeader($new) . PHP_EOL . $new->renderBody($new);

        if ($class !== '') {
            Html::addCssClass($attributes, $class);
        }

        return $new->body !== ''
            ? Div::tag()
                ->attributes($attributes)
                ->content(PHP_EOL . trim($contentAlert) . PHP_EOL)
                ->encode(false)
                ->render()
            : '';
    }

    /**
     * Renders close button.
     */
    private function renderCloseButton(self $new): void
    {
        $new->parts['{button}'] = '';

        if ($new->buttonOnClick !== '') {
            $new->buttonAttributes['onclick'] = $new->buttonOnClick;
        }

        if ($new->buttonClass !== '') {
            Html::addCssClass($new->buttonAttributes, $new->buttonClass);
        }

        $new->parts['{button}'] = PHP_EOL .
            Button::tag()
                ->attributes($new->buttonAttributes)
                ->content($new->buttonLabel)
                ->encode(false)
                ->type('button')
                ->render();
    }

    private function renderBody(self $new): void
    {
        foreach ($new->body as $body) {
            $new->parts['{body}'] .= $body . PHP_EOL;
        }
    }

    private function renderHeader(self $new): void
    {
        foreach ($new->header as $header) {
            $new->parts['{header}'] .= $header . PHP_EOL;
        }
    }

    private function renderIcon(self $new): void
    {
        if ($new->iconClass !== '') {
            Html::addCssClass($new->iconAttributes, $new->iconClass);
        }

        if ($new->iconContainerClass !== '') {
            Html::addCssClass($new->iconContainerAttributes, $new->iconContainerClass);
        }

        $icon = CustomTag::name('i')->attributes($new->iconAttributes)->content($new->iconText)->render();

        $new->parts['{icon}'] = PHP_EOL .
            Div::tag()
                ->attributes($new->iconContainerAttributes)
                ->content($icon)
                ->encode(false)
                ->render() . PHP_EOL;
    }
}
