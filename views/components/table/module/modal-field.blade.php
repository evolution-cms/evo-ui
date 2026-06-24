@php
    $name = (string) $field['name'];
    $type = (string) ($field['type'] ?? 'text');
    $label = __((string) ($field['label'] ?? $name));
    $showLabel = ($field['show_label'] ?? ($field['label_visible'] ?? true)) !== false && ($field['label'] ?? null) !== false;
    $hint = !empty($field['hint']) ? __((string) $field['hint']) : '';
    $help = $field['help'] ?? $field['description'] ?? null;
    $helpText = $help ? __((string) $help) : '';
    $placeholder = !empty($field['placeholder']) ? __((string) $field['placeholder']) : '';
    $fieldIdSuffix = (string) ($field['id_suffix'] ?? '');
    $fieldId = 'evo-modal-' . preg_replace('/[^a-z0-9_-]/i', '-', trim($controller->preset . '-' . $name . '-' . $fieldIdSuffix, '-'));
    $section = preg_replace('/[^a-z0-9_-]/i', '-', (string) ($field['section'] ?? ''));
    $fieldClass = trim('evo-ui-field evo-ui-field--modal ' .
        (($field['span'] ?? '') === 'full' ? 'evo-ui-field--full ' : '') .
        (!$showLabel ? 'evo-ui-field--no-label ' : '') .
        ($section !== '' ? 'evo-ui-field--section-' . $section : ''));
    $model = 'modalData.' . $name;
    $value = data_get($controller->modalData, $name, '');
    $errorKey = 'modalData.' . $name;
    $hasError = $errors->has($errorKey);
    $fieldTab = (string) ($field['tab'] ?? $defaultModalTab);
    $gridRow = trim((string) ($field['grid_row'] ?? ''));
    $fieldStyle = preg_match('/^\d+(?:\s*\/\s*\d+)?$/', $gridRow) ? 'grid-row: ' . $gridRow . ';' : '';
    $visibleIf = is_array($field['visible_if'] ?? null) ? $field['visible_if'] : [];
    $visibleIfField = (string) ($visibleIf['field'] ?? '');
    $visibleIfExpected = $visibleIf['value'] ?? true;
    $visibilityExpression = '';

    if ($modalTabs->isNotEmpty() && $fieldTab !== '') {
        $visibilityExpression = 'selectedModalTab === ' . json_encode($fieldTab, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    if ($visibleIfField !== '') {
        $fieldExpression = 'fieldVisible('
            . json_encode($visibleIfField, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            . ', '
            . json_encode($visibleIfExpected, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
            . ')';
        $visibilityExpression = $visibilityExpression !== ''
            ? '(' . $visibilityExpression . ') && ' . $fieldExpression
            : $fieldExpression;
    }

    $colorFallback = (string) ($field['default'] ?? '#64748B');
    $colorFallback = preg_match('/^#[0-9a-f]{6}$/i', $colorFallback) ? strtoupper($colorFallback) : '#64748B';
@endphp

@if($type === 'hidden')
    <input id="{{ $fieldId }}" type="hidden" wire:model.live="{{ $model }}">
@elseif($type === 'section')
    @php
        $sectionIcon = (string) ($field['icon'] ?? '');
    @endphp
    <div
        class="evo-ui-modal-section-title {{ $section !== '' ? 'evo-ui-modal-section-title--section-' . $section : '' }}"
        @if($fieldStyle !== '')
            style="{{ $fieldStyle }}"
        @endif
        @if($visibilityExpression !== '')
            x-show="{{ $visibilityExpression }}"
            x-cloak
        @endif
    >
        @if($sectionIcon !== '')
            <x-evo::icon :name="$sectionIcon" />
        @endif
        <span>{{ $label }}</span>
    </div>
@else
    <div
        class="{{ $fieldClass }} {{ $hasError ? 'has-error' : '' }}"
        @if($fieldStyle !== '')
            style="{{ $fieldStyle }}"
        @endif
        @if($visibilityExpression !== '')
            x-show="{{ $visibilityExpression }}"
            x-cloak
        @endif
    >
        <label class="{{ $showLabel ? 'evo-ui-field__label' : 'evo-ui-sr-only' }}" for="{{ $fieldId }}">
            <span>
                <span>{{ $label }}</span>
            </span>
            @if($helpText !== '')
                <span
                    class="evo-ui-field__help"
                    aria-label="{{ $helpText }}"
                    data-tooltip="{{ $helpText }}"
                    data-evo-tooltip="{{ $helpText }}"
                    tabindex="0"
                >?</span>
            @endif
        </label>

        @if($type === 'static')
            @php
                $staticValue = is_scalar($value) || $value === null
                    ? (string) $value
                    : json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            @endphp
            <div id="{{ $fieldId }}" class="evo-ui-static-field">{{ $staticValue }}</div>
        @elseif($type === 'code')
            @php
                $codeValue = is_scalar($value) || $value === null
                    ? (string) $value
                    : json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            @endphp
            <pre id="{{ $fieldId }}" class="evo-ui-code-block">{{ $codeValue }}</pre>
        @elseif($type === 'badge')
            <div id="{{ $fieldId }}" class="evo-ui-static-field">
                <x-evo::badge :value="$value" />
            </div>
        @elseif($type === 'repeater')
            @php
                $items = array_values((array) data_get($controller->modalData, $name, []));
                $repeaterLayout = (string) ($field['layout'] ?? '');
                $itemFields = collect((array) ($field['fields'] ?? []))
                    ->filter(fn ($itemField) => is_array($itemField) && !empty($itemField['name']))
                    ->values()
                    ->all();
                $addLabel = __((string) ($field['add_label'] ?? 'global.add'));
            @endphp
            <div @class([
                'evo-ui-repeater',
                'evo-ui-repeater--compact' => $repeaterLayout === 'compact',
                'evo-ui-repeater--status-phases' => $repeaterLayout === 'status-phases',
            ])>
                <div class="evo-ui-repeater__toolbar">
                    <button type="button" class="evo-ui-btn evo-ui-btn--icon evo-ui-btn--success" title="{{ $addLabel }}" aria-label="{{ $addLabel }}" wire:click="addModalItem('{{ $name }}')">
                        <x-evo::icon name="plus" class="evo-ui-btn__icon" />
                    </button>
                    <span>{{ $hint }}</span>
                </div>

                <div class="evo-ui-repeater__rows">
                    @forelse($items as $index => $item)
                        <div class="evo-ui-repeater__row" wire:key="modal-{{ $controller->preset }}-{{ $name }}-{{ $index }}">
                            <div class="evo-ui-repeater__sort">
                                <button type="button" wire:click="moveModalItem('{{ $name }}', {{ $index }}, 'up')" title="@lang('evo::global.previous')" aria-label="@lang('evo::global.previous')">
                                    <x-evo::icon name="chevron-up" />
                                </button>
                                <span class="evo-ui-badge">{{ $index + 1 }}</span>
                                <button type="button" wire:click="moveModalItem('{{ $name }}', {{ $index }}, 'down')" title="@lang('evo::global.next')" aria-label="@lang('evo::global.next')">
                                    <x-evo::icon name="chevron-down" />
                                </button>
                            </div>

                            <div class="evo-ui-repeater__fields">
                                @foreach($itemFields as $itemField)
                                    @php
                                        $itemName = (string) $itemField['name'];
                                        $itemType = (string) ($itemField['type'] ?? 'text');
                                        $itemLabel = __((string) ($itemField['label'] ?? $itemName));
                                        $itemPlaceholder = !empty($itemField['placeholder']) ? __((string) $itemField['placeholder']) : $itemLabel;
                                        $itemIcon = (string) ($itemField['icon'] ?? '');
                                        $itemSpan = (string) ($itemField['span'] ?? '');
                                        $hideItemLabel = (bool) ($itemField['hide_label'] ?? false);
                                        $itemModel = 'modalData.' . $name . '.' . $index . '.' . $itemName;
                                        $itemValue = data_get($item, $itemName, '');
                                        $itemErrorKey = 'modalData.' . $name . '.' . $index . '.' . $itemName;
                                    @endphp
                                    @if($itemType === 'hidden')
                                        <input type="hidden" wire:model.live="{{ $itemModel }}">
                                    @else
                                        <label @class([
                                            'evo-ui-repeater__field',
                                            'evo-ui-repeater__field--grow' => $itemSpan === 'grow',
                                            'evo-ui-repeater__field--wide' => $itemSpan === 'wide',
                                            'evo-ui-repeater__field--full' => $itemSpan === 'full',
                                            'evo-ui-repeater__field--compact' => $itemSpan === 'compact',
                                            'evo-ui-repeater__field--hide-label' => $hideItemLabel,
                                            'evo-ui-repeater__field--type-' . preg_replace('/[^a-z0-9_-]/i', '-', $itemType),
                                        ])>
                                            <span @class([
                                                'evo-ui-repeater__label',
                                                'evo-ui-sr-only' => $hideItemLabel,
                                            ])>{{ $itemLabel }}</span>
                                            @if(in_array($itemType, ['static', 'badge'], true))
                                                <span class="{{ $itemType === 'badge' ? 'evo-ui-badge' : 'evo-ui-repeater__static' }}">{{ $itemValue }}</span>
                                            @elseif($itemType === 'checkbox')
                                                <span class="evo-ui-checkbox">
                                                    <input type="checkbox" wire:model.live="{{ $itemModel }}">
                                                </span>
                                            @elseif(in_array($itemType, ['color', 'color-picker'], true))
                                                @php
                                                    $itemRawColor = (string) data_get($item, $itemName, '');
                                                    $itemColorFallback = (string) ($itemField['default'] ?? '#64748B');
                                                    $itemColorFallback = preg_match('/^#[0-9a-f]{6}$/i', $itemColorFallback) ? strtoupper($itemColorFallback) : '#64748B';
                                                    $itemHexColor = preg_match('/^#[0-9a-f]{6}$/i', $itemRawColor) ? strtoupper($itemRawColor) : $itemColorFallback;
                                                @endphp
                                                <span class="evo-ui-color-field">
                                                    <input
                                                        class="evo-ui-color-field__picker"
                                                        type="color"
                                                        value="{{ $itemHexColor }}"
                                                        wire:model.live="{{ $itemModel }}"
                                                        aria-label="{{ $itemLabel }}"
                                                    >
                                                    <input
                                                        class="evo-ui-input evo-ui-color-field__input"
                                                        type="text"
                                                        value="{{ $itemRawColor !== '' ? $itemRawColor : $itemHexColor }}"
                                                        wire:model.blur="{{ $itemModel }}"
                                                        maxlength="7"
                                                        pattern="#[0-9A-Fa-f]{6}"
                                                        placeholder="#64748B"
                                                        autocomplete="off"
                                                    >
                                                    <span class="evo-ui-color-field__swatch" style="--evo-ui-color-field-value: {{ $itemHexColor }};" aria-hidden="true"></span>
                                                </span>
                                            @elseif($itemType === 'textarea')
                                                <textarea class="evo-ui-textarea" rows="{{ (int) ($itemField['rows'] ?? 2) }}" wire:model.blur="{{ $itemModel }}" placeholder="{{ $itemPlaceholder }}"></textarea>
                                            @else
                                                @if($itemIcon !== '')
                                                    <span class="evo-ui-input-icon">
                                                        <x-evo::icon :name="$itemIcon" />
                                                        <input type="{{ $itemType === 'number' ? 'number' : 'text' }}" class="evo-ui-input evo-ui-input--with-icon" wire:model.blur="{{ $itemModel }}" autocomplete="off" placeholder="{{ $itemPlaceholder }}" @if($itemType === 'number') min="{{ (int) ($itemField['min'] ?? 0) }}" @endif>
                                                    </span>
                                                @else
                                                    <input type="{{ $itemType === 'number' ? 'number' : 'text' }}" class="evo-ui-input" wire:model.blur="{{ $itemModel }}" autocomplete="off" placeholder="{{ $itemPlaceholder }}" @if($itemType === 'number') min="{{ (int) ($itemField['min'] ?? 0) }}" @endif>
                                                @endif
                                            @endif

                                            @if($errors->has($itemErrorKey))
                                                <span class="evo-ui-field__error">{{ $errors->first($itemErrorKey) }}</span>
                                            @endif
                                        </label>
                                    @endif
                                @endforeach
                            </div>

                            <div class="evo-ui-row-actions evo-ui-repeater__actions">
                                <button type="button" class="evo-ui-row-action evo-ui-row-action--danger" title="@lang('global.remove')" aria-label="@lang('global.remove')" wire:click="removeModalItem('{{ $name }}', {{ $index }})">
                                    <x-evo::icon name="trash" />
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="evo-ui-empty">-</div>
                    @endforelse
                </div>
            </div>
        @elseif($type === 'image')
            @php
                $preview = $controller->modalImageUrl((string) $value);
            @endphp
            <div class="evo-ui-image-field">
                <button
                    type="button"
                    class="evo-ui-image-field__preview"
                    title="{{ $label }}"
                    aria-label="{{ $label }}"
                    x-on:click.prevent="EvoUI.browseImageField('{{ $fieldId }}')"
                >
                    @if($preview !== '')
                        <img src="{{ $preview }}" alt="{{ $label }}" loading="lazy" decoding="async">
                    @else
                        <x-evo::icon name="image" />
                    @endif
                </button>

                <div class="evo-ui-image-field__control">
                    <input id="{{ $fieldId }}" type="text" class="evo-ui-input" wire:model.live.debounce.250ms="{{ $model }}" autocomplete="off">
                    <button type="button" class="evo-ui-btn evo-ui-btn--icon" title="@lang('evo::global.action_browse')" aria-label="@lang('evo::global.action_browse')" x-on:click.prevent="EvoUI.browseImageField('{{ $fieldId }}')">
                        <x-evo::icon name="folder-open" class="evo-ui-btn__icon" />
                    </button>
                </div>
            </div>
        @elseif($type === 'radio')
            <div class="evo-ui-choice-list evo-ui-choice-list--inline evo-ui-radio-pills">
                @foreach($controller->modalFieldOptions($field) as $option)
                    @php
                        $optionId = $fieldId . '-' . preg_replace('/[^a-z0-9_-]/i', '-', $option['value']);
                    @endphp
                    <label for="{{ $optionId }}" @class(['is-active' => (string) $value === (string) $option['value']])>
                        <input id="{{ $optionId }}" type="radio" value="{{ $option['value'] }}" wire:model.live="{{ $model }}">
                        @if($option['icon'] ?? null)
                            <x-evo::icon :name="$option['icon']" />
                        @endif
                        <span>{{ $option['label'] }}</span>
                    </label>
                @endforeach
            </div>
        @elseif($type === 'checkbox')
            <span class="evo-ui-checkbox">
                <input id="{{ $fieldId }}" type="checkbox" wire:model.live="{{ $model }}">
            </span>
        @elseif($type === 'select')
            <select id="{{ $fieldId }}" class="evo-ui-input" wire:model.live="{{ $model }}">
                @foreach($controller->modalFieldOptions($field) as $option)
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
            </select>
        @elseif($type === 'multi-select')
            @php
                $selectedValues = array_map('strval', (array) $value);
            @endphp
            <select id="{{ $fieldId }}" class="evo-ui-input evo-ui-select--multiple" wire:model.live="{{ $model }}" multiple size="{{ (int) ($field['size'] ?? 6) }}">
                @foreach($controller->modalFieldOptions($field) as $option)
                    <option value="{{ $option['value'] }}" @if(in_array((string) $option['value'], $selectedValues, true)) selected @endif>{{ $option['label'] }}</option>
                @endforeach
            </select>
        @elseif($type === 'choices')
            @php
                $multiple = ($field['multiple'] ?? true) !== false;
                $searchable = ($field['searchable'] ?? true) !== false;
                $clearable = ($field['clearable'] ?? true) !== false;
                $selectedValues = $multiple ? array_map('strval', (array) $value) : array_filter([(string) $value], fn ($item) => $item !== '');
                $options = collect($controller->modalFieldOptions($field));
                $selectedOptions = $options
                    ->filter(fn ($option) => in_array((string) $option['value'], $selectedValues, true))
                    ->values();
                $placeholder = __((string) ($field['placeholder'] ?? 'evo::global.search_placeholder'));
                $searchPlaceholder = __((string) ($field['search_label'] ?? $field['placeholder'] ?? 'evo::global.search_placeholder'));
            @endphp
            <div
                class="evo-ui-choices"
                x-data="{
                    open: false,
                    search: '',
                    placement: 'down',
                    maxHeight: '260px',
                    openDropdown() {
                        this.open = true;
                        this.$nextTick(() => {
                            this.placeDropdown();
                            this.$refs.search?.focus();
                        });
                    },
                    toggle() {
                        if (this.open) {
                            this.close();
                            return;
                        }
                        this.openDropdown();
                    },
                    close() {
                        this.open = false;
                    },
                    placeDropdown() {
                        const control = this.$refs.control;
                        if (!control) {
                            return;
                        }

                        const modalBody = this.$el.closest('.evo-ui-modal__body');
                        const modal = this.$el.closest('.evo-ui-modal');
                        const footer = modal?.querySelector('.evo-ui-modal__footer');
                        const controlRect = control.getBoundingClientRect();
                        const bodyRect = modalBody?.getBoundingClientRect() || modal?.getBoundingClientRect() || document.documentElement.getBoundingClientRect();
                        const footerTop = footer?.getBoundingClientRect().top || bodyRect.bottom;
                        const lowerLimit = Math.min(bodyRect.bottom, footerTop, window.innerHeight - 8);
                        const upperLimit = Math.max(bodyRect.top, 8);
                        const downSpace = Math.max(0, lowerLimit - controlRect.bottom - 4);
                        const upSpace = Math.max(0, controlRect.top - upperLimit - 4);
                        const opensUp = downSpace < 150 && upSpace > downSpace;
                        const available = opensUp ? upSpace : downSpace;

                        this.placement = opensUp ? 'up' : 'down';
                        this.maxHeight = Math.max(96, Math.min(260, available || 260)) + 'px';
                    },
                }"
                x-on:click.outside="close()"
                x-on:pointerdown.outside="close()"
                x-on:keydown.escape.window="close()"
                x-on:resize.window="open && placeDropdown()"
                x-on:scroll.window.passive="open && placeDropdown()"
                x-init="$nextTick(() => { const body = $el.closest('.evo-ui-modal__body'); body?.addEventListener('scroll', () => open && placeDropdown(), { passive: true }); })"
                x-bind:class="{ 'evo-ui-choices--open-up': placement === 'up' }"
                wire:key="modal-choices-{{ $controller->preset }}-{{ $name }}-{{ $controller->modalRecordId ?? 'new' }}"
            >
                <div
                    x-ref="control"
                    class="evo-ui-choices__control"
                    role="combobox"
                    tabindex="0"
                    aria-expanded="false"
                    x-on:click="toggle()"
                    x-on:keydown.enter.prevent="toggle()"
                    x-on:keydown.space.prevent="toggle()"
                    x-bind:aria-expanded="open ? 'true' : 'false'"
                >
                    <span class="evo-ui-choices__chips">
                        @forelse($selectedOptions as $option)
                            <span class="evo-ui-choices__chip" wire:key="modal-choice-{{ $controller->preset }}-{{ $name }}-{{ $option['value'] }}">
                                <span>{{ $option['label'] }}</span>
                                @if($clearable)
                                    <span
                                        role="button"
                                        tabindex="0"
                                        class="evo-ui-choices__remove"
                                        title="@lang('global.remove')"
                                        aria-label="@lang('global.remove')"
                                        wire:click.stop="removeModalChoice(@js($name), @js((string) $option['value']))"
                                        x-on:click.stop
                                    >
                                        <x-evo::icon name="x" />
                                    </span>
                                @endif
                            </span>
                        @empty
                            <span class="evo-ui-choices__placeholder">{{ $placeholder }}</span>
                        @endforelse
                    </span>
                </div>

                <div
                    x-ref="dropdown"
                    class="evo-ui-choices__dropdown"
                    x-show="open"
                    x-bind:style="{ maxHeight: maxHeight }"
                    x-cloak
                >
                    @if($searchable)
                        <input
                            x-ref="search"
                            type="search"
                            class="evo-ui-input evo-ui-choices__search"
                            x-model.debounce.150ms="search"
                            x-on:click.stop
                            x-on:input="$nextTick(() => placeDropdown())"
                            x-on:keydown.escape.prevent="open = false"
                            autocomplete="off"
                            placeholder="{{ $searchPlaceholder }}"
                            aria-label="{{ $searchPlaceholder }}"
                        >
                    @endif

                    @foreach($options as $option)
                        @php
                            $optionValue = (string) $option['value'];
                            $isSelected = in_array($optionValue, $selectedValues, true);
                            $searchLabel = mb_strtolower((string) $option['label']);
                        @endphp
                        <button
                            type="button"
                            @class(['evo-ui-choices__option', 'is-selected' => $isSelected])
                            @if($searchable)
                                x-show="search.trim() === '' || @js($searchLabel).includes(search.toLowerCase())"
                            @endif
                            x-on:click.stop.prevent="$wire.toggleModalChoice(@js($name), @js($optionValue), {{ $multiple ? 'false' : 'true' }}, {{ $clearable ? 'true' : 'false' }}); open = true"
                        >
                            <span>{{ $option['label'] }}</span>
                            @if($isSelected)
                                <x-evo::icon name="check" />
                            @endif
                        </button>
                    @endforeach
                </div>
            </div>
        @elseif($type === 'builder')
            @php
                $items = array_values((array) data_get($controller->modalData, $name, []));
                $blocks = collect($controller->modalBuilderBlocks($field));
                $blockMap = $blocks->keyBy('type');
                $addLabel = __((string) ($field['add_label'] ?? 'sArticles::global.add_block'));
            @endphp
            <div
                class="evo-ui-builder"
                x-data
                x-on:evo-ui:builder.block-added.window="
                    if ($event.detail?.preset !== @js($controller->preset) || $event.detail?.field !== @js($name)) {
                        return;
                    }

                    $nextTick(() => {
                        const row = $el.querySelector('[data-evo-builder-index=\'' + $event.detail.index + '\']');
                        row?.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    });
                "
            >
                <div class="evo-ui-builder__rows">
                    @forelse($items as $index => $item)
                        @php
                            $blockType = (string) data_get($item, 'type', '');
                            $block = $blockMap->get($blockType, []);
                            $blockLabel = (string) ($block['label'] ?? $blockType);
                            $blockFields = collect((array) ($block['fields'] ?? []))
                                ->filter(fn ($blockField) => is_array($blockField) && !empty($blockField['name']))
                                ->values();
                        @endphp
                        <section class="evo-ui-builder__row" data-evo-builder-index="{{ $index }}" wire:key="modal-builder-{{ $controller->preset }}-{{ $name }}-{{ $controller->modalRecordId ?? 'new' }}-{{ $index }}-{{ $blockType }}">
                            <header class="evo-ui-builder__header">
                                <div class="evo-ui-builder__title">
                                    <span class="evo-ui-badge">{{ $index + 1 }}</span>
                                    @if(!empty($block['icon']))
                                        <x-evo::icon :name="$block['icon']" />
                                    @endif
                                    <span>{{ $blockLabel }}</span>
                                </div>

                                <div class="evo-ui-builder__actions">
                                    <div class="evo-ui-row-actions">
                                        <button type="button" class="evo-ui-row-action" wire:click="moveModalBuilderBlock('{{ $name }}', {{ $index }}, 'up')" title="@lang('evo::global.previous')" aria-label="@lang('evo::global.previous')">
                                            <x-evo::icon name="chevron-up" />
                                        </button>
                                        <button type="button" class="evo-ui-row-action" wire:click="moveModalBuilderBlock('{{ $name }}', {{ $index }}, 'down')" title="@lang('evo::global.next')" aria-label="@lang('evo::global.next')">
                                            <x-evo::icon name="chevron-down" />
                                        </button>
                                    </div>
                                    <div class="evo-ui-builder__insert" x-data="{ open: false }" x-on:click.outside="open = false" x-on:keydown.escape.window="open = false">
                                        <div class="evo-ui-row-actions">
                                            <button type="button" class="evo-ui-row-action evo-ui-row-action--success" title="{{ $addLabel }}" aria-label="{{ $addLabel }}" x-on:click.stop.prevent="open = !open">
                                                <x-evo::icon name="plus" />
                                            </button>
                                        </div>
                                        <div class="evo-ui-builder__insert-menu" x-show="open" x-cloak>
                                            @foreach($blocks as $insertBlock)
                                                <button
                                                    type="button"
                                                    class="evo-ui-builder__insert-option"
                                                    wire:click="addModalBuilderBlock(@js($name), @js($insertBlock['type']), {{ $index }})"
                                                    x-on:click="open = false"
                                                >
                                                    <x-evo::icon :name="$insertBlock['icon']" />
                                                    <span>{{ $insertBlock['label'] }}</span>
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="evo-ui-row-actions">
                                        <button type="button" class="evo-ui-row-action evo-ui-row-action--danger" title="@lang('global.remove')" aria-label="@lang('global.remove')" wire:click="removeModalBuilderBlock('{{ $name }}', {{ $index }})">
                                            <x-evo::icon name="trash" />
                                        </button>
                                    </div>
                                </div>
                            </header>

                            <div class="evo-ui-builder__content">

                                <div class="evo-ui-builder__fields">
                                    @foreach($blockFields as $blockField)
                                        @php
                                            $blockFieldName = (string) $blockField['name'];
                                            $blockFieldType = (string) ($blockField['type'] ?? 'text');
                                            $blockFieldLabel = __((string) ($blockField['label'] ?? $blockFieldName));
                                            $blockFieldPlaceholder = !empty($blockField['placeholder']) ? __((string) $blockField['placeholder']) : $blockFieldLabel;
                                            $blockFieldHelp = !empty($blockField['help']) ? __((string) $blockField['help']) : '';
                                            $blockFieldModel = 'modalData.' . $name . '.' . $index . '.data.' . $blockFieldName;
                                            $blockFieldValue = data_get($item, 'data.' . $blockFieldName, '');
                                            $blockFieldId = $fieldId . '-' . $index . '-' . preg_replace('/[^a-z0-9_-]/i', '-', $blockType . '-' . $blockFieldName);
                                            $blockFieldError = 'modalData.' . $name . '.' . $index . '.data.' . $blockFieldName;
                                            $blockFieldOptions = collect((array) ($blockField['options'] ?? []))
                                                ->map(fn ($option) => [
                                                    'value' => (string) ($option['value'] ?? ''),
                                                    'label' => __((string) ($option['label'] ?? $option['value'] ?? '')),
                                                ])
                                                ->filter(fn ($option) => $option['value'] !== '')
                                                ->values();
                                        @endphp
                                        @if($blockFieldType === 'items')
                                            <div @class([
                                                'evo-ui-builder__field',
                                                'evo-ui-builder__field--full' => true,
                                                'evo-ui-builder__field--items' => true,
                                            ])>
                                        @else
                                            <label @class([
                                                'evo-ui-builder__field',
                                                'evo-ui-builder__field--full' => ($blockField['span'] ?? '') === 'full',
                                                'evo-ui-builder__field--image' => $blockFieldType === 'image',
                                            ]) for="{{ $blockFieldId }}">
                                        @endif
                                            @if($blockFieldType !== 'items')
                                                <span class="evo-ui-builder__label">
                                                    <span>{{ $blockFieldLabel }}</span>
                                                    @if($blockFieldHelp !== '')
                                                            <span class="evo-ui-field__help" aria-label="{{ $blockFieldHelp }}" data-tooltip="{{ $blockFieldHelp }}" data-evo-tooltip="{{ $blockFieldHelp }}" tabindex="0">?</span>
                                                    @endif
                                                </span>
                                            @endif

                                            @if($blockFieldType === 'items')
                                                @php
                                                    $nestedItems = array_values((array) $blockFieldValue);
                                                    $nestedFields = collect((array) ($blockField['fields'] ?? []))
                                                        ->filter(fn ($nestedField) => is_array($nestedField) && !empty($nestedField['name']))
                                                        ->values();
                                                    $nestedAddLabel = __((string) ($blockField['add_label'] ?? 'global.add'));
                                                    $nestedItemLabel = __((string) ($blockField['item_label'] ?? $blockFieldLabel));
                                                    if ($nestedItems === []) {
                                                        $nestedItems = [(array) ($blockField['defaults'] ?? [])];
                                                    }
                                                    $canRemoveNestedItem = count($nestedItems) > 1;
                                                @endphp
                                                <div class="evo-ui-builder-nested">
                                                    <div class="evo-ui-builder-nested__rows">
                                                        @foreach($nestedItems as $nestedIndex => $nestedItem)
                                                            <section class="evo-ui-builder-nested__row" wire:key="modal-builder-nested-{{ $controller->preset }}-{{ $name }}-{{ $index }}-{{ $blockFieldName }}-{{ $nestedIndex }}">
                                                                <header class="evo-ui-builder-nested__header">
                                                                    <div class="evo-ui-builder-nested__title">
                                                                        <span class="evo-ui-badge">{{ $nestedIndex + 1 }}</span>
                                                                        <span>{{ $nestedItemLabel }}</span>
                                                                    </div>
                                                                    <div class="evo-ui-row-actions evo-ui-builder-nested__actions">
                                                                        <button type="button" class="evo-ui-row-action" wire:click="moveModalBuilderItem(@js($name), {{ $index }}, @js($blockFieldName), {{ $nestedIndex }}, 'up')" title="@lang('evo::global.previous')" aria-label="@lang('evo::global.previous')">
                                                                            <x-evo::icon name="chevron-up" />
                                                                        </button>
                                                                        <button type="button" class="evo-ui-row-action" wire:click="moveModalBuilderItem(@js($name), {{ $index }}, @js($blockFieldName), {{ $nestedIndex }}, 'down')" title="@lang('evo::global.next')" aria-label="@lang('evo::global.next')">
                                                                            <x-evo::icon name="chevron-down" />
                                                                        </button>
                                                                        <button type="button" class="evo-ui-row-action evo-ui-row-action--success" wire:click="addModalBuilderItem(@js($name), {{ $index }}, @js($blockFieldName), {{ $nestedIndex }})" title="{{ $nestedAddLabel }}" aria-label="{{ $nestedAddLabel }}">
                                                                            <x-evo::icon name="plus" />
                                                                        </button>
                                                                        <button
                                                                            type="button"
                                                                            @class([
                                                                                'evo-ui-row-action',
                                                                                'evo-ui-row-action--danger',
                                                                                'is-disabled' => !$canRemoveNestedItem,
                                                                            ])
                                                                            wire:click="removeModalBuilderItem(@js($name), {{ $index }}, @js($blockFieldName), {{ $nestedIndex }})"
                                                                            title="@lang('global.remove')"
                                                                            aria-label="@lang('global.remove')"
                                                                            @disabled(!$canRemoveNestedItem)
                                                                        >
                                                                            <x-evo::icon name="trash" />
                                                                        </button>
                                                                    </div>
                                                                </header>

                                                                <div class="evo-ui-builder-nested__fields">
                                                                    @foreach($nestedFields as $nestedField)
                                                                        @php
                                                                            $nestedName = (string) $nestedField['name'];
                                                                            $nestedType = (string) ($nestedField['type'] ?? 'text');
                                                                            $nestedLabel = __((string) ($nestedField['label'] ?? $nestedName));
                                                                            $nestedPlaceholder = !empty($nestedField['placeholder']) ? __((string) $nestedField['placeholder']) : $nestedLabel;
                                                                            $nestedHelp = !empty($nestedField['help']) ? __((string) $nestedField['help']) : '';
                                                                            $nestedModel = 'modalData.' . $name . '.' . $index . '.data.' . $blockFieldName . '.' . $nestedIndex . '.' . $nestedName;
                                                                            $nestedValue = data_get($nestedItem, $nestedName, '');
                                                                            $nestedId = $blockFieldId . '-' . $nestedIndex . '-' . preg_replace('/[^a-z0-9_-]/i', '-', $nestedName);
                                                                            $nestedError = 'modalData.' . $name . '.' . $index . '.data.' . $blockFieldName . '.' . $nestedIndex . '.' . $nestedName;
                                                                            $nestedOptions = collect((array) ($nestedField['options'] ?? []))
                                                                                ->map(fn ($option) => [
                                                                                    'value' => (string) ($option['value'] ?? ''),
                                                                                    'label' => __((string) ($option['label'] ?? $option['value'] ?? '')),
                                                                                ])
                                                                                ->filter(fn ($option) => $option['value'] !== '')
                                                                                ->values();
                                                                        @endphp
                                                                        <label @class([
                                                                            'evo-ui-builder__field',
                                                                            'evo-ui-builder__field--full' => ($nestedField['span'] ?? '') === 'full',
                                                                            'evo-ui-builder__field--image' => $nestedType === 'image',
                                                                        ]) for="{{ $nestedId }}">
                                                                            <span class="evo-ui-builder__label">
                                                                                <span>{{ $nestedLabel }}</span>
                                                                                @if($nestedHelp !== '')
                                                                            <span class="evo-ui-field__help" aria-label="{{ $nestedHelp }}" data-tooltip="{{ $nestedHelp }}" data-evo-tooltip="{{ $nestedHelp }}" tabindex="0">?</span>
                                                                                @endif
                                                                            </span>

                                                                            @if($nestedType === 'textarea')
                                                                                <textarea id="{{ $nestedId }}" class="evo-ui-textarea" rows="{{ (int) ($nestedField['rows'] ?? 3) }}" wire:model.blur="{{ $nestedModel }}" placeholder="{{ $nestedPlaceholder }}"></textarea>
                                                                            @elseif($nestedType === 'editor')
                                                                                @php
                                                                                    $nestedEditorOptions = $controller->modalEditorOptions($nestedField);
                                                                                    $nestedActiveEditor = $controller->modalEditorValue($nestedField, $nestedId);
                                                                                @endphp
                                                                                <div class="evo-ui-editor-field-shell">
                                                                                    @if(count($nestedEditorOptions) > 1)
                                                                                        <div class="evo-ui-editor-field__switcher">
                                                                                            <select class="evo-ui-editor-field__select" wire:change='selectModalEditor(@js($nestedId), $event.target.value)' aria-label="Editor">
                                                                                                @foreach($nestedEditorOptions as $editorOption)
                                                                                                    <option value="{{ $editorOption['value'] }}" @selected($nestedActiveEditor === $editorOption['value'])>{{ $editorOption['label'] }}</option>
                                                                                                @endforeach
                                                                                            </select>
                                                                                        </div>
                                                                                    @endif
                                                                                    <div
                                                                                        class="evo-ui-editor-field"
                                                                                        wire:ignore
                                                                                        wire:key="editor-{{ $controller->preset }}-{{ $name }}-{{ $index }}-{{ $blockFieldName }}-{{ $nestedIndex }}-{{ $nestedName }}-{{ $nestedActiveEditor }}"
                                                                                        x-init="$nextTick(() => EvoUI.initRichEditorField($el))"
                                                                                    >
                                                                                        <textarea
                                                                                            id="{{ $nestedId }}"
                                                                                            class="evo-ui-textarea evo-ui-textarea--editor"
                                                                                            rows="{{ (int) ($nestedField['rows'] ?? 6) }}"
                                                                                            data-evo-rich-editor
                                                                                            data-evo-rich-editor-model="{{ $nestedModel }}"
                                                                                        >{{ $nestedValue }}</textarea>
                                                                                        {!! $controller->modalEditorHtml($nestedField, $nestedId) !!}
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($nestedType === 'image' || $nestedType === 'file')
                                                                                @php
                                                                                    $nestedBrowseType = $nestedType === 'file' ? 'files' : 'images';
                                                                                    $nestedBrowseIcon = $nestedType === 'file' ? 'folder-open' : 'image';
                                                                                @endphp
                                                                                <div @class([
                                                                                    'evo-ui-image-field',
                                                                                    'evo-ui-image-field--no-preview' => $nestedType === 'file',
                                                                                    'evo-ui-builder__media',
                                                                                ])>
                                                                                    @if($nestedType === 'image')
                                                                                        @php
                                                                                            $nestedPreview = $controller->modalImageUrl((string) $nestedValue);
                                                                                        @endphp
                                                                                        <button type="button" class="evo-ui-image-field__preview" title="{{ $nestedLabel }}" aria-label="{{ $nestedLabel }}" x-on:click.prevent="EvoUI.browseMediaField('{{ $nestedId }}', 'images')">
                                                                                            @if($nestedPreview !== '')
                                                                                                <img src="{{ $nestedPreview }}" alt="{{ $nestedLabel }}" loading="lazy" decoding="async">
                                                                                            @else
                                                                                                <x-evo::icon name="image" />
                                                                                            @endif
                                                                                        </button>
                                                                                    @endif
                                                                                    <div class="evo-ui-image-field__control">
                                                                                        <input id="{{ $nestedId }}" type="text" class="evo-ui-input" wire:model.live.debounce.250ms="{{ $nestedModel }}" autocomplete="off" placeholder="{{ $nestedPlaceholder }}">
                                                                                        <button type="button" class="evo-ui-btn evo-ui-btn--icon" title="@lang('evo::global.action_browse')" aria-label="@lang('evo::global.action_browse')" x-on:click.prevent="EvoUI.browseMediaField('{{ $nestedId }}', '{{ $nestedBrowseType }}')">
                                                                                            <x-evo::icon :name="$nestedBrowseIcon" class="evo-ui-btn__icon" />
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($nestedType === 'select')
                                                                                <select id="{{ $nestedId }}" class="evo-ui-input" wire:model.live="{{ $nestedModel }}">
                                                                                    @foreach($nestedOptions as $option)
                                                                                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            @else
                                                                                @php
                                                                                    $nestedInputType = in_array($nestedType, ['number', 'date', 'datetime-local'], true) ? $nestedType : 'text';
                                                                                @endphp
                                                                                <input id="{{ $nestedId }}" type="{{ $nestedInputType }}" class="evo-ui-input" wire:model.blur="{{ $nestedModel }}" autocomplete="off" placeholder="{{ $nestedPlaceholder }}" @if($nestedInputType === 'number') min="{{ (int) ($nestedField['min'] ?? 0) }}" @endif>
                                                                            @endif

                                                                            @if($errors->has($nestedError))
                                                                                <span class="evo-ui-field__error">{{ $errors->first($nestedError) }}</span>
                                                                            @endif
                                                                        </label>
                                                                    @endforeach
                                                                </div>
                                                            </section>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @elseif($blockFieldType === 'textarea')
                                                <textarea id="{{ $blockFieldId }}" class="evo-ui-textarea" rows="{{ (int) ($blockField['rows'] ?? 3) }}" wire:model.blur="{{ $blockFieldModel }}" placeholder="{{ $blockFieldPlaceholder }}"></textarea>
                                            @elseif($blockFieldType === 'editor')
                                                @php
                                                    $blockEditorOptions = $controller->modalEditorOptions($blockField);
                                                    $blockActiveEditor = $controller->modalEditorValue($blockField, $blockFieldId);
                                                @endphp
                                                <div class="evo-ui-editor-field-shell">
                                                    @if(count($blockEditorOptions) > 1)
                                                        <div class="evo-ui-editor-field__switcher">
                                                            <select class="evo-ui-editor-field__select" wire:change='selectModalEditor(@js($blockFieldId), $event.target.value)' aria-label="Editor">
                                                                @foreach($blockEditorOptions as $editorOption)
                                                                    <option value="{{ $editorOption['value'] }}" @selected($blockActiveEditor === $editorOption['value'])>{{ $editorOption['label'] }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    @endif
                                                    <div
                                                        class="evo-ui-editor-field"
                                                        wire:ignore
                                                        wire:key="editor-{{ $controller->preset }}-{{ $name }}-{{ $index }}-{{ $blockType }}-{{ $blockFieldName }}-{{ $blockActiveEditor }}"
                                                        x-init="$nextTick(() => EvoUI.initRichEditorField($el))"
                                                    >
                                                        <textarea
                                                            id="{{ $blockFieldId }}"
                                                            class="evo-ui-textarea evo-ui-textarea--editor"
                                                            rows="{{ (int) ($blockField['rows'] ?? 8) }}"
                                                            data-evo-rich-editor
                                                            data-evo-rich-editor-model="{{ $blockFieldModel }}"
                                                        >{{ $blockFieldValue }}</textarea>
                                                        {!! $controller->modalEditorHtml($blockField, $blockFieldId) !!}
                                                    </div>
                                                </div>
                                            @elseif($blockFieldType === 'image' || $blockFieldType === 'file')
                                                @php
                                                    $browseType = $blockFieldType === 'file' ? 'files' : 'images';
                                                    $browseIcon = $blockFieldType === 'file' ? 'folder-open' : 'image';
                                                @endphp
                                                <div @class([
                                                    'evo-ui-image-field',
                                                    'evo-ui-image-field--no-preview' => $blockFieldType === 'file',
                                                    'evo-ui-builder__media',
                                                ])>
                                                    @if($blockFieldType === 'image')
                                                        @php
                                                            $blockPreview = $controller->modalImageUrl((string) $blockFieldValue);
                                                        @endphp
                                                        <button type="button" class="evo-ui-image-field__preview" title="{{ $blockFieldLabel }}" aria-label="{{ $blockFieldLabel }}" x-on:click.prevent="EvoUI.browseMediaField('{{ $blockFieldId }}', 'images')">
                                                            @if($blockPreview !== '')
                                                                <img src="{{ $blockPreview }}" alt="{{ $blockFieldLabel }}" loading="lazy" decoding="async">
                                                            @else
                                                                <x-evo::icon name="image" />
                                                            @endif
                                                        </button>
                                                    @endif

                                                    <div class="evo-ui-image-field__control">
                                                        <input id="{{ $blockFieldId }}" type="text" class="evo-ui-input" wire:model.live.debounce.250ms="{{ $blockFieldModel }}" autocomplete="off" placeholder="{{ $blockFieldPlaceholder }}">
                                                        <button type="button" class="evo-ui-btn evo-ui-btn--icon" title="@lang('evo::global.action_browse')" aria-label="@lang('evo::global.action_browse')" x-on:click.prevent="EvoUI.browseMediaField('{{ $blockFieldId }}', '{{ $browseType }}')">
                                                            <x-evo::icon :name="$browseIcon" class="evo-ui-btn__icon" />
                                                        </button>
                                                    </div>
                                                </div>
                                            @elseif($blockFieldType === 'select')
                                                <select id="{{ $blockFieldId }}" class="evo-ui-input" wire:model.live="{{ $blockFieldModel }}">
                                                    @foreach($blockFieldOptions as $option)
                                                        <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                @php
                                                    $blockInputType = in_array($blockFieldType, ['number', 'date', 'datetime-local'], true) ? $blockFieldType : 'text';
                                                @endphp
                                                <input id="{{ $blockFieldId }}" type="{{ $blockInputType }}" class="evo-ui-input" wire:model.blur="{{ $blockFieldModel }}" autocomplete="off" placeholder="{{ $blockFieldPlaceholder }}" @if($blockInputType === 'number') min="{{ (int) ($blockField['min'] ?? 0) }}" @endif>
                                            @endif

                                            @if($errors->has($blockFieldError))
                                                <span class="evo-ui-field__error">{{ $errors->first($blockFieldError) }}</span>
                                            @endif
                                        @if($blockFieldType === 'items')
                                            </div>
                                        @else
                                            </label>
                                        @endif
                                    @endforeach
                                </div>
                            </div>

                        </section>
                    @empty
                        <div class="evo-ui-empty">-</div>
                    @endforelse
                </div>

                <div class="evo-ui-builder__toolbar" aria-label="{{ $addLabel }}">
                    <span>{{ $addLabel }}</span>
                    <div class="evo-ui-builder__buttons">
                        @foreach($blocks as $block)
                            <button
                                type="button"
                                class="evo-ui-btn evo-ui-btn--icon"
                                title="{{ $block['label'] }}"
                                aria-label="{{ $block['label'] }}"
                                wire:click="addModalBuilderBlock(@js($name), @js($block['type']))"
                            >
                                <x-evo::icon :name="$block['icon']" class="evo-ui-btn__icon" />
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>
        @elseif(in_array($type, ['color', 'color-picker'], true))
            @php
                $rawColor = (string) $value;
                $hexColor = preg_match('/^#[0-9a-f]{6}$/i', $rawColor) ? strtoupper($rawColor) : $colorFallback;
            @endphp
            <span class="evo-ui-color-field">
                <input
                    id="{{ $fieldId }}"
                    class="evo-ui-color-field__picker"
                    type="color"
                    value="{{ $hexColor }}"
                    wire:model.live="{{ $model }}"
                    aria-label="{{ $label }}"
                >
                <input
                    class="evo-ui-input evo-ui-color-field__input"
                    type="text"
                    value="{{ $rawColor !== '' ? $rawColor : $hexColor }}"
                    wire:model.blur="{{ $model }}"
                    maxlength="7"
                    pattern="#[0-9A-Fa-f]{6}"
                    placeholder="#64748B"
                    autocomplete="off"
                >
                <span class="evo-ui-color-field__swatch" style="--evo-ui-color-field-value: {{ $hexColor }};" aria-hidden="true"></span>
            </span>
        @elseif($type === 'textarea')
            <textarea id="{{ $fieldId }}" class="evo-ui-textarea" rows="{{ (int) ($field['rows'] ?? 4) }}" wire:model.blur="{{ $model }}" placeholder="{{ $placeholder }}"></textarea>
        @elseif($type === 'editor')
            @php
                $editorOptions = $controller->modalEditorOptions($field);
                $activeEditor = $controller->modalEditorValue($field, $fieldId);
            @endphp
            <div class="evo-ui-editor-field-shell">
                @if(count($editorOptions) > 1)
                    <div class="evo-ui-editor-field__switcher">
                        <select class="evo-ui-editor-field__select" wire:change='selectModalEditor(@js($fieldId), $event.target.value)' aria-label="Editor">
                            @foreach($editorOptions as $editorOption)
                                <option value="{{ $editorOption['value'] }}" @selected($activeEditor === $editorOption['value'])>{{ $editorOption['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
                <div
                    class="evo-ui-editor-field"
                    wire:ignore
                    wire:key="editor-{{ $controller->preset }}-{{ $name }}-{{ $controller->modalRecordId ?? 'new' }}-{{ $activeEditor }}"
                    x-init="$nextTick(() => EvoUI.initRichEditorField($el))"
                >
                    <textarea
                        id="{{ $fieldId }}"
                        class="evo-ui-textarea evo-ui-textarea--editor"
                        rows="{{ (int) ($field['rows'] ?? 12) }}"
                        data-evo-rich-editor
                        data-evo-rich-editor-model="{{ $model }}"
                    >{{ $value }}</textarea>
                    {!! $controller->modalEditorHtml($field, $fieldId) !!}
                </div>
            </div>
        @elseif($type === 'alias')
            <input id="{{ $fieldId }}" type="text" class="evo-ui-input" wire:model.live.debounce.350ms="{{ $model }}" autocomplete="off" placeholder="{{ $placeholder }}">
        @else
            @php
                $inputType = in_array($type, ['email', 'number', 'date', 'datetime-local'], true) ? $type : 'text';
            @endphp
            @if(!empty($field['live']))
                <input id="{{ $fieldId }}" type="{{ $inputType }}" class="evo-ui-input" wire:model.live.debounce.350ms="{{ $model }}" autocomplete="off" placeholder="{{ $placeholder }}" @if($inputType === 'number') min="{{ (int) ($field['min'] ?? 0) }}" @endif>
            @else
                <input id="{{ $fieldId }}" type="{{ $inputType }}" class="evo-ui-input" wire:model.blur="{{ $model }}" autocomplete="off" placeholder="{{ $placeholder }}" @if($inputType === 'number') min="{{ (int) ($field['min'] ?? 0) }}" @endif>
            @endif
        @endif

        @if($hint !== '' && $type !== 'repeater')
            <span class="evo-ui-field__hint">{{ $hint }}</span>
        @endif

        @if($hasError)
            <span class="evo-ui-field__error">{{ $errors->first($errorKey) }}</span>
        @endif
    </div>
@endif
