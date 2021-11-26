<?php

declare(strict_types=1);

namespace Yii\Extension\Bootstrap5;

use InvalidArgumentException;
use JsonException;
use Yiisoft\Html\Html;
use Yiisoft\Html\Tag\Button;
use Yiisoft\Html\Tag\CustomTag;
use Yiisoft\Html\Tag\Div;

use function array_merge;

/**
 * Modal renders a modal window that can be toggled by clicking on a button.
 *
 * @link https://getbootstrap.com/docs/5.1/components/modal/
 */
final class Modal extends Widget
{
    public const FULL_SCREEN = 'modal-fullscreen';
    public const FULL_SCREEN_SM_DOWM = 'modal-fullscreen-sm-down';
    public const FULL_SCREEN_MD_DOWN = 'modal-fullscreen-md-down';
    public const FULL_SCREEN_LG_DOWN = 'modal-fullscreen-lg-down';
    public const FULL_SCREEN_XL_DOWN = 'modal-fullscreen-xl-down';
    public const FULL_SCREEN_XXL_DOWN = 'modal-fullscreen-xxl-down';
    public const SIZE_EXTRA_LARGE = 'modal-xl';
    public const SIZE_LARGE = 'modal-lg';
    public const SIZE_SMALL = 'modal-sm';
    public const SIZE_DEFAULT = '';
    /** @psalm-var array<array-key, string> */
    private const FULL_SCREEN_ALL = [
        self::FULL_SCREEN,
        self::FULL_SCREEN_SM_DOWM,
        self::FULL_SCREEN_MD_DOWN,
        self::FULL_SCREEN_LG_DOWN,
        self::FULL_SCREEN_XL_DOWN,
        self::FULL_SCREEN_XXL_DOWN,
    ];
    /** @psalm-var array<array-key, string> */
    private const SIZE_ALL = [
        self::SIZE_EXTRA_LARGE,
        self::SIZE_LARGE,
        self::SIZE_SMALL,
    ];

    private array $bodyAttributes = [];
    private string $bodyContent = '';
    private array $closeButtonAttributes = [];
    private string $closeButtonContent = '';
    private array $contentAttributes = [];
    private array $dialogAttributes = [];
    private string $footer = '';
    private array $footerAttributes = [];
    private string $fullScreen = '';
    private array $headerAttributes = [];
    private string $scrollable = '';
    private string $size = '';
    private bool $staticBackdrop = false;
    private string $headerTitle = '';
    private array $headerTitleAttributes = [];
    private array $toggleButtonAttributes = [];
    private string $toggleButtonContent = '';
    private string $verticalCenter = '';
    private bool $withoutCloseButton = false;
    private bool $withoutToggleButton = false;

    /**
     * Body attribute HTML
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function bodyAttributes(array $value): self
    {
        $new = clone $this;
        $new->bodyAttributes = $value;
        return $new;
    }

    /**
     * Body content.
     *
     * @param string $value
     *
     * @return static
     */
    public function bodyContent(string $value): self
    {
        $new = clone $this;
        $new->bodyContent = $value;
        return $new;
    }

    /**
     * The attributes HTML for rendering the close button tag.
     *
     * The close button is displayed in the header of the modal window. Clicking on the button will hide the modal
     * window. If {@see withoutCloseButton} is true, no close button will be rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function closeButtonAttributes(array $value): self
    {
        $new = clone $this;
        $new->closeButtonAttributes = $value;
        return $new;
    }

    /**
     * The HTML attributes for modal content.
     *
     * The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function contentAttributes(array $value): self
    {
        $new = clone $this;
        $new->contentAttributes = $value;
        return $new;
    }

    /**
     * The HTML attributes for modal dialog.
     *
     * The following special options are recognized.
     *
     * @param array $value
     *
     * @return static
     */
    public function dialogAttributes(array $value): self
    {
        $new = clone $this;
        $new->dialogAttributes = $value;
        return $new;
    }

    /**
     * The footer content in the modal window.
     *
     * @param string $value
     *
     * @return static
     */
    public function footer(string $value): self
    {
        $new = clone $this;
        $new->footer = $value;
        return $new;
    }

