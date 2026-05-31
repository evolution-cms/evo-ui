@props([
    'controller',
    'field',
])

@php
    $name = $field['name'];
    $type = $field['type'] ?? 'text';
    $model = 'data.' . $name;
    $label = __($field['label'] ?? $name);
    $showLabel = ($field['show_label'] ?? ($field['label_visible'] ?? true)) !== false && ($field['label'] ?? null) !== false;
    $error = ($errors ?? null)?->first($model) ?? '';
    $customView = $controller->customFieldView($field);
    $help = $field['help'] ?? $field['description'] ?? null;
    $helpText = $help ? __($help) : '';
    $hintText = !empty($field['hint']) ? __($field['hint']) : '';
    $numberRuleValue = static function (array $field, string $rule): ?string {
        foreach ($field['rules'] ?? [] as $item) {
            if (is_string($item) && str_starts_with($item, $rule . ':')) {
                return substr($item, strlen($rule) + 1);
            }
        }

        return null;
    };
    $numberMin = $field['min'] ?? $numberRuleValue($field, 'min');
    $numberMax = $field['max'] ?? $numberRuleValue($field, 'max');
    $numberStep = $field['step'] ?? ($type === 'number' ? 1 : null);
    $colorFallback = (string) ($field['default'] ?? '#64748B');
    $colorFallback = preg_match('/^#[0-9a-f]{6}$/i', $colorFallback) ? strtoupper($colorFallback) : '#64748B';
@endphp

@if($customView)
    @include($customView, ['controller' => $controller, 'field' => $field, 'model' => $model, 'error' => $error])
