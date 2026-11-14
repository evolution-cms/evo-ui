@props([
    'controller',
    'config',
])

<?php
    if (!($controller ?? null) instanceof \EvoUI\Livewire\ModuleTable) {
        throw new \RuntimeException('The module form modal component requires an EvoUI module table controller.');
    }

    $config = is_array($config ?? null) ? $config : [];
    $modal = $controller->modalOptions();
    $fields = $controller->modalFields();
    $modalSize = $modal['size'] ?? 'md';
    $modalIcon = $modal['icon'] ?? 'edit';
    $modalLayout = (string) ($modal['layout'] ?? '');
    $modalNoticesPosition = (string) ($modal['notices_position'] ?? 'before_fields');
    $modalHeaderMeta = $controller->modalHeaderMeta();
    $cancelLabel = __((string) ($modal['cancel_label'] ?? 'evo::global.action_cancel'));
    $modalActions = $controller->modalActions();
    $showSubmit = (($modal['submit'] ?? true) !== false) && (($modal['readonly'] ?? false) !== true);
    $modalNotices = collect((array) ($modal['notices'] ?? []))
        ->filter(fn ($notice) => is_array($notice) && (!empty($notice['title']) || !empty($notice['body'])))
        ->values();
    $modalTabs = collect((array) ($modal['tabs'] ?? []))
        ->filter(fn ($tab) => is_array($tab) && !empty($tab['name']))
        ->values();
    $defaultModalTab = (string) ($modalTabs->first()['name'] ?? '');
?>

<x-evo::modal
    :open="$controller->modalOpen"
    :title="$controller->modalTitle()"
    :icon="$modalIcon"
    :meta="$modalHeaderMeta"
    :size="$modalSize"
    class="evo-ui-modal--form"
