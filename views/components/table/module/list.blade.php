@props([
    'controller',
    'config',
    'rows' => [],
    'selectedId' => null,
])

<?php
    if (!($controller ?? null) instanceof \EvoUI\Livewire\ModuleTable) {
        throw new \RuntimeException('The module list component requires an EvoUI module table controller.');
    }

    $config = is_array($config ?? null) ? $config : [];
    $rows = is_array($rows ?? null) ? $rows : [];
    $selectedId = $selectedId ?? null;
    $columns = collect($config['columns'] ?? [])->keyBy('key');
    $list = $config['list'] ?? [];
    $titleKey = $list['title'] ?? 'title';
    $subtitleKey = array_key_exists('subtitle', $list) ? $list['subtitle'] : 'section';
    $imageKey = $list['image'] ?? 'cover';
    $showMedia = (bool) ($list['media'] ?? true);
    $compactList = (bool) ($list['compact'] ?? !$showMedia);
    $showLabels = (bool) ($list['labels'] ?? false);
    $titleColumn = $columns->get($titleKey);
    $subtitleColumn = $subtitleKey ? $columns->get($subtitleKey) : null;
    $imageColumn = $columns->get($imageKey);
    $mediaIcon = (string) ($list['icon'] ?? 'file-text');
    $metaColumns = collect($list['meta'] ?? [])
        ->map(fn ($key) => $columns->get($key))
        ->filter()
        ->values()
        ->all();
    $opensModal = !empty($config['modal']['enabled']) && (($config['modal']['row_dblclick'] ?? true) !== false);
    $modalDblclickAction = trim((string) data_get($config, 'modal.row_dblclick_action', ''));
    $reorderEnabled = $controller->reorderEnabled();
    $listAttributes = new \Illuminate\View\ComponentAttributeBag([
        'class' => 'evo-ui-list',
    ]);

    if ($reorderEnabled) {
        $listAttributes = $listAttributes->merge(['data-evo-dnd-list' => true]);
    }

    $resolveActionValue = static function (array $row, mixed $value): mixed {
        if (is_string($value) && data_get($row, $value) !== null) {
            return data_get($row, $value);
        }

        return $value;
    };
?>