    /**
     * Additional footer attributes.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function footerAttributes(array $value): self
    {
        $new = clone $this;
        $new->footerAttributes = $value;
        return $new;
    }

    public function fullScreen(string $value): self
    {
        if (!in_array($value, self::FULL_SCREEN_ALL, true)) {
            $values = implode('", "', self::FULL_SCREEN_ALL);
            throw new InvalidArgumentException("Invalid size. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->fullScreen = $value;
        return $new;
    }

    /**
     * Additional header attributes.
     *
     * @param array $value
     *
     * @return static
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     */
    public function headerAttributes(array $value): self
    {
        $new = clone $this;
        $new->headerAttributes = $value;
        return $new;
    }

    /**
     * The headerTitle content in the modal window.
     *
     * @param string $value
     *
     * @return static
     */
    public function headerTitle(string $value): self
    {
        $new = clone $this;
        $new->headerTitle = $value;
        return $new;
    }

    /**
     * Additional headerTitle attributes HTML.
     *
     * {@see Html::renderTagAttributes()} for details on how attributes are being rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function headerTitleAttributes(array $value): self
    {
        $new = clone $this;
        $new->headerTitleAttributes = $value;
        return $new;
    }

    /**
     * When modals become too long for the user’s viewport or device, they scroll independent of the page itself.
     * Try the demo below to see what we mean.
     *
     * @param string $value
     *
     * @return static
     */
    public function scrollable(): self
    {
        $new = clone $this;
        $new->scrollable = 'modal-dialog-scrollable';
        return $new;
    }

    /**
     * The modal size. Can be {@see SIZE_LARGE} or {@see SIZE_SMALL}, {@see EXTRA_LARGE} or null for default.
     *
     * @param string $value
     *
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#optional-sizes
     */
    public function size(string $value): self
    {
        if (!in_array($value, self::SIZE_ALL, true)) {
            $values = implode('", "', self::SIZE_ALL);
            throw new InvalidArgumentException("Invalid size. Valid values are: \"$values\".");
        }

        $new = clone $this;
        $new->size = $value;
        return $new;
    }

    /**
     * When backdrop is set to static, the modal will not close when clicking outside it. Click the button below to try
     * it.
     *
     * @return static
     *
     * @link https://getbootstrap.com/docs/5.1/components/modal/#static-backdrop
     */
    public function staticBackdrop(): self
    {
        $new = clone $this;
        $new->staticBackdrop = true;
        return $new;
    }

    /**
     * The HTML for rendering the toggle button tag.
     *
     * The toggle button is used to toggle the visibility of the modal window. If {@see withoutToggleButton} is true,
     * no toggle button will be rendered.
     *
     * @param array $value
     *
     * @return static
     */
    public function toggleButtonAttributes(array $value): self
    {
        $new = clone $this;
        $new->toggleButtonAttributes = $value;
        return $new;
    }

    /**
     * Toggle button content.
     *
     * @param string $value
     *
     * @return static
     */
    public function toggleButtonContent(string $value): self
    {
        $new = clone $this;
        $new->toggleButtonContent = $value;
        return $new;
    }

    /**
     * Add .modal-dialog-centered to .modal-dialog to vertically center the modal.
     *
     * @return static
     */
    public function verticalCenter(): self
    {
        $new = clone $this;
        $new->verticalCenter = 'modal-dialog-centered';
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
        $new->withoutCloseButton = true;
        return $new;
    }

    /**
     * Disable toggle button.
     *
     * @return static
     */
    public function withoutToggleButton(): self
    {
        $new = clone $this;
        $new->withoutToggleButton = true;
        return $new;
    }

    protected function run(): string
    {
        $new = clone $this;

        if (!isset($new->attributes['id'])) {
            $new->attributes['id'] = "{$new->generateId()}-modal";
            $new = $new->id($new->attributes['id']);
        }

        return $new->renderModal();
    }

    private function renderBody(): string
    {
        $new = clone $this;
        Html::addCssClass($new->bodyAttributes, 'modal-body');
        return Div::tag()->attributes($new->bodyAttributes)->content($new->bodyContent)->encode(false)->render();
    }