>
    <form
        class="evo-ui-modal__form"
        @if($showSubmit)
            x-on:submit.prevent="EvoUI.syncRichEditors($el, $wire).then(() => $wire.saveModal())"
        @else
            x-on:submit.prevent
        @endif
    >
        <div
            class="evo-ui-modal__body"
            x-data="{
                selectedModalTab: @js($defaultModalTab),
                modalData: $wire.entangle('modalData').live,
                fieldVisible(field, expected = true) {
                    return this.modalData?.[field] === expected;
                },
            }"
        >
            @if($modalTabs->isNotEmpty())
                <nav class="evo-ui-form-tabs evo-ui-modal-tabs" aria-label="{{ $controller->modalTitle() }}">
                    @foreach($modalTabs as $tab)
                        @php
                            $tabName = (string) $tab['name'];
                            $tabLabel = __((string) ($tab['label'] ?? $tabName));
                            $tabIcon = (string) ($tab['icon'] ?? '');
                        @endphp
                        <button
                            type="button"
                            class="evo-ui-form-tab"
                            :class="{ 'is-active': selectedModalTab === @js($tabName) }"
                            x-on:click="selectedModalTab = @js($tabName)"
                        >
                            @if($tabIcon !== '')
                                <x-evo::icon :name="$tabIcon" />
                            @endif
                            <span>{{ $tabLabel }}</span>
                        </button>
                    @endforeach
                </nav>
            @endif

            @if($modalNotices->isNotEmpty() && $modalNoticesPosition !== 'after_fields')
                <div class="evo-ui-modal__notices">
                    @foreach($modalNotices as $notice)
                        @php
                            $tone = (string) ($notice['tone'] ?? 'info');
                            $tone = in_array($tone, ['info', 'success', 'warning', 'danger'], true) ? $tone : 'info';
                            $noticeIcon = (string) ($notice['icon'] ?? 'info-circle');
                            $noticeTitle = !empty($notice['title']) ? __((string) $notice['title']) : '';
                            $noticeBody = !empty($notice['body']) ? __((string) $notice['body']) : '';
                        @endphp
                        <div class="evo-ui-alert evo-ui-alert--{{ $tone }}">
                            @if($noticeIcon !== '')
                                <x-evo::icon :name="$noticeIcon" />
                            @endif
                            <span>
                                @if($noticeTitle !== '')
                                    <strong>{{ $noticeTitle }}</strong>
                                @endif
                                @if($noticeBody !== '')
                                    <span>{!! $noticeBody !!}</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif

            @php
                $modalFieldItems = collect($fields)->values();
                $hiddenModalFields = $modalFieldItems->filter(fn ($field) => (($field['type'] ?? 'text') === 'hidden'))->values();
                $visibleModalFields = $modalFieldItems->reject(fn ($field) => (($field['type'] ?? 'text') === 'hidden'))->values();
            @endphp

            <div @class([
                'evo-ui-form-grid',
                'evo-ui-modal__grid',
                'evo-ui-modal__grid--split' => $modalLayout === 'split',
            ])>
                @if($modalLayout === 'split')
                    @foreach($hiddenModalFields as $field)
                        @include('evo::components.table.module.modal-field', ['field' => $field])
                    @endforeach

                    @foreach(($modalTabs->isNotEmpty() ? $modalTabs->pluck('name') : collect([$defaultModalTab])) as $tabName)
                        @php
                            $tabName = (string) $tabName;
                            $tabFields = $visibleModalFields
                                ->filter(fn ($field) => (string) ($field['tab'] ?? $defaultModalTab) === $tabName)
                                ->values();
                            $leftFields = $tabFields
                                ->reject(fn ($field) => in_array((string) ($field['section'] ?? ''), ['relations', 'content'], true))
                                ->values();
                            $relationsFields = $tabFields
                                ->filter(fn ($field) => (string) ($field['section'] ?? '') === 'relations')
                                ->values();
                            $fullFields = $tabFields
                                ->filter(fn ($field) => (string) ($field['section'] ?? '') === 'content')
                                ->values();
                        @endphp

                        @if($leftFields->isNotEmpty() || $relationsFields->isNotEmpty())
                            <div
                                class="evo-ui-modal__columns"
                                @if($modalTabs->isNotEmpty() && $tabName !== '')
                                    x-show="selectedModalTab === @js($tabName)"
                                    x-cloak
                                @endif
                            >
                                <div class="evo-ui-modal__column evo-ui-modal__column--main">
                                    @foreach($leftFields as $field)
                                        @include('evo::components.table.module.modal-field', ['field' => $field])
                                    @endforeach
                                </div>

                                @if($relationsFields->isNotEmpty())
                                    <div class="evo-ui-modal__column evo-ui-modal__column--relations">
                                        @foreach($relationsFields as $field)
                                            @include('evo::components.table.module.modal-field', ['field' => $field])
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        @endif

                        @if($fullFields->isNotEmpty())
                            <div
                                class="evo-ui-modal__full"
                                @if($modalTabs->isNotEmpty() && $tabName !== '')
                                    x-show="selectedModalTab === @js($tabName)"
                                    x-cloak
                                @endif
                            >
                                @foreach($fullFields as $field)
                                    @include('evo::components.table.module.modal-field', ['field' => $field])
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @else
                    @foreach($hiddenModalFields as $field)
                        @include('evo::components.table.module.modal-field', ['field' => $field])
                    @endforeach

                    @foreach(($modalTabs->isNotEmpty() ? $modalTabs->pluck('name') : collect([$defaultModalTab])) as $tabName)
                        @php
                            $tabName = (string) $tabName;
                            $tabFields = $modalTabs->isNotEmpty()
                                ? $visibleModalFields->filter(fn ($field) => (string) ($field['tab'] ?? $defaultModalTab) === $tabName)->values()
                                : $visibleModalFields;
                        @endphp

                        @if($tabFields->isNotEmpty())
                            <div
                                class="evo-ui-modal__tab-panel"
                                @if($modalTabs->isNotEmpty() && $tabName !== '')
                                    x-show="selectedModalTab === @js($tabName)"
                                    x-cloak
                                @endif
                            >
                                @foreach($tabFields as $field)
                                    @include('evo::components.table.module.modal-field', ['field' => $field])
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>

            @if($modalNotices->isNotEmpty() && $modalNoticesPosition === 'after_fields')
                <div class="evo-ui-modal__notices evo-ui-modal__notices--after-fields">
                    @foreach($modalNotices as $notice)
                        @php
                            $tone = (string) ($notice['tone'] ?? 'info');
                            $tone = in_array($tone, ['info', 'success', 'warning', 'danger'], true) ? $tone : 'info';
                            $noticeIcon = (string) ($notice['icon'] ?? 'info-circle');
                            $noticeTitle = !empty($notice['title']) ? __((string) $notice['title']) : '';
                            $noticeBody = !empty($notice['body']) ? __((string) $notice['body']) : '';
                        @endphp
                        <div class="evo-ui-alert evo-ui-alert--{{ $tone }}">
                            @if($noticeIcon !== '')
                                <x-evo::icon :name="$noticeIcon" />
                            @endif
                            <span>
                                @if($noticeTitle !== '')
                                    <strong>{{ $noticeTitle }}</strong>
                                @endif
                                @if($noticeBody !== '')
                                    <span>{!! $noticeBody !!}</span>
                                @endif
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <footer class="evo-ui-modal__footer">
            <button type="button" class="evo-ui-btn" wire:click="closeModal">{{ $cancelLabel }}</button>
            <span class="evo-ui-modal__footer-spacer" aria-hidden="true"></span>
            <?php foreach ($modalActions as $action): ?>
                <?php
                    $tone = $action['tone'] ?? 'neutral';
                    $variant = $action['variant'] ?? 'soft';
                    $buttonClass = trim('evo-ui-btn ' .
                        (in_array($tone, ['primary', 'info', 'success', 'warning', 'danger'], true) ? 'evo-ui-btn--' . $tone . ' ' : '') .
                        ($variant === 'filled' ? 'evo-ui-btn--filled' : ''));
                ?>
                <button
                    type="button"
                    class="{{ $buttonClass }}"
                    wire:click="saveModalAction('{{ $action['key'] }}')"
                    wire:loading.attr="disabled"
                    wire:target="saveModal,saveModalAction"
                >
                    <?php if (!empty($action['icon'])): ?>
                        <x-evo::icon :name="$action['icon']" class="evo-ui-btn__icon" />
                    <?php endif; ?>
                    <span>{{ $action['label'] }}</span>
                </button>
            <?php endforeach; ?>
            @if($showSubmit)
                <button type="submit" class="evo-ui-btn evo-ui-btn--primary evo-ui-btn--filled" wire:loading.attr="disabled" wire:target="saveModal">
                    <x-evo::icon name="check" class="evo-ui-btn__icon" />
                    <span>{{ $controller->modalSubmitLabel() }}</span>
                </button>
            @endif
        </footer>
    </form>
</x-evo::modal>