@else
    <label @class([
        'evo-ui-field',
        'evo-ui-field--full' => ($field['span'] ?? null) === 'full',
        'evo-ui-field--compact' => ($field['size'] ?? null) === 'compact',
        'evo-ui-field--no-label' => !$showLabel,
        'has-error' => $error,
    ])>
        <span class="{{ $showLabel ? 'evo-ui-field__label' : 'evo-ui-sr-only' }}">
            <span>
                <span>{{ $label }}</span>
                @if(!empty($field['config_key']))
                    <code>{{ $field['config_key'] }}</code>
                @endif
            </span>
            @if($helpText)
                <span
                    class="evo-ui-field__help"
                    title="{{ $helpText }}"
                    aria-label="{{ $helpText }}"
                    data-tooltip="{{ $helpText }}"
                    data-evo-tooltip="{{ $helpText }}"
                    tabindex="0"
                >?</span>
            @endif
        </span>

        @if($type === 'textarea')
            <textarea
                @class(['evo-ui-input', 'evo-ui-textarea', 'evo-ui-textarea--code' => ($field['variant'] ?? null) === 'code'])
                rows="{{ $field['rows'] ?? 3 }}"
                wire:model.blur="{{ $model }}"
            ></textarea>
        @elseif(in_array($type, ['color', 'color-picker'], true))
            @php
                $rawColor = (string) data_get($controller->data, $name, '');
                $hexColor = preg_match('/^#[0-9a-f]{6}$/i', $rawColor) ? strtoupper($rawColor) : $colorFallback;
            @endphp
            <span class="evo-ui-color-field">
                <input
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
        @elseif($type === 'display')
            <span class="evo-ui-form-static">
                @if(!empty($field['icon']))
                    <x-evo::icon :name="$field['icon']" />
                @endif
                <span>{{ $controller->fieldDisplay($field) }}</span>
            </span>
        @elseif($type === 'resource-parent')
            <span
                class="evo-ui-resource-parent"
                data-evo-resource-parent="{{ $name }}"
                data-evo-record-id="{{ $controller->currentRecordId() }}"
            >
                <input
                    type="hidden"
                    name="{{ $name }}"
                    wire:model.live="{{ $model }}"
                    data-evo-resource-parent-input
                >
                <span
                    class="evo-ui-resource-parent__control"
                    role="button"
                    tabindex="0"
                    title="{{ __('evo::global.resource_parent_select') }}"
                    aria-label="{{ __('evo::global.resource_parent_select') }}"
                    data-evo-resource-parent-trigger
                >
                    <x-evo::icon :name="$field['icon'] ?? 'folder'" class="evo-ui-resource-parent__icon evo-ui-resource-parent__icon--closed" />
                    <x-evo::icon name="folder-open" class="evo-ui-resource-parent__icon evo-ui-resource-parent__icon--open" />
                    <b id="parentName" data-evo-resource-parent-label>{{ $controller->fieldDisplay($field) }}</b>
                </span>
            </span>
        @elseif($type === 'multi-checkbox')
            <span class="evo-ui-choice-list">
                @foreach($controller->fieldOptions($field) as $option)
                    <label>
                        <input type="checkbox" value="{{ $option['value'] }}" wire:model.live="{{ $model }}">
                        <span>{{ $option['label'] }}</span>
                    </label>
                @endforeach
            </span>
        @elseif($type === 'config-map')
            @php
                $keyField = (string) ($field['key_field'] ?? '_key');
                $itemFields = collect((array) ($field['fields'] ?? []))
                    ->filter(fn ($itemField) => is_array($itemField) && !empty($itemField['name']))
                    ->values()
                    ->all();
                $items = array_values((array) data_get($controller->data, $name, []));
                $addLabel = __($field['add_label'] ?? 'evo::global.action_add');
            @endphp
            <span class="evo-ui-config-map">
                <span class="evo-ui-config-map__toolbar">
                    <button type="button" class="evo-ui-btn evo-ui-btn--success" wire:click="addConfigMapItem('{{ $name }}')">
                        <x-evo::icon name="plus" class="evo-ui-btn__icon" />
                        <span class="evo-ui-btn__label">{{ $addLabel }}</span>
                    </button>
                </span>

                <span class="evo-ui-config-map__items">
                    @foreach($items as $index => $item)
                        @php
                            $itemKey = (string) data_get($item, $keyField, '');
                            $deleteBlocked = $controller->configMapDeleteBlocked($field, (array) $item, $index);
                            $usageCount = $controller->configMapUsageCount($field, (array) $item);
                            $titleField = (string) ($field['title_field'] ?? 'name');
                            $title = trim((string) data_get($item, $titleField, $itemKey));
                            $title = $title !== '' ? $title : $itemKey;
                        @endphp
                        <span class="evo-ui-config-map__item" wire:key="config-map-{{ $name }}-{{ $index }}-{{ $itemKey }}">
                            <span class="evo-ui-config-map__item-header">
                                <span>
                                    <b>{{ $title }}</b>
                                    <code>{{ $itemKey }}</code>
                                    @if($usageCount > 0)
                                        <small>{{ __('evo::global.records_count', ['count' => $usageCount]) }}</small>
                                    @endif
                                </span>
                                <button
                                    type="button"
                                    class="evo-ui-row-action evo-ui-row-action--danger {{ $deleteBlocked ? 'is-disabled' : '' }}"
                                    title="@lang('global.remove')"
                                    aria-label="@lang('global.remove')"
                                    @if($deleteBlocked) disabled @endif
                                    wire:click="removeConfigMapItem('{{ $name }}', {{ $index }})"
                                >
                                    <x-evo::icon name="trash" />
                                </button>
                            </span>

                            <span class="evo-ui-config-map__fields">
                                <label class="evo-ui-field evo-ui-field--compact">
                                    <span class="evo-ui-field__label">
                                        <span>{{ __($field['key_label'] ?? 'evo::global.key') }}</span>
                                    </span>
                                    <input
                                        class="evo-ui-input"
                                        type="text"
                                        wire:model.blur="data.{{ $name }}.{{ $index }}.{{ $keyField }}"
                                        @if($index === 0 && ($field['lock_first_key'] ?? false)) readonly @endif
                                    >
                                </label>

                                @foreach($itemFields as $itemField)
                                    @php
                                        $itemName = (string) $itemField['name'];
                                        $itemType = (string) ($itemField['type'] ?? 'text');
                                        $itemLabel = __($itemField['label'] ?? $itemName);
                                        $itemModel = 'data.' . $name . '.' . $index . '.' . $itemName;
                                    @endphp
                                    <label class="evo-ui-field {{ ($itemField['span'] ?? null) === 'full' ? 'evo-ui-field--full' : '' }}">
                                        <span class="evo-ui-field__label">
                                            <span>{{ $itemLabel }}</span>
                                        </span>

                                        @if($itemType === 'checkbox')
                                            <span class="evo-ui-checkbox">
                                                <input type="checkbox" wire:model.live="{{ $itemModel }}">
                                            </span>
                                        @elseif($itemType === 'multi-select')
                                            <select
                                                class="evo-ui-input evo-ui-select--multiple"
                                                wire:model.live="{{ $itemModel }}"
                                                multiple
                                                size="{{ (int) ($itemField['size'] ?? 5) }}"
                                            >
                                                @foreach($controller->fieldOptions($itemField) as $option)
                                                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                                                @endforeach
                                            </select>
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
                                        @elseif($itemType === 'number')
                                            <input class="evo-ui-input" type="number" wire:model.blur="{{ $itemModel }}" @if(isset($itemField['min'])) min="{{ $itemField['min'] }}" @endif>
                                        @elseif($itemType === 'textarea')
                                            <textarea class="evo-ui-input evo-ui-textarea" rows="{{ $itemField['rows'] ?? 3 }}" wire:model.blur="{{ $itemModel }}"></textarea>
                                        @else
                                            <input class="evo-ui-input" type="text" wire:model.blur="{{ $itemModel }}">
                                        @endif
                                    </label>
                                @endforeach
                            </span>
                        </span>
                    @endforeach
                </span>
            </span>
        @elseif($type === 'radio')
            <span class="evo-ui-choice-list evo-ui-choice-list--inline">
                @foreach($controller->fieldOptions($field) as $option)
                    <label>
                        <input type="radio" value="{{ $option['value'] }}" wire:model.live="{{ $model }}">
                        <span>{{ $option['label'] }}</span>
                    </label>
                @endforeach
            </span>
        @elseif($type === 'select')
            <select class="evo-ui-input" wire:model.live="{{ $model }}">
                @foreach($controller->fieldOptions($field) as $option)
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
            </select>
        @elseif($type === 'multi-select')
            <select class="evo-ui-input evo-ui-select--multiple" wire:model.live="{{ $model }}" multiple size="{{ (int) ($field['size'] ?? 6) }}">
                @foreach($controller->fieldOptions($field) as $option)
                    <option value="{{ $option['value'] }}">{{ $option['label'] }}</option>
                @endforeach
            </select>
        @elseif($type === 'checkbox')
            <span class="evo-ui-checkbox">
                <input type="checkbox" wire:model.live="{{ $model }}">
            </span>
        @else
            <input
                class="evo-ui-input"
                type="{{ match($type) { 'number' => 'number', 'date' => 'date', 'datetime' => 'datetime-local', default => 'text' } }}"
                wire:model.blur="{{ $model }}"
                @if($type === 'number' && $numberMin !== null) min="{{ $numberMin }}" @endif
                @if($type === 'number' && $numberMax !== null) max="{{ $numberMax }}" @endif
                @if($type === 'number' && $numberStep !== null) step="{{ $numberStep }}" @endif
            >
        @endif

        @if($hintText !== '')
            <span class="evo-ui-field__hint">
                @if(!empty($field['hint_html']))
                    {!! $hintText !!}
                @else
                    {{ $hintText }}
                @endif
            </span>
        @endif

        @if($error)
            <span class="evo-ui-field__error">{{ $error }}</span>
        @endif
    </label>
@endif