<div {{ $listAttributes }}>
    <?php if (count($rows)): ?>
        <?php foreach ($rows as $row): ?>
            <?php
                $rowId = (int) data_get($row, 'id');
                $editUrl = (string) data_get($row, 'edit_url', '');
                $cover = data_get($row, $imageKey);
                $titleValue = $titleColumn ? data_get($row, $titleColumn['value'] ?? $titleColumn['key']) : data_get($row, $titleKey);
                $titleDisplayLabel = $titleColumn ? __($titleColumn['label'] ?? '') : '';
                $titleLabel = $titleColumn ? $controller->cellDisplay($row, $titleColumn) : (is_scalar($titleValue) ? (string) $titleValue : (string) $rowId);
                $titleLink = is_array($titleValue) ? $titleValue : ['label' => $titleLabel];
                $subtitleRawValue = $subtitleColumn ? data_get($row, $subtitleColumn['value'] ?? $subtitleColumn['key']) : ($subtitleKey ? data_get($row, $subtitleKey, '') : '');
                $subtitleDisplayLabel = $subtitleColumn ? __($subtitleColumn['label'] ?? '') : '';
                $subtitleValue = $subtitleColumn ? $controller->cellDisplay($row, $subtitleColumn) : ($subtitleKey ? data_get($row, $subtitleKey, '') : '');
                $subtitle = is_scalar($subtitleValue) ? (string) $subtitleValue : '';
                $isSelected = $selectedId === $rowId;
                $stateClasses = $controller->rowStateClasses($row);
                $itemClass = trim('evo-ui-list-item ' .
                    ($compactList ? 'evo-ui-list-item--compact ' : '') .
                    (!$showMedia ? 'evo-ui-list-item--no-media ' : '') .
                    ($isSelected ? 'is-selected ' : '') .
                    $stateClasses);
                $itemAttributes = new \Illuminate\View\ComponentAttributeBag([
                    'wire:key' => data_get($row, 'wire_key', 'row-' . $rowId) . '-list',
                    'wire:click' => 'selectRow(' . $rowId . ')',
                    'tabindex' => '0',
                    'aria-selected' => $isSelected ? 'true' : 'false',
                    'class' => $itemClass,
                ]);
                $providerRowAttributes = $controller->rowAttributes($row);
                $itemAttributes = $itemAttributes
                    ->class($providerRowAttributes['class'] ?? '')
                    ->merge(array_diff_key($providerRowAttributes, ['class' => true]));

                if ($opensModal && $rowId > 0) {
                    $itemAttributes = $itemAttributes->merge(['data-evo-modal-dblclick' => $rowId]);

                    if ($modalDblclickAction !== '') {
                        $itemAttributes = $itemAttributes->merge(['data-evo-modal-action' => $modalDblclickAction]);
                    }
                } elseif ($editUrl !== '') {
                    $itemAttributes = $itemAttributes->merge(['data-evo-manager-dblclick' => $editUrl]);
                }

                if ($reorderEnabled && $rowId > 0) {
                    $itemAttributes = $itemAttributes->merge([
                        'class' => 'evo-ui-list-item--dnd',
                        'data-evo-dnd-item' => true,
                        'data-evo-dnd-uid' => (string) $rowId,
                        'data-evo-table-row' => (string) $rowId,
                        'draggable' => 'true',
                    ]);
                }

                $target = (string) ($titleLink['target'] ?? '');
                $metaItems = [];

                foreach ($metaColumns as $column) {
                    $key = $column['key'] ?? '';
                    $type = $column['type'] ?? 'text';
                    $rawValue = data_get($row, $column['value'] ?? $key);
                    $value = $controller->cellDisplay($row, $column);

                    if ($value === '' || $value === '-') {
                        continue;
                    }

                    $metaItems[] = [
                        'key' => $key,
                        'label' => __($column['label'] ?? ''),
                        'icon' => $key === 'id' || $type === 'icon'
                            ? null
                            : match ($key) {
                                'published_at' => 'calendar',
                                'categories' => 'category',
                                'tags' => 'hash',
                                'features' => 'highlight',
                                'views' => 'eye',
                                default => $column['meta_icon'] ?? 'circle',
                            },
                        'type' => $type,
                        'items' => collect((array) $rawValue)->filter()->values()->all(),
                        'raw' => $rawValue,
                        'value' => $value,
                    ];
                }
            ?>

            <article {{ $itemAttributes }}>
                <?php if ($showMedia): ?>
                    <div class="evo-ui-list-item__media">
                        <?php if ($imageColumn && !empty($imageColumn['editable'])): ?>
                            <x-evo::table.module.inline-image :row="$row" :column="$imageColumn" :display-value="$cover" />
                        <?php elseif (is_array($cover) && !empty($cover['src'])): ?>
                            <figure class="evo-ui-table-image">
                                <img src="{{ $cover['src'] }}" alt="{{ $cover['alt'] ?? '' }}" width="46" height="34" loading="lazy" decoding="async">
                            </figure>
                        <?php else: ?>
                            <x-evo::icon :name="$mediaIcon" />
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="evo-ui-list-item__body">
                    <div class="evo-ui-list-item__main">
                        <?php if ($showLabels): ?>
                            <div class="evo-ui-list-field">
                                <?php if ($titleDisplayLabel !== ''): ?>
                                    <span class="evo-ui-list-field__label">{{ $titleDisplayLabel }}</span>
                                <?php endif; ?>
                                <span class="evo-ui-list-field__value">
                        <?php endif; ?>
                        <?php if ($titleColumn && !empty($titleColumn['editable'])): ?>
                            <x-evo::table.module.inline-edit :row="$row" :column="$titleColumn" :display-value="$titleValue" class="evo-ui-inline-edit--title" />
                        <?php elseif (!empty($titleLink['href'])): ?>
                            <a
                                class="evo-ui-table-link"
                                href="{{ $titleLink['href'] }}"
                                <?php if ($target !== ''): ?> target="{{ $target }}"<?php endif; ?>
                                x-on:click.stop
                            >{{ $titleLink['label'] ?? '' }}</a>
                        <?php else: ?>
                            <strong>{{ $titleLink['label'] ?? '' }}</strong>
                        <?php endif; ?>
                        <?php if ($showLabels): ?>
                                </span>
                            </div>
                        <?php endif; ?>

                        <?php if ($subtitleColumn || $subtitle !== ''): ?>
                            <?php if ($showLabels): ?>
                                <div class="evo-ui-list-field">
                                    <?php if ($subtitleDisplayLabel !== ''): ?>
                                        <span class="evo-ui-list-field__label">{{ $subtitleDisplayLabel }}</span>
                                    <?php endif; ?>
                                    <span class="evo-ui-list-field__value">
                            <?php endif; ?>
                            <?php if ($subtitleColumn && !empty($subtitleColumn['editable'])): ?>
                                <x-evo::table.module.inline-edit :row="$row" :column="$subtitleColumn" :display-value="$subtitleRawValue" class="evo-ui-inline-edit--subtitle" />
                            <?php elseif ($subtitle !== ''): ?>
                                <span>{{ $subtitle }}</span>
                            <?php endif; ?>
                            <?php if ($showLabels): ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <?php if (count($metaItems)): ?>
                        <dl class="evo-ui-list-item__meta">
                            <?php foreach ($metaItems as $meta): ?>
                                <?php $metaIcon = $meta['icon']; ?>
                                <div>
                                    <?php if ($metaIcon): ?>
                                        <dt title="{{ $meta['label'] }}" aria-label="{{ $meta['label'] }}">
                                            <x-evo::icon :name="$metaIcon" />
                                        </dt>
                                    <?php else: ?>
                                        <dt class="evo-ui-sr-only">{{ $meta['label'] }}</dt>
                                    <?php endif; ?>
                                    <dd>
                                        <?php if ($meta['type'] === 'chips'): ?>
                                            <span class="evo-ui-meta-list">
                                                <?php foreach ($meta['items'] as $item): ?>
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
                                            </span>
                                        <?php elseif ($meta['key'] === 'id'): ?>
                                            <span class="evo-ui-id">{{ $meta['value'] }}</span>
                                        <?php elseif ($meta['type'] === 'badge'): ?>
                                            <x-evo::badge :value="$meta['raw']" :label="$meta['value']" />
                                        <?php elseif ($meta['type'] === 'position'): ?>
                                            <span class="evo-ui-position-control evo-ui-position-control--meta evo-ui-position-control--rail" title="{{ $meta['label'] }}">
                                                <x-evo::reorder-rail
                                                    class="evo-ui-reorder-rail--table"
                                                    move-up="moveRow({{ $rowId }}, 'up')"
                                                    move-down="moveRow({{ $rowId }}, 'down')"
                                                    label="{{ $meta['label'] }}"
                                                />
                                                <span class="evo-ui-sr-only">{{ $meta['value'] }}</span>
                                            </span>
                                        <?php elseif ($meta['type'] === 'icon'): ?>
                                            <?php
                                                $iconValue = is_array($meta['raw']) ? (string) ($meta['raw']['icon'] ?? 'circle') : (string) $meta['raw'];
                                                $iconLabel = is_array($meta['raw']) ? (string) ($meta['raw']['label'] ?? $meta['value']) : (string) $meta['value'];
                                                $iconTone = is_array($meta['raw']) ? preg_replace('/[^a-z0-9_-]/i', '', (string) ($meta['raw']['tone'] ?? '')) : '';
                                                $iconClass = trim('evo-ui-table-icon ' . ($iconTone !== '' ? 'evo-ui-table-icon--badge evo-ui-table-icon--' . $iconTone : ''));
                                            ?>
                                            <span class="{{ $iconClass }}" title="{{ $iconLabel }}" aria-label="{{ $iconLabel }}">
                                                <x-evo::icon :name="$iconValue" />
                                                <span class="evo-ui-sr-only">{{ $iconLabel }}</span>
                                            </span>
                                        <?php elseif ($meta['type'] === 'markdown'): ?>
                                            <span>{!! \Illuminate\Support\Str::inlineMarkdown((string) $meta['value'], ['html_input' => 'strip', 'allow_unsafe_links' => false]) !!}</span>
                                        <?php else: ?>
                                            <span>{{ $meta['value'] }}</span>
                                        <?php endif; ?>
                                    </dd>
                                </div>
                            <?php endforeach; ?>
                        </dl>
                    <?php endif; ?>
                </div>

                <?php if (!empty($config['row_actions'])): ?>
                    <div class="evo-ui-row-actions">
                        <?php foreach ($config['row_actions'] as $action): ?>
                            <?php
                                $type = $action['type'] ?? 'link';
                                $icon = $action['icon'] ?? 'circle';
                                $tone = $action['tone'] ?? 'neutral';
                                $labelKey = $action['label'] ?? '';

                                if (($action['icon_field'] ?? null) && data_get($row, $action['icon_field'])) {
                                    $icon = $action['icon_true'] ?? $icon;
                                } elseif ($action['icon_field'] ?? null) {
                                    $icon = $action['icon_false'] ?? $icon;
                                }

                                if (($action['tone_field'] ?? null) && data_get($row, $action['tone_field'])) {
                                    $tone = $action['tone_true'] ?? $tone;
                                } elseif ($action['tone_field'] ?? null) {
                                    $tone = $action['tone_false'] ?? $tone;
                                }

                                if (($action['label_field'] ?? null) && data_get($row, $action['label_field'])) {
                                    $labelKey = $action['label_true'] ?? $labelKey;
                                } elseif ($action['label_field'] ?? null) {
                                    $labelKey = $action['label_false'] ?? $labelKey;
                                }

                                $label = $labelKey !== '' ? __($labelKey) : '';
                                $buttonClass = trim('evo-ui-row-action ' . (in_array($tone, ['primary', 'info', 'success', 'warning', 'danger'], true) ? 'evo-ui-row-action--' . $tone : ''));
                                $disabledField = $action['disabled_field'] ?? null;
                                $disabled = $disabledField ? (bool) data_get($row, $disabledField) : (bool) ($action['disabled'] ?? false);
                            ?>

                            <?php if ($type === 'wire'): ?>
                                <?php
                                    $method = $action['method'] ?? '';
                                    $argument = (int) $resolveActionValue($row, $action['argument'] ?? 'id');
                                    $withActionKey = (bool) ($action['action_argument'] ?? false);
                                    $wireClick = $withActionKey
                                        ? $method . "('" . e((string) ($action['key'] ?? '')) . "', " . $argument . ')'
                                        : $method . '(' . $argument . ')';
                                ?>
                                <button type="button" class="{{ $buttonClass }}" title="{{ $label }}" aria-label="{{ $label }}" wire:click.stop="{{ $wireClick }}" @disabled($disabled)>
                                    <x-evo::icon :name="$icon" />
                                    <span class="evo-ui-sr-only">{{ $label }}</span>
                                </button>
                            <?php elseif ($type === 'placeholder'): ?>
                                <button type="button" class="{{ $buttonClass }}" title="{{ $label }}" aria-label="{{ $label }}" disabled>
                                    <x-evo::icon :name="$icon" />
                                    <span class="evo-ui-sr-only">{{ $label }}</span>
                                </button>
                            <?php else: ?>
                                <?php
                                    $href = $type === 'delete' ? ($action['href'] ?? '#') : $resolveActionValue($row, $action['href'] ?? '#');
                                ?>
                                <a
                                    href="{{ $href ?: '#' }}"
                                    class="{{ $buttonClass }}"
                                    title="{{ $label }}"
                                    aria-label="{{ $label }}"
                                    <?php if ($type === 'delete'): ?>
                                        data-href="{{ data_get($row, 'delete_url') }}"
                                        data-delete="{{ $rowId }}"
                                        data-name="{{ data_get($row, 'delete_name') }}"
                                    <?php elseif (($action['attributes']['data-evo-manager-link'] ?? false) && $href): ?>
                                        data-evo-manager-link
                                        data-tab-back="{{ data_get($row, 'edit_back') }}"
                                    <?php endif; ?>
                                    x-on:click.stop
                                >
                                    <x-evo::icon :name="$icon" />
                                    <span class="evo-ui-sr-only">{{ $label }}</span>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="evo-ui-table-empty">@lang('evo::global.table_empty')</div>
    <?php endif; ?>
</div>
