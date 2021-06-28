<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use InvalidArgumentException;
use ReflectionException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;
use Yiisoft\Html\Tag\Span;

use function array_merge;

/**
 * Dropdown renders a Bootstrap dropdown menu component.
 */
final class Dropdown extends Widget
{
    private array $items = [];
    private array $submenuAttributes = [];

    /**
     * @throws ReflectionException
     */
    protected function run(): string
    {
        $new = clone $this;

        Html::addCssClass($new->attributes, 'dropdown-menu');

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
     * @return static
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
     * @return static
     */
    public function submenuAttributes(array $value): self
    {
        $new = clone $this;
        $new->submenuAttributes = $value;
        return $new;
    }

    /**
     * Renders menu items.
     *
     * @throws InvalidArgumentException|ReflectionException if the label option is not specified in one of the items.
     *
     * @return string the rendering result.
     */
    private function renderItems(self $new): string
    {
        $lines = [];

        /** @var array|string $item */
        foreach ($new->items as $item) {
            if ($item === '-') {
                $lines[] = Div::tag()->class('dropdown-divider')->render();
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
                $items = $item['items'] ?? [];

                /** @var array */
                $itemAttributes = $item['attributes'] ?? [];

                /** @var array */
                $urlAttributes = $item['urlAttributes'] ?? [];

                /** @var string */
                $icon = $item['icon'] ?? '';

                /** @var array */
                $iconAttributes = isset($item['iconAttributes']) ? $item['iconAttributes'] : [];

                /** @var string */
                $url = $item['url'] ?? '';

                /** @var bool */
                $active = $item['active'] ?? false;

                /** @var bool */
                $disabled = $item['disable'] ?? false;

                /** @var bool */
                $enclose = $item['enclose'] ?? true;

                $itemLabel = $new->renderLabel($itemLabel, $icon, $iconAttributes);

                Html::addCssClass($urlAttributes, 'dropdown-item');

                if ($disabled) {
                    $urlAttributes['tabindex'] = '-1';
                    $urlAttributes['aria-disabled'] = 'true';
                    Html::addCssClass($urlAttributes, 'disabled');
                } elseif ($active) {
                    Html::addCssClass($urlAttributes, 'active');
                }

                if ($items === []) {
                    if ($itemLabel === '-') {
                        $content = Div::tag()->class('dropdown-divider')->render();
                    } elseif ($enclose === false) {
                        $content = $itemLabel;
                    } elseif ($url === '') {
                        $content = CustomTag::name('h6')
                            ->class('dropdown-header')
                            ->content($itemLabel)
                            ->encode(null)
                            ->render();
                    } else {
                        $content = A::tag()
                            ->attributes($urlAttributes)
                            ->content($itemLabel)
                            ->encode(false)
                            ->url($url)
                            ->render();
                    }

                    $lines[] = $content;
                } else {
                    /** @var array */
                    $submenuAttributes = isset($item['submenuAttributes']) ? $item['submenuAttributes'] : [];
                    $new->submenuAttributes = array_merge($new->submenuAttributes, $submenuAttributes);

                    Html::addCssClass($new->submenuAttributes, 'dropdown-menu');
                    Html::addCssClass($urlAttributes, 'dropdown-toggle');

                    $dropdown = self::widget()
                        ->attributes($new->submenuAttributes)
                        ->items($items)
                        ->submenuAttributes($new->submenuAttributes)
                        ->render();

                    $id = "{$new->getId()}-dropdown";
                    $urlAttributes['id'] = $id;
                    $urlAttributes['aria-expanded'] = false;
                    $urlAttributes['data-bs-toggle'] = 'dropdown';
                    $urlAttributes['role'] = 'button';
                    $new->attributes['aria-labelledby'] = $id;

                    $attributes = array_merge($itemAttributes, $new->attributes);

                    $lines[] = A::tag()->attributes($urlAttributes)->content($itemLabel)->url($url) . PHP_EOL .
                        CustomTag::name('ul')
                            ->attributes($attributes)
                            ->content(PHP_EOL . $dropdown . PHP_EOL)
                            ->encode(false);
                }
            }
        }

        return implode(PHP_EOL, $lines);
    }

    private function renderLabel(
        string $label,
        string $icon,
        array $iconAttributes = []
    ): string {
        $html = '';

        if ($icon !== '') {
            $html = Span::tag()
                ->attributes($iconAttributes)
                ->content(CustomTag::name('i')->class($icon)->render())
                ->encode(false)
                ->render();
        }

        if ($label !== '') {
            $html .= $label;
        }

        return $html;
    }
}
