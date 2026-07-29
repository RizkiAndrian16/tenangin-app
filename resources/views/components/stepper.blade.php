@props(['currentStep'])

<div class="recommendation-stepper">
    <div class="recommendation-stepper__wrapper">
        @php
        $steps = [
        1 => ['icon' => 'clipboard', 'label' => 'PSS-10'],
        2 => ['icon' => 'activity', 'label' => 'Detail Stres'],
        3 => ['icon' => 'sliders', 'label' => 'Kandidat & Preferensi'],
        4 => ['icon' => 'award', 'label' => 'Final Rekomendasi'],
        5 => ['icon' => 'target', 'label' => 'Focus Mode'],
        6 => ['icon' => 'message-square', 'label' => 'Evaluasi Aktivitas'],
        ];
        @endphp

        {{-- Progress Track Line --}}
        <div class="recommendation-stepper__track">
            <div class="recommendation-stepper__line" style="width: {{ (($currentStep - 1) / 5) * 100 }}%"></div>
        </div>

        {{-- Step Items --}}
        @foreach($steps as $stepNum => $step)
        <div class="recommendation-stepper__step {{ $stepNum == $currentStep ? 'recommendation-stepper__step--active' : ($stepNum < $currentStep ? 'recommendation-stepper__step--completed' : 'recommendation-stepper__step--upcoming') }}">
            <div class="recommendation-stepper__icon-box">
                <i data-feather="{{ $step['icon'] }}" class="recommendation-stepper__icon"></i>
                @if($stepNum < $currentStep)
                    <div class="recommendation-stepper__check-badge">
                    <i data-feather="check" class="recommendation-stepper__check-icon"></i>
            </div>
            @endif
        </div>
        <span class="recommendation-stepper__label">{{ $step['label'] }}</span>
    </div>
    @endforeach
</div>
</div>