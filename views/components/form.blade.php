@props([
    'controller',
    'config',
    'tabs' => [],
    'sections' => [],
    'actions' => [],
    'saved' => false,
    'dirty' => false,
])

@php
    $sectionsByTab = collect($sections)->groupBy(fn ($section) => $section['tab'] ?? ($tabs[0]['name'] ?? 'default'));
    $initialTab = $tabs[0]['name'] ?? 'default';
    $variant = (string) ($config['variant'] ?? 'default');
    $layout = trim((string) ($config['layout'] ?? ''));
    $layoutClass = $layout !== '' ? 'evo-ui-form-surface--layout-' . \Illuminate\Support\Str::slug($layout) : '';
    $density = (string) ($config['density'] ?? ((bool) ($config['compact'] ?? false) ? 'compact' : 'default'));
    $density = in_array($density, ['default', 'compact'], true) ? $density : 'default';
    $showHeading = ($config['show_heading'] ?? true) !== false && ($config['heading'] ?? true) !== false;
@endphp

<section
    @class([
        'evo-ui-form-surface',
        'evo-ui-form-surface--' . $variant,
        'evo-ui-form-surface--density-' . $density,
        $layoutClass => $layoutClass !== '',
        'evo-ui-form-surface--heading-hidden' => !$showHeading,
    ])
    wire:loading.class="is-loading"
    x-data="{
        selected: @js($initialTab),
        dirty: $wire.entangle('dirty').live,
        initialSnapshot: '',
        savedFeedback: @js($saved),
        savedFeedbackTimer: null,
        init() {
            this.$nextTick(() => {
                this.initialSnapshot = this.formSnapshot();
                if (this.savedFeedback) {
                    this.scheduleSavedFeedbackReset();
                }
            });
        },
        formSnapshot() {
            const form = this.$refs.form;

            if (!form) {
                return '';
            }

            const values = Array.from(form.elements)
                .filter((field) => field.name && !field.disabled)
                .map((field) => {
                    if (field.type === 'checkbox' || field.type === 'radio') {
                        return [field.name, field.value, field.checked ? '1' : '0'];
                    }

                    if (field.tagName === 'SELECT' && field.multiple) {
                        return [field.name, Array.from(field.selectedOptions).map((option) => option.value)];
                    }

                    return [field.name, field.value ?? ''];
                })
                .sort((left, right) => JSON.stringify(left).localeCompare(JSON.stringify(right)));

            return JSON.stringify(values);
        },
        captureSnapshot() {
            this.initialSnapshot = this.formSnapshot();
            this.dirty = false;
        },
        scheduleSavedFeedbackReset() {
            clearTimeout(this.savedFeedbackTimer);
            this.savedFeedbackTimer = setTimeout(() => {
                this.savedFeedback = false;
            }, 1600);
        },
        markDirty() {
            this.savedFeedback = false;
            clearTimeout(this.savedFeedbackTimer);
            this.dirty = true;
        },
        afterSaved(event) {
            if (event.detail?.preset && event.detail.preset !== @js($controller->preset)) {
                return;
            }

            this.captureSnapshot();
            this.savedFeedback = true;
            this.scheduleSavedFeedbackReset();
        },
        afterReset(event) {
            if (event.detail?.preset && event.detail.preset !== @js($controller->preset)) {
                return;
            }

            this.savedFeedback = false;
            clearTimeout(this.savedFeedbackTimer);
            this.$nextTick(() => this.captureSnapshot());
        }
    }"
    x-bind:data-evo-form-dirty="dirty ? 'true' : 'false'"
    x-bind:data-evo-form-saved="dirty ? 'false' : 'true'"
    x-on:evo-ui:form.saved.window="afterSaved($event)"
    x-on:evo-ui:form.reset.window="afterReset($event)"
>
    <div class="evo-ui-form-heading">
        <div class="evo-ui-form-heading__main">
            @if($showHeading)
                <h2>
                    @if(!empty($config['icon']))
                        <x-evo::icon :name="$config['icon']" />
                    @endif
                    <span>{{ $controller->formTitle($config) }}</span>
                    @if($controller->formMeta($config))
                        <small>{{ $controller->formMeta($config) }}</small>
                    @endif
                </h2>
                @if(!empty($config['description']))
                    <p>{{ __($config['description']) }}</p>
                @endif
            @endif
        </div>

        @if($actions)
            <div class="evo-ui-form-toolbar" aria-label="@lang('evo::global.form_actions')">
                @foreach($actions as $action)
                    @if(($action['type'] ?? null) === 'save')
                        <x-evo::button
                            :tone="$action['tone'] ?? 'primary'"
                            :variant="$action['variant'] ?? 'filled'"
                            :icon-only="(bool) ($action['icon_only'] ?? false)"
                            type="submit"
                            form="evo-ui-form-{{ $config['key'] ?? 'default' }}"
                            x-bind:title="savedFeedback ? @js(__('evo::global.form_saved')) : @js(__($action['label'] ?? 'evo::global.action_save'))"
                            x-bind:aria-label="savedFeedback ? @js(__('evo::global.form_saved')) : @js(__($action['label'] ?? 'evo::global.action_save'))"
                            x-bind:disabled="!dirty || savedFeedback"
                            x-bind:class="{ 'is-disabled': !dirty || savedFeedback, 'is-saved': savedFeedback }"
                            wire:loading.attr="disabled"
                            wire:target="save"
                        >
                            <x-evo::icon :name="$action['icon'] ?? 'check'" class="evo-ui-btn__icon" x-show="!savedFeedback" />
                            <x-evo::icon name="circle-check" class="evo-ui-btn__icon" x-show="savedFeedback" x-cloak />
                            <span class="evo-ui-btn__label">@lang($action['label'] ?? 'evo::global.action_save')</span>
                        </x-evo::button>
                    @elseif(!empty($action['url']))
                        <x-evo::button
                            :icon="$action['icon'] ?? null"
                            :label="__($action['label'] ?? '')"
                            :href="$controller->actionUrl($action)"
                            :tone="$action['tone'] ?? 'neutral'"
                            icon-only
                        />
                    @elseif(($action['type'] ?? null) === 'reset')
                        <x-evo::button
                            :icon="$action['icon'] ?? 'rotate'"
                            :label="__($action['label'] ?? 'evo::global.action_reset')"
                            wire:click="resetForm"
                            icon-only
                            x-bind:disabled="!dirty"
                            x-bind:class="{ 'is-disabled': !dirty }"
                        />
                    @endif
                @endforeach
            </div>
        @endif
    </div>

    <form
        id="evo-ui-form-{{ $config['key'] ?? 'default' }}"
        class="evo-ui-form"
        wire:submit.prevent="save"
        data-evo-form
        x-ref="form"
        x-on:input.debounce.50ms="markDirty()"
        x-on:change="markDirty()"
    >
        @if($tabs)
            <div class="evo-ui-form-tabs" role="tablist">
                @foreach($tabs as $tab)
                    <button
                        type="button"
                        role="tab"
                        class="evo-ui-form-tab"
                        :class="{ 'is-active': selected === @js($tab['name']) }"
                        :aria-selected="selected === @js($tab['name'])"
                        title="{{ __($tab['label']) }}"
                        x-on:click="selected = @js($tab['name'])"
                    >
                        @if(!empty($tab['icon']))
                            <x-evo::icon :name="$tab['icon']" />
                        @endif
                        <span>{{ __($tab['label']) }}</span>
                    </button>
                @endforeach
            </div>
        @endif

        @foreach($sectionsByTab as $tabName => $tabSections)
            <div
                class="evo-ui-form-tab-panel"
                x-show="selected === @js($tabName)"
                data-evo-form-tab-panel="{{ $tabName }}"
                wire:key="form-tab-panel-{{ $tabName }}"
            >
                @if(empty($config['section_columns']))
                    @foreach($tabSections as $section)
                        @include('evo::components.form.section', ['controller' => $controller, 'config' => $config, 'section' => $section])
                    @endforeach
                @else
                    @php
                        $sectionColumns = collect((array) $config['section_columns'])
                            ->filter(fn ($column) => is_array($column) && !empty($column['sections']))
                            ->values();
                        $sectionByKey = collect($tabSections)->keyBy(fn ($section) => (string) ($section['key'] ?? ''));
                        $columnSectionKeys = $sectionColumns
                            ->flatMap(fn ($column) => (array) ($column['sections'] ?? []))
                            ->map(fn ($key) => (string) $key)
                            ->filter()
                            ->values()
                            ->all();
                    @endphp

                    <div class="evo-ui-form-column-layout">
                        @foreach($sectionColumns as $column)
                            <div class="evo-ui-form-column" data-evo-form-column="{{ $column['key'] ?? $loop->index }}">
                                @foreach((array) ($column['sections'] ?? []) as $sectionKey)
                                    @php($columnSection = $sectionByKey->get((string) $sectionKey))
                                    @if($columnSection)
                                        @include('evo::components.form.section', ['controller' => $controller, 'config' => $config, 'section' => $columnSection])
                                    @endif
                                @endforeach
                            </div>
                        @endforeach

                        @foreach($tabSections as $section)
                            @if(!in_array((string) ($section['key'] ?? ''), $columnSectionKeys, true))
                                @include('evo::components.form.section', ['controller' => $controller, 'config' => $config, 'section' => $section])
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </form>
</section>
