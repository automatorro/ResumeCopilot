<?php

namespace App\Livewire\CareerBrain;

use Livewire\Component;

class PersonalForm extends Component
{
    public string $display_name = '';
    public string $headline = '';
    public string $phone = '';
    public string $email_contact = '';
    public string $location = '';
    public string $website = '';
    public string $linkedin = '';
    public string $github_url = '';

    public bool $saved = false;

    public function mount(): void
    {
        $profile = auth()->user()->profile;
        if ($profile) {
            $this->display_name  = $profile->display_name  ?? '';
            $this->headline      = $profile->headline      ?? '';
            $this->phone         = $profile->phone         ?? '';
            $this->email_contact = $profile->email_contact ?? '';
            $this->location      = $profile->location      ?? '';
            $this->website       = $profile->website       ?? '';
            $this->linkedin      = $profile->linkedin      ?? '';
            $this->github_url    = $profile->github_url    ?? '';
        }
    }

    public function save(): void
    {
        $this->validate([
            'display_name'  => 'nullable|string|max:120',
            'headline'      => 'nullable|string|max:200',
            'phone'         => 'nullable|string|max:30',
            'email_contact' => 'nullable|email|max:150',
            'location'      => 'nullable|string|max:120',
            'website'       => 'nullable|url|max:255',
            'linkedin'      => 'nullable|url|max:255',
            'github_url'    => 'nullable|url|max:255',
        ]);

        auth()->user()->profile()->updateOrCreate(
            ['user_id' => auth()->id()],
            [
                'display_name'  => $this->display_name,
                'headline'      => $this->headline,
                'phone'         => $this->phone,
                'email_contact' => $this->email_contact,
                'location'      => $this->location,
                'website'       => $this->website,
                'linkedin'      => $this->linkedin,
                'github_url'    => $this->github_url,
            ]
        );

        $this->saved = true;
        $this->dispatch('profile-saved');
    }

    public function render()
    {
        return view('livewire.career-brain.personal-form');
    }
}
