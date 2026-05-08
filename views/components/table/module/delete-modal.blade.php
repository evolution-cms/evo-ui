@props([
    'controller',
])

@if($controller->deleteModalOpen)
    <div class="evo-ui-modal-backdrop evo-ui-confirm-backdrop" role="presentation" wire:key="module-delete-modal">
        <section
            class="evo-ui-modal evo-ui-modal--sm evo-ui-confirm"
            role="dialog"
            aria-modal="true"
            aria-labelledby="evo-ui-delete-confirm-title"
            wire:keydown.escape="closeDeleteModal"
        >
            <header class="evo-ui-modal__header">
                <div class="evo-ui-modal__title" id="evo-ui-delete-confirm-title">
                    <x-evo::icon name="trash" />
                    <span>@lang('evo::global.delete_confirm_title')</span>
                </div>
                <button type="button" class="evo-ui-modal__close" title="@lang('evo::global.action_cancel')" aria-label="@lang('evo::global.action_cancel')" wire:click="closeDeleteModal">
                    <x-evo::icon name="x" />
                </button>
            </header>

            <div class="evo-ui-modal__body evo-ui-confirm__body">
                <p class="evo-ui-confirm__message">
                    @lang('evo::global.delete_confirm_message', ['name' => $controller->deleteRecordName])
                </p>
                @if($controller->deleteErrorMessage !== '')
                    <p class="evo-ui-alert evo-ui-alert--danger">
                        {{ $controller->deleteErrorMessage }}
                    </p>
                @endif
            </div>

            <footer class="evo-ui-modal__footer evo-ui-confirm__footer">
                <button type="button" class="evo-ui-btn" wire:click="closeDeleteModal">
                    @lang('evo::global.action_cancel')
                </button>
                <button type="button" class="evo-ui-btn evo-ui-btn--danger evo-ui-btn--filled" wire:click="deleteConfirmed" wire:loading.attr="disabled" wire:target="deleteConfirmed">
                    <x-evo::icon name="trash" class="evo-ui-btn__icon" />
                    <span>@lang('evo::global.action_delete')</span>
                </button>
            </footer>
        </section>
    </div>
@endif
