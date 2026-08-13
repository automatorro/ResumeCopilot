<?php

namespace App\Livewire\CareerBrain;

use Livewire\Component;

class GoalsForm extends Component
{
    public string $summary = '';
    public string $goals = '';
    public string $target_role = '';
    public string $target_industry = '';
    public string $availability = '';

    public bool $saved = false;

    public function mount(): void
    {
        $brain = auth()->user()->careerBrain;
        if ($brain) {
            $this->summary         = $brain->summary         ?? '';
            $this->goals           = $brain->goals           ?? '';
            $this->target_role     = $brain->target_role     ?? '';
            $this->target_industry = $brain->target_industry ?? '';
            $this->availability    = $brain->availability    ?? '';
        }
    }

    public function save(): void
    {
        $this->validate([
            'summary'         => 'nullable|string|max:2000',
            'goals'           => 'nullable|string|max:2000',
            'target_role'     => 'nullable|string|max:150',
            'target_industry' => 'nullable|string|max:150',
            'availability'    => 'nullable|string|max:100',
        ]);

        auth()->user()->careerBrain()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'summary'         => $this->summary,
                'goals'           => $this->goals,
                'target_role'     => $this->target_role,
                'target_industry' => $this->target_industry,
                'availability'    => $this->availability,
            ]
        );

        $this->saved = true;
    }

    public function render()
    {
        return view('livewire.career-brain.goals-form');
    }
}
