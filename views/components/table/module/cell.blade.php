@props([
    'row',
    'column',
    'reorderEnabled' => false,
])

<?php
    $row = is_array($row ?? null) ? $row : [];
    $column = is_array($column ?? null) ? $column : [];
    $key = $column['key'] ?? '';
    $type = $column['type'] ?? 'text';
    $value = data_get($row, $column['value'] ?? $key);
    $isId = $key === 'id' || ($column['value'] ?? null) === 'id';
    $cellClass = trim((string) ($column['cell_class'] ?? '') . ' evo-ui-table-cell--' . $type);

    $toText = static function (mixed $displayValue): string {
        if (is_array($displayValue)) {
            $label = data_get($displayValue, 'label');

            if (is_scalar($label)) {
                return (string) $label;
            }

            return collect($displayValue)
                ->filter(fn ($item) => is_scalar($item))
                ->map(fn ($item) => (string) $item)
                ->implode(', ');
        }

        return is_scalar($displayValue) || $displayValue === null ? (string) $displayValue : '';
    };

    $textColor = is_array($value) ? (string) data_get($value, 'color', '') : '';
    $textStyle = preg_match('/^#[0-9a-f]{6}$/i', $textColor) ? 'color: ' . strtoupper($textColor) . ';' : '';
?>

<td class="{{ $cellClass }}" data-evo-column-key="{{ $key }}">
    <?php if (!empty($column['editable']) && $type === 'image'): ?>
        <x-evo::table.module.inline-image :row="$row" :column="$column" :display-value="$value" />
    <?php elseif (!empty($column['editable'])): ?>
        <x-evo::table.module.inline-edit :row="$row" :column="$column" :display-value="$value" />
    <?php elseif ($type === 'image'): ?>
        <?php $image = is_array($value) ? $value : ['src' => $value]; ?>
        <x-evo::table.image :image="$image" />
    <?php elseif ($type === 'link'): ?>
        <?php $link = is_array($value) ? $value : ['label' => $value]; ?>
        <?php if (!empty($link['href'])): ?>
            <a class="evo-ui-table-link" href="{{ $link['href'] }}" <?php if (!empty($link['target'])): ?> target="{{ $link['target'] }}"<?php endif; ?> @click.stop>
                <?php if (!empty($link['strong'])): ?>
                    <b>{{ $link['label'] ?? '' }}</b>
                <?php else: ?>
                    {{ $link['label'] ?? '' }}
                <?php endif; ?>
            </a>
        <?php else: ?>
            {{ $link['label'] ?? '' }}
        <?php endif; ?>
    <?php elseif ($type === 'chips'): ?>
        <?php $items = collect((array) $value)->filter()->values(); ?>
        <div class="evo-ui-meta-list">
            <?php if ($items->isNotEmpty()): ?>
                <?php foreach ($items as $item): ?>
                    <?php
                        $chipLabel = is_array($item) ? (string) ($item['label'] ?? '') : (string) $item;
                        $chipBadge = is_array($item) && array_key_exists('badge', $item) ? $item['badge'] : null;
                        $chipIcon = is_array($item) ? (string) ($item['icon'] ?? '') : '';
                        $chipColor = is_array($item) ? (string) ($item['color'] ?? '') : '';
                        $chipStyle = preg_match('/^#[0-9a-f]{6}$/i', $chipColor) ? '--evo-ui-meta-chip-color: ' . strtoupper($chipColor) . ';' : '';
                    ?>
                    <?php if ($chipLabel !== ''): ?>
                        <span class="evo-ui-meta-chip" <?php if ($chipStyle !== ''): ?>style="{{ $chipStyle }}"<?php endif; ?>>
                            <?php if ($chipIcon !== ''): ?>
                                <x-evo::icon :name="$chipIcon" />
                            <?php endif; ?>
                            <span>{{ $chipLabel }}</span>
                            <?php if ($chipBadge !== null): ?>
                                <span class="evo-ui-meta-chip__badge">{{ $chipBadge }}</span>
                            <?php endif; ?>
                        </span>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <span class="evo-ui-meta-empty">-</span>
            <?php endif; ?>
        </div>
    <?php elseif ($type === 'position'): ?>
        <?php $rowId = (int) data_get($row, 'id'); ?>
        <span class="evo-ui-position-control evo-ui-position-control--rail" title="{{ __($column['label'] ?? '') }}">
            <x-evo::reorder-rail
                class="evo-ui-reorder-rail--table"
                move-up="moveRow({{ $rowId }}, 'up')"
                move-down="moveRow({{ $rowId }}, 'down')"
                label="{{ __($column['label'] ?? '') }}"
            />
            <span class="evo-ui-sr-only">{{ $toText($value) }}</span>
        </span>
    <?php elseif ($isId): ?>
        <span class="evo-ui-id">{{ $toText($value) }}</span>
    <?php elseif ($type === 'badge'): ?>
        <x-evo::badge :value="$value" />
    <?php elseif ($type === 'icon'): ?>
        <?php
            $icon = is_array($value) ? (string) ($value['icon'] ?? 'circle') : (string) $value;
            $label = is_array($value) ? (string) ($value['label'] ?? '') : '';
            $tone = is_array($value) ? preg_replace('/[^a-z0-9_-]/i', '', (string) ($value['tone'] ?? '')) : '';
            $iconClass = trim('evo-ui-table-icon ' . ($tone !== '' ? 'evo-ui-table-icon--badge evo-ui-table-icon--' . $tone : ''));
        ?>
        <span class="{{ $iconClass }}" title="{{ $label }}" aria-label="{{ $label }}">
            <x-evo::icon :name="$icon" />
            <?php if ($label !== ''): ?>
                <span class="evo-ui-sr-only">{{ $label }}</span>
            <?php endif; ?>
        </span>
    <?php elseif ($type === 'markdown'): ?>
        <?php $textValue = $toText($value); ?>
        <?php if ($textValue !== ''): ?>
            <span>{!! \Illuminate\Support\Str::inlineMarkdown($textValue, ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</span>
        <?php endif; ?>
    <?php else: ?>
        <?php $textValue = $toText($value); ?>
        <?php if ($textValue !== ''): ?>
            <span <?php if ($textStyle !== ''): ?>style="{{ $textStyle }}"<?php endif; ?>>{{ $textValue }}</span>
        <?php endif; ?>
    <?php endif; ?>
</td>
