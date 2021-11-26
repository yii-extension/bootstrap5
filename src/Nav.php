<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use InvalidArgumentException;
use JsonException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\A;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Li;
use Yiisoft\Html\Tag\Span;

use function is_array;
use function is_string;

/**
 * Nav renders a nav HTML component.
 *
 * {@see https://getbootstrap.com/docs/5.1/components/navs-tabs/}
 */
final class Nav extends Widget
{
    private bool $activateItems = true;
    private bool $activateParents = false;
    private string $currentPath = '';
    private array $items = [];
    private array $liAttributes = [];
    private bool $withoutContainer = false;

    /**
     * Whether to activate parent menu items when one of the corresponding child menu items is active.
     *
     * @return static
     */
    public function activateParents(): self
    {
        $new = clone $this;
        $new->activateParents = true;
        return $new;
    }

    /**
     * Allows you to assign the current path of the url from request controller.
     *
     * @param string $value
     *
     * @return static
     */
    public function currentPath(string $value): self
    {
        $new = clone $this;
        $new->currentPath = $value;
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/navs-tabs/#fill-and-justify
     */
    public function fillAndJustify(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, 'nav-pills nav-fill');
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/navs-tabs/#horizontal-alignment
     */
    public function horizontal(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, 'justify-content-center');
        return $new;
    }

    /**
     * List of items in the nav widget. Each array element represents a single  menu item which can be either a string
     * or an array with the following structure:
     *
     * - label: string, required, the nav item label.
     * - url: optional, the item's URL. Defaults to "#".
     * - visible: bool, optional, whether this menu item is visible. Defaults to true.
     * - linkOptions: array, optional, the HTML attributes of the item's link.
     * - attributes: array, optional, the HTML attributes of the item container (LI).
     * - active: bool, optional, whether the item should be on active state or not.
     * - dropdownOptions: array, optional, the HTML attributes that will passed to the {@see Dropdown} widget.
     * - items: array|string, optional, the configuration array for creating a {@see Dropdown} widget, or a string
     *   representing the dropdown menu. Note that Bootstrap does not support sub-dropdown menus.
     * - encode: bool, optional, whether the label will be HTML-encoded. If set, supersedes the $encodeLabels option for
     *   only this item.
     *
     * If a menu item is a string, it will be rendered directly without HTML encoding.
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
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/navs-tabs/#pills
     */
    public function pills(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, 'nav-pills');
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/navs-tabs/#tabs
     */
    public function tabs(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, 'nav-tabs');
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/navs-tabs/#vertical
     */
    public function vertical(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, 'flex-column');
        return $new;
    }

    /**
     * Disable activate items according to whether their currentPath.
     *
     * @return static
     *
     * {@see isItemActive}
     */
    public function withoutActivateItems(): self
    {
        $new = clone $this;
        $new->activateItems = false;
        return $new;
    }

    /**
     * Disable container widget.
     *
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/navs-tabs/#base-nav
     */
    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->withoutContainer = true;
        return $new;
    }

    protected function run(): string
    {
        $new = clone $this;

        if (!isset($new->attributes['id'])) {
            $new->attributes['id'] = "{$new->generateId()}-nav";
        }

        Html::addCssClass($new->attributes, 'nav');

        return $new->renderItems();
    }

    private function isChildActive(array $items, bool &$active = false): array
    {
        $new = clone $this;

        /** @var array|string $child */
        foreach ($items as $i => $child) {
            /** @var string */
            $url = isset($child['url']) ? $child['url'] : '#';

            /** @var bool */
            $active = isset($child['active']) ? $child['active'] : false;

            if ($active === false && is_array($items[$i])) {
                $items[$i]['active'] = $new->isItemActive($url, $new->currentPath, $new->activateItems);
            }

            if ($new->activateParents) {
                $active = true;
            }

            /** @var array */
            $childItems = isset($child['items']) ? $child['items'] : [];

            if ($childItems !== [] && is_array($items[$i])) {
                $items[$i]['items'] = $new->isChildActive($childItems);

                if ($active) {
                    $items[$i]['attributes'] = ['active' => true];
                    $active = true;
                }
            }
        }

        return $items;
    }

    private function isItemActive(string $url, string $currentPath, bool $activateItems): bool
    {
        return ($currentPath !== '/') && ($url === $currentPath) && $activateItems;
    }

    private function renderDropdown(array $items, array $parentItem): string
    {
        /** @var array */
        $dropdownAttributes = isset($parentItem['dropdownAttributes']) ? $parentItem['dropdownAttributes'] : [];
        return Dropdown::widget()->attributes($dropdownAttributes)->items($items)->render();
    }

    private function renderItems(): string
    {
        $new = clone $this;
        $items = [];

        /** @var array|string $item */
        foreach ($new->items as $item) {
            /** @var bool */
            $visible = isset($item['visible']) ? $item['visible'] : true;

            if ($visible) {
                $items[] = is_string($item) ? $item : $new->renderItem($item);
            }
        }

        $html = implode(PHP_EOL, $items);

        if ($new->withoutContainer === false) {
            $html = CustomTag::name('ul')
                ->attributes($new->attributes)
                ->content(PHP_EOL . implode(PHP_EOL, $items) . PHP_EOL)
                ->encode(false)
                ->render();
        }

        return $html;
    }

    private function renderItem(array $item): string
    {
        $new = clone $this;

        if (!isset($item['label'])) {
            throw new InvalidArgumentException("The 'label' option is required.");
        }

        /** @var string */
        $itemLabel = $item['label'] ?? '';

        if (isset($item['encode']) && $item['encode'] === true) {
            $itemLabel = Html::encode($itemLabel);
        }

        /** @var array */
        $liAttributes = isset($item['attributes']) ? $item['attributes'] : [];

        /** @var array */
        $items = isset($item['items']) ? $item['items'] : [];

        /** @var string */
        $url = $item['url'] ?? '#';

        /** @var array */
        $urlAttributes = isset($item['urlAttributes']) ? $item['urlAttributes'] : [];

        /** @var string */
        $icon = $item['icon'] ?? '';

        /** @var array */
        $iconAttributes = isset($item['iconAttributes']) ? $item['iconAttributes'] : [];

        /** @var bool */
        $active = $item['active'] ?? $new->isItemActive($url, $new->currentPath, $new->activateItems);

        /** @var bool */
        $disabled = isset($item['disabled']) ? $item['disabled'] : false;

        $itemLabel = $new->renderLabel($itemLabel, $icon, $iconAttributes);

        $lines = '';

        if ($items !== []) {
            $urlAttributes['data-bs-toggle'] = 'dropdown';
            $items = $new->isChildActive([$item], $active);
            $lines = $new->renderDropdown($items, $item);
        }

        Html::addCssClass($liAttributes, 'nav-item');
        Html::addCssClass($urlAttributes, 'nav-link');

        if ($new->activateItems && $active) {
            $urlAttributes['aria-current'] = 'page';
            Html::addCssClass($urlAttributes, 'active');
        } elseif ($disabled) {
            $urlAttributes['tabindex'] = '-1';
            $urlAttributes['aria-disabled'] = 'true';
            Html::addCssClass($urlAttributes, 'disabled');
        }

        if ($lines === '') {
            $html = Li::tag()
                ->attributes($liAttributes)
                ->content(A::tag()->attributes($urlAttributes)->content($itemLabel)->encode(false)->url($url)->render())
                ->encode(false)
                ->render();
        } else {
            $html = Li::tag()->class('nav-item dropdown')->content(PHP_EOL . $lines . PHP_EOL)->encode(false)->render();
        }

        return $html;
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
