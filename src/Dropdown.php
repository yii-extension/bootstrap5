<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use InvalidArgumentException;
use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function array_key_exists;
use function array_merge;
use function array_merge_recursive;
use function is_string;

/**
 * Dropdown renders a Bootstrap dropdown menu component.
 */
final class Dropdown extends Widget
{
    private array $items = [];
    private bool $encodeLabels = true;
    private bool $encodeTags = false;
    private array $submenuAttributes = [];

    protected function run(): string
    {
        $new = clone $this;

        Html::addCssClass($new->attributes, ['widget' => 'dropdown-menu']);

        return $new->renderItems($new);
    }

    /**
     * List of menu items in the dropdown. Each array element can be either an HTML string, or an array representing a
     * single menu with the following structure:
     *
     * - label: string, required, the label of the item link.
     * - encode: bool, optional, whether to HTML-encode item label.
     * - url: string|array, optional, the URL of the item link. This will be processed by {@see currentPath}.
     *   If not set, the item will be treated as a menu header when the item has no sub-menu.
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - urlAttributes: array, optional, the HTML attributes of the item link.
     * - attributes: array, optional, the HTML attributes of the item.
     * - items: array, optional, the submenu items. The structure is the same as this property.
     *   Note that Bootstrap doesn't support dropdown submenu. You have to add your own CSS styles to support it.
     * - submenuOptions: array, optional, the HTML attributes for sub-menu container tag. If specified it will be
     *   merged with {@see submenuOptions}.
     *
     * To insert divider use `-`.
     *
     * @param array $value
     *
     * @return self
     */
    public function items(array $value): self
    {
        $new = clone $this;
        $new->items = $value;
        return $new;
    }

    /**
     * The HTML attributes for sub-menu container tags.
     *
     * @param array $value
     *
     * @return self
     */
    public function submenuAttributes(array $value): self
    {
        $new = clone $this;
        $new->submenuAttributes = $value;
        return $new;
    }

    /**
     * When tags Labels HTML should not be encoded.
     *
     * @return self
     */
    public function withoutEncodeLabels(): self
    {
        $new = clone $this;
        $new->encodeLabels = false;
        return $new;
    }

    /**
     * Renders menu items.
     *
     * @throws InvalidArgumentException if the label option is not specified in one of the
     * items.
     *
     * @return string the rendering result.
     * @psalm-suppress ImplicitToStringCast
     */
    private function renderItems(self $new): string
    {
        $lines = [];

        /** @var array|string $item */
        foreach ($new->items as $item) {
            if ($item === '-') {
                $lines[] = Html::div('', ['class' => 'dropdown-divider']);
            } else {
                if (!isset($item['label']) && $item !== '-') {
                    throw new InvalidArgumentException('The "label" option is required.');
                }

                /** @var string */
                $itemLabel = $item['label'] ?? '';

                if (isset($item['encode']) && $item['encode'] === true) {
                    $itemLabel = Html::encode($itemLabel);
                }

                /** @var array */
                $items = isset($item['items']) ? $item['items'] : [];

                /** @var array */
                $itemAttributes = isset($item['attributes']) ? $item['attributes'] : [];

                /** @var array */
                $urlAttributes = isset($item['urlAttributes']) ? $item['urlAttributes'] : [];

                /** @var string */
                $icon = $item['icon'] ?? '';

                /** @var array */
                $iconAttributes = $item['iconAttributes'] ?? [];

                /** @var string */
                $url = isset($item['url']) ? $item['url'] : '';

                /** @var bool */
                $active = isset($item['active']) ? $item['active'] : false;

                /** @var bool */
                $disabled = isset($item['disable']) ? $item['disable'] : false;

                /** @var bool */
                $enclose = isset($item['enclose']) ? $item['enclose'] : true;

                $itemLabel = $new->renderLabel($itemLabel, $icon, $iconAttributes);

                Html::addCssClass($urlAttributes, ['widget' => 'dropdown-item']);

                if ($disabled) {
                    $urlAttributes['tabindex'] = '-1';
                    $urlAttributes['aria-disabled'] = 'true';
                    Html::addCssClass($urlAttributes, ['disabled' => 'disabled']);
                } elseif ($active) {
                    Html::addCssClass($urlAttributes, ['active' => 'active']);
                }

                if ($items === []) {
                    if ($itemLabel === '-') {
                        $content = Html::div('', ['class' => 'dropdown-divider']);
                    } elseif ($enclose === false) {
                        $content = $itemLabel;
                    } elseif ($url === '') {
                        $content = Html::tag('h6', $itemLabel, ['class' => 'dropdown-header']);
                    } else {
                        $content = Html::a($itemLabel, $url, $urlAttributes)->encode($this->encodeTags);
                    }

                    $lines[] = $content;
                } else {
                    /** @var array */
                    $submenuAttributes = isset($item['submenuAttributes']) ? $item['submenuAttributes'] : [];
                    $new->submenuAttributes = array_merge($new->submenuAttributes, $submenuAttributes);

                    Html::addCssClass($new->submenuAttributes, ['submenu' => 'dropdown-menu']);
                    Html::addCssClass($urlAttributes, ['toggle' => 'dropdown-toggle']);

                    $dropdown = self::widget()
                        ->attributes($new->submenuAttributes)
                        ->items($items)
                        ->submenuAttributes($new->submenuAttributes);


                    $urlAttributes['data-bs-toggle'] = 'dropdown';
                    $urlAttributes['aria-haspopup'] = 'true';
                    $urlAttributes['role'] = 'button';

                    $lines[] = Html::a($itemLabel, $url, $urlAttributes)->encode(false) . "\n" .
                        Html::tag('ul', "\n" . $dropdown->render() . "\n", $itemAttributes)->encode(false) . "\n";
                }
            }
        }

        $attributes = array_merge(['aria-expanded' => 'false'], $new->attributes);

        return Html::ul()->attributes($attributes)->strings($lines, [], $this->encodeTags)->render();
    }

    private function renderLabel(
        string $label,
        string $icon,
        array $iconAttributes = []
    ): string {
        $html = '';

        if ($icon !== '') {
            $html = "\n" .
                Html::openTag('span', $iconAttributes) .
                    Html::tag('i', '', ['class' => $icon]) .
                Html::closeTag('span') . "\n";
        }

        if ($label !== '') {
            $html .= $label;
        }

        return $html;
    }
}
