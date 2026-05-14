@props([
    'icon' => 'sparkles',
    'title' => '',
    'description' => '',
    'badge' => '',
    'steps' => [],
    'primaryLabel' => '',
    'primaryIcon' => 'arrow-right',
    'primaryAction' => '',
    'primaryDisabled' => false,
    'primaryDisabledMessage' => '',
    'notice' => null,
    'requirements' => [],
    'stepsTitle' => '',
])

@php
    $noticeTone = is_array($notice) ? ($notice['tone'] ?? 'info') : 'info';
    $noticeIcon = match ($noticeTone) {
        'danger' => 'alert-triangle',
        'warning' => 'alert-circle',
        'success' => 'circle-check',
        default => 'info',
    };

    $primaryButtonAttributes = new \Illuminate\View\ComponentAttributeBag([
        'type' => 'button',
        'class' => 'evo-ui-btn evo-ui-btn--primary evo-ui-btn--filled',
    ]);

    if ($primaryAction !== '') {
        $primaryButtonAttributes = $primaryButtonAttributes->merge(['wire:click' => $primaryAction]);
    }

    if ($primaryDisabled) {
        $primaryButtonAttributes = $primaryButtonAttributes->merge(['disabled' => true]);
    }
@endphp

<section {{ $attributes->class('evo-ui-onboarding-hero') }}>
    @if($icon !== '' || $badge !== '' || $title !== '' || $description !== '')
        <div class="evo-ui-onboarding-hero__main">
            @if($icon !== '')
                <div class="evo-ui-onboarding-hero__icon">
                    <x-evo::icon :name="$icon" />
                </div>
            @endif

            <div class="evo-ui-onboarding-hero__copy">
                @if($badge !== '')
                    <span class="evo-ui-badge evo-ui-onboarding-hero__badge">{{ $badge }}</span>
                @endif

                @if($title !== '')
                    <h2>{{ $title }}</h2>
                @endif

                @if($description !== '')
                    <p>{{ $description }}</p>
                @endif
            </div>
        </div>
    @endif

    @if(is_array($notice) && !empty($notice['message']))
        <div class="evo-ui-alert evo-ui-alert--{{ $noticeTone }}">
            <x-evo::icon :name="$noticeIcon" />
            <span>{{ $notice['message'] }}</span>
        </div>
    @endif

    @if(!empty($requirements))
        <div class="evo-ui-onboarding-hero__requirements">
            @foreach($requirements as $requirement)
                <div class="evo-ui-onboarding-hero__requirement">
                    <span class="evo-ui-meta-chip">
                        <x-evo::icon :name="$requirement['icon'] ?? 'terminal'" />
                        <span>{{ $requirement['label'] ?? '' }}</span>
                    </span>

                    @if(!empty($requirement['command']))
                        <code>{{ $requirement['command'] }}</code>
                    @endif
                </div>
            @endforeach
        </div>
    @endif

    @if($primaryLabel !== '')
        <div class="evo-ui-onboarding-hero__action">
            <button {{ $primaryButtonAttributes }}>
                <x-evo::icon :name="$primaryIcon" />
                <span>{{ $primaryLabel }}</span>
            </button>

            @if($primaryDisabled && $primaryDisabledMessage !== '')
                <span class="evo-ui-onboarding-hero__action-hint">{{ $primaryDisabledMessage }}</span>
            @endif
        </div>
    @endif

    @if(!empty($steps))
        <div class="evo-ui-onboarding-hero__steps">
            @if($stepsTitle !== '')
                <h3>{{ $stepsTitle }}</h3>
            @endif

            <ol class="evo-ui-step-list">
                @foreach($steps as $step)
                    <li>{{ $step }}</li>
                @endforeach
            </ol>
        </div>
    @endif
</section>
