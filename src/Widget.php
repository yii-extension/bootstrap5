<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use Yiisoft\Html\NoEncodeStringableInterface;
use Yiisoft\Widget\Widget as AbstractWidget;

abstract class Widget extends AbstractWidget implements NoEncodeStringableInterface
{
    protected array $attributes = [];
    private string $id = '';
    private string $autoIdPrefix = 'w';
    private static int $counter = 0;

    /**
     * Add HTML attribute for key and value.
     *
     * @param string $key Attribute name.
     * @param mixed $value Attribute value.
     *
     * @return static
     */
    public function addAttribute(string $key, $value): self
    {
        $new = clone $this;
        $new->attributes[$key] = $value;
        return $new;
    }

    /**
     * The HTML attributes for the navbar.
     *
     * The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function attributes(array $value): self
    {
        $new = clone $this;
        $new->attributes = $value;
        return $new;
    }

    /**
     * The prefix to the automatically generated widget IDs.
     *
     * @param string $value
     *
     * @return static
     *
     * {@see getId()}
     */
    public function autoIdPrefix(string $value): self
    {
        $new = clone $this;
        $new->autoIdPrefix = $value;
        return $new;
    }

    /**
     * Set the Id of the widget.
     *
     * @param string $value
     *
     * @return static
     */
    public function id(string $value): self
    {
        $new = clone $this;
        $new->id = $value;
        return $new;
    }

    /**
     * Counter used to generate {@see id} for widgets.
     *
     * @param int $value
     */
    public static function counter(int $value): void
    {
        self::$counter = $value;
    }

    protected function getId(): string
    {
        return $this->id;
    }

    /**
     * Returns the Id of the widget.
     *
     * @return string Id of the widget.
     */
    protected function generateId(): string
    {
        return $this->autoIdPrefix . static::$counter++;
    }
}
