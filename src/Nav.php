<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use JsonException;
use RuntimeException;
use Yiisoft\Arrays\ArrayHelper;
use Yiisoft\Html\Html;

use function is_array;
use function is_string;

/**
 * Nav renders a nav HTML component.
 *
 * {@see https://getbootstrap.com/docs/5.0/components/navs-tabs/}
 */
final class Nav extends Widget
{
    private bool $activateItems = true;
    private bool $activateParents = false;
    private string $currentPath = '';
    private array $items = [];
    private array $liAttributes = [];
    private bool $withoutContainer = false;

    protected function run(): string
    {
        $new = clone $this;

        if (!isset($new->attributes['id'])) {
            $new->attributes['id'] = "{$new->getId()}-nav";
        }

        Html::addCssClass($new->attributes, ['widget' => 'nav']);

        return $new->renderItems();
    }

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
     * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#fill-and-justify
     */
    public function fillAndJustify(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, ['fillAndJustify' => 'nav-pills nav-fill']);
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#horizontal-alignment
     */
    public function horizontal(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, ['horizontal' => 'justify-content-center']);
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
     * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#pills
     */
    public function pills(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, ['pills' => 'nav-pills']);
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#tabs
     */
    public function tabs(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, ['tabs' => 'nav-tabs']);
        return $new;
    }

    /**
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#vertical
     */
    public function vertical(): self
    {
        $new = clone $this;
        Html::addCssClass($new->attributes, ['vertical' => 'flex-column']);
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
     * @link https://getbootstrap.com/docs/5.0/components/navs-tabs/#base-nav
     */
    public function withoutContainer(): self
    {
        $new = clone $this;
        $new->withoutContainer = true;
        return $new;
    }

    /**
     * Checks whether a menu item is active.
     *
     * This is done by checking if {@see currentPath} match that specified in the `url` option of the menu item. When
     * the `url` option of a menu item is specified in terms of an array, its first element is treated as the
     * currentPath for the item and the rest of the elements are the associated parameters. Only when its currentPath
     * and parameters match {@see currentPath}, respectively, will a menu item be considered active.
     *
     * @param string $url
     * @param string $currentPath
     * @param bool $activateItems
     *
     * @return bool whether the menu item is active
     */
    private function isItemActive(string $url, string $currentPath, bool $activateItems): bool
    {
        return ($currentPath !== '/') && ($url === $currentPath) && $activateItems;
    }

    /**
     * Renders widget items.
     *
     * @throws JsonException|RuntimeException
     *
     * @return string
     */
    private function renderItems(): string
    {
        $new = clone $this;
        $items = [];

        /** @var array|string $item */
        foreach ($new->items as $item) {
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }

            $items[] = is_string($item) ? $item : $new->renderItem($item);
        }

        $html = implode("\n", $items);

        if ($new->withoutContainer === false) {
            $html = Html::tag('ul', "\n" . implode("\n", $items) . "\n", $new->attributes)->encode(false)->render();
        }

        return $html;
    }

    /**
     * Renders a widget's item.
     *
     * @param array $item the item to render.
     *
     * @throws JsonException|RuntimeException
     *
     * @return string the rendering result.
     */
    private function renderItem(array $item): string
    {
        $new = clone $this;

        if (!isset($item['label'])) {
            throw new RuntimeException("The 'label' option is required.");
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

        /** @var bool */
        $active = $item['active'] ?? $new->isItemActive($url, $new->currentPath, $new->activateItems);

        /** @var bool */
        $disabled = isset($item['disabled']) ? $item['disabled'] : false;

        $lines = '';

        if ($items !== []) {
            $urlAttributes['data-bs-toggle'] = 'dropdown';
            $liAttributes['id'] = "{$new->getId()}-dropdown";
            $item['dropdownAttributes'] = ['aria-labelledby' => $liAttributes['id']];
            $items = $new->isChildActive($items, $active);
            $lines = "\n" . $new->renderDropdown($items, $item) . "\n";

            Html::addCssClass($liAttributes, ['widget' => 'dropdown']);
            Html::addCssClass($urlAttributes, ['widget' => 'dropdown-toggle']);
        }

        Html::addCssClass($liAttributes, ['nav' => 'nav-item']);
        Html::addCssClass($urlAttributes, ['urlAttributes' => 'nav-link']);

        if ($new->activateItems && $active) {
            $urlAttributes['aria-current'] = 'page';
            Html::addCssClass($urlAttributes, ['active' => 'active']);
        } elseif ($disabled) {
            $urlAttributes['tabindex'] = '-1';
            $urlAttributes['aria-disabled'] = 'true';
            Html::addCssClass($urlAttributes, ['disabled' => 'disabled']);
        }

        return
            Html::openTag('li', $liAttributes) .
                Html::a($itemLabel, $url, $urlAttributes)->encode(false) . $lines .
            Html::closeTag('li');
    }

    /**
     * Renders the given items as a dropdown.
     *
     * This method is called to create sub-menus.
     *
     * @param array $items the given items. Please refer to {@see Dropdown::items} for the array structure.
     * @param array $parentItem the parent item information. Please refer to {@see items} for the structure of this
     * array.
     *
     * @return string the rendering result.
     */
    private function renderDropdown(array $items, array $parentItem): string
    {
        /** @var array */
        $dropdownAttributes = isset($parentItem['dropdownAttributes']) ? $parentItem['dropdownAttributes'] : [];
        return Dropdown::widget()->attributes($dropdownAttributes)->items($items)->render();
    }

    /**
     * Check to see if a child item is active optionally activating the parent.
     *
     * @param array $items
     * @param bool $active should the parent be active too
     *
     * @return array
     *
     * {@see items}
     */
    private function isChildActive(array $items, bool &$active): array
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
                $activeParent = false;
                $items[$i]['items'] = $new->isChildActive($childItems, $activeParent);

                if ($activeParent) {
                    $items[$i]['attributes'] = ['active' => true];
                    $active = true;
                }
            }
        }

        return $items;
    }
}
