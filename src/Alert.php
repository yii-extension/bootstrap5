<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\Div;

/**
 * Alert renders an alert bootstrap component.
 *
 * For example,
 *
 * ```php
 * echo Alert::widget()
 *     ->attributes([
 *         'class' => 'alert-info',
 *     ])
 *     ->body('Say hello...');
 * ```
 *
 * @link https://getbootstrap.com/docs/5.0/components/alerts/
 */
final class Alert extends Widget
{
    private string $body = '';
    private array $closeButtonAttribute = [];
    private bool $closeButtonEnabled = true;

    protected function run(): string
    {
        $new = clone $this;

        if (!isset($new->attributes['id'])) {
            $new->attributes['id'] = "{$new->getId()}-alert";
        }

        $new->loadDefaultAttributes($new);

        return Div::tag()
            ->attributes($new->attributes)
            ->content("\n" . $new->renderBodyEnd())
            ->encode(false)
            ->render();
    }

    /**
     * The body content in the alert component. Alert widget will also be treated as the body content, and will be
     * rendered before this.
     *
     * @param string $value
     *
     * @return static
     */
    public function body(string $value): self
    {
        $new = clone $this;
        $new->body = $value;
        return $new;
    }

    /**
     * The attributes for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If {@see closeButtonEnabled} is false, no close button will be rendered.
     *
     * The following special attributes are supported:
     *
     * - tag: string, the tag name of the button. Defaults to 'button'.
     * - label: string, the label of the button. Defaults to '&times;'.
     *
     * The rest of the attributes will be rendered as the HTML attributes of the button tag.
     *
     * Please refer to the [Alert documentation](http://getbootstrap.com/components/#alerts) for the supported HTML
     * attributes.
     *
     * @param array $value
     *
     * @return static
     */
    public function closeButtonAttributes(array $value): self
    {
        $new = clone $this;
        $new->closeButtonAttribute = $value;
        return $new;
    }

    /**
     * Disable close button.
     *
     * @return static
     */
    public function withoutCloseButton(): self
    {
        $new = clone $this;
        $new->closeButtonEnabled = false;
        return $new;
    }

    /**
     * Renders the alert body and the close button (if any).
     *
     * @return string the rendering result
     */
    private function renderBodyEnd(): string
    {
        return $this->body . "\n" . $this->renderCloseButton();
    }

    /**
     * Renders the close button.
     *
     * @return string the rendering result
     */
    private function renderCloseButton(): string
    {
        $new = clone $this;

        if ($new->closeButtonEnabled === false) {
            return '';
        }

        $new->closeButtonAttribute['type'] = 'button';

        return Button::tag()->attributes($new->closeButtonAttribute)->render() . "\n";
    }

    /**
     * Initializes the widget attributes.
     *
     * This method sets the default values for various attributes.
     */
    private function loadDefaultAttributes(self $new): void
    {
        Html::addCssClass($new->attributes, ['widget' => 'alert']);

        if ($new->closeButtonEnabled !== false) {
            $new->closeButtonAttribute['aria-label'] = 'Close';
            $new->closeButtonAttribute['data-bs-dismiss'] = 'alert';

            Html::addCssclass($new->closeButtonAttribute, ['buttonAttributes' => 'btn-close']);
            Html::addCssClass($new->attributes, ['alert-dismissible' => 'alert-dismissible']);
        }

        if (!isset($new->attributes['role'])) {
            $new->attributes['role'] = 'alert';
        }
    }
}