    private function renderCloseButton(): string
    {
        $new = clone $this;
        Html::addCssClass($new->closeButtonAttributes, 'btn-close');
        $new->closeButtonAttributes['data-bs-dismiss'] = 'modal';
        $new->closeButtonAttributes['aria-label'] = 'Close';
        return Button::tag()
            ->attributes($new->closeButtonAttributes)
            ->content($new->closeButtonContent)
            ->encode(false)
            ->type('button')
            ->render() . PHP_EOL;
    }

    public function renderContent(): string
    {
        $new = clone $this;
        Html::addCssClass($new->contentAttributes, 'modal-content');
        $content = PHP_EOL .
            $new->renderHeader() . PHP_EOL . $new->renderBody() . PHP_EOL . $new->renderFooter() . PHP_EOL;
        return Div::tag()->attributes($new->contentAttributes)->content($content)->encode(false)->render();
    }

    public function renderDialog(): string
    {
        $new = clone $this;
        Html::addCssClass($new->dialogAttributes, 'modal-dialog');

        if ($new->fullScreen !== '') {
            Html::addCssClass($new->dialogAttributes, $new->fullScreen);
        }

        if ($new->scrollable !== '') {
            Html::addCssClass($new->dialogAttributes, $new->scrollable);
        }

        if ($new->size !== '') {
            Html::addCssClass($new->dialogAttributes, $new->size);
        }

        if ($new->verticalCenter !== '') {
            Html::addCssClass($new->dialogAttributes, $new->verticalCenter);
        }

        return Div::tag()
            ->attributes($new->dialogAttributes)
            ->content(PHP_EOL . $new->renderContent() . PHP_EOL)
            ->encode(false)
            ->render();
    }

    private function renderFooter(): string
    {
        $new = clone $this;
        Html::addCssClass($new->footerAttributes, 'modal-footer');
        return Div::tag()->attributes($new->footerAttributes)->content($new->footer)->encode(false)->render();
    }

    private function renderHeader(): string
    {
        $new = clone $this;
        $button = $new->renderCloseButton();
        $header = $new->headerTitle;

        if ($new->headerTitle !== '') {
            Html::addCssClass($new->headerTitleAttributes, 'modal-header');
            $new->headerTitleAttributes['id'] = $new->getId() . '-label';
            $header = CustomTag::name('h5')
                ->attributes($new->headerTitleAttributes)
                ->content($new->headerTitle)
                ->render();
        }

        if ($new->withoutCloseButton === false) {
            $header .= PHP_EOL . $button;
        }

        Html::addCssClass($new->headerAttributes, 'modal-header');
        return Div::tag()->attributes($new->headerAttributes)->content($header)->encode(false)->render();
    }

    private function renderToggleButton(): string
    {
        $new = clone $this;
        $id = $new->getId();
        $new->toggleButtonAttributes['data-bs-toggle'] = 'modal';
        $new->toggleButtonAttributes['data-bs-target'] = "#$id";
        return Button::tag()
            ->attributes($new->toggleButtonAttributes)
            ->content($new->toggleButtonContent)
            ->encode(false)
            ->type('button')
            ->render();
    }

    /**
     * @link https://getbootstrap.com/docs/5.1/components/modal/#modal-components
     */
    private function renderModal(): string
    {
        $new = clone $this;
        $new->attributes['aria-labelledby'] = $new->getId() . '-label';
        $new->attributes['aria-hidden'] = "true";
        $new->attributes['class'] = 'modal';
        $new->attributes['tabindex'] = '-1';

        if ($new->staticBackdrop === true) {
            $new->attributes['data-bs-backdrop'] = 'static';
            $new->attributes['data-bs-keyboard'] = 'false';
        }

        $div = Div::tag()
            ->attributes($new->attributes)
            ->content(PHP_EOL . $new->renderDialog() . PHP_EOL)
            ->encode(false)
            ->render();
        $html = $new->renderToggleButton() . PHP_EOL . $div;

        if ($new->withoutToggleButton === true) {
            $html = $div;
        }

        return $html;
    }
}
