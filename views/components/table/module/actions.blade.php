@props([
    'row',
    'actions' => [],
])

@php
    $resolve = function (mixed $value) use ($row) {
        if (is_string($value) && data_get($row, $value) !== null) {
            return data_get($row, $value);
        }

        return $value;
    };

    $stateValue = function (array $action, string $name, string $default = '') use ($row) {
        $field = $action[$name . '_field'] ?? null;

        if (!$field) {
            return $action[$name] ?? $default;
        }

        return data_get($row, $field)
            ? ($action[$name . '_true'] ?? $default)
            : ($action[$name . '_false'] ?? $default);
    };

    $attributesFor = function (array $action) use ($row, $resolve) {
        $attributes = [];

        foreach (($action['attributes'] ?? []) as $name => $value) {
            if ($value === true) {
                $attributes[$name] = $name;
                continue;
            }

            $attributes[$name] = $resolve($value);
        }

        return $attributes;
    };
@endphp

<td class="evo-ui-row-actions-cell" aria-label="@lang('evo::global.column_actions')">
    <div class="evo-ui-row-actions">
        @foreach($actions as $action)
            @php
                $type = $action['type'] ?? 'link';
                $icon = $stateValue($action, 'icon', $action['icon'] ?? 'circle');
                $tone = $stateValue($action, 'tone', $action['tone'] ?? 'neutral');
                $labelKey = $stateValue($action, 'label', $action['label'] ?? '');
                $label = $labelKey !== '' ? __($labelKey) : '';
                $buttonClass = trim('evo-ui-row-action ' .
                    (in_array($tone, ['primary', 'info', 'success', 'warning', 'danger'], true) ? 'evo-ui-row-action--' . $tone : ''));
                $extra = new \Illuminate\View\ComponentAttributeBag($attributesFor($action));
                $disabledField = $action['disabled_field'] ?? null;
                $disabled = $disabledField ? (bool) data_get($row, $disabledField) : (bool) ($action['disabled'] ?? false);
            @endphp

            @if($type === 'wire')
                @php
                    $method = $action['method'] ?? '';
                    $argument = (int) $resolve($action['argument'] ?? 'id');
                    $withActionKey = (bool) ($action['action_argument'] ?? false);
                @endphp
                <button
                    type="button"
                    class="{{ $buttonClass }}"
                    title="{{ $label }}"
                    aria-label="{{ $label }}"
                    @disabled($disabled)
                    @if($withActionKey)
                        wire:click.stop="{{ $method }}('{{ e((string) ($action['key'] ?? '')) }}', {{ $argument }})"
                    @else
                        wire:click.stop="{{ $method }}({{ $argument }})"
                    @endif
                >
                    <x-evo::icon :name="$icon" />
                    <span class="evo-ui-sr-only">{{ $label }}</span>
                </button>
            @elseif($type === 'placeholder')
                <button type="button" class="{{ $buttonClass }}" title="{{ $label }}" aria-label="{{ $label }}" disabled>
                    <x-evo::icon :name="$icon" />
                    <span class="evo-ui-sr-only">{{ $label }}</span>
                </button>
            @else
                @php($href = $type === 'delete' ? ($action['href'] ?? '#') : $resolve($action['href'] ?? '#'))
                <a href="{{ $href ?: '#' }}" class="{{ $buttonClass }}" title="{{ $label }}" aria-label="{{ $label }}" {{ $extra }} @click.stop>
                    <x-evo::icon :name="$icon" />
                    <span class="evo-ui-sr-only">{{ $label }}</span>
                </a>
            @endif
        @endforeach
    </div>
</td>
