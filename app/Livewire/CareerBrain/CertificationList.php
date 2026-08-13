<?php

namespace App\Livewire\CareerBrain;

use App\Models\Certification;
use Livewire\Component;

class CertificationList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $issuer = '';
    public string $issued_at = '';
    public string $expires_at = '';
    public string $credential_url = '';

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $cert = Certification::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId      = $id;
        $this->name           = $cert->name           ?? '';
        $this->issuer         = $cert->issuer         ?? '';
        $this->issued_at      = $cert->issued_at      ? $cert->issued_at->format('Y-m-d')  : '';
        $this->expires_at     = $cert->expires_at     ? $cert->expires_at->format('Y-m-d') : '';
        $this->credential_url = $cert->credential_url ?? '';
        $this->showForm       = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'           => 'required|string|max:200',
            'issuer'         => 'nullable|string|max:200',
            'issued_at'      => 'nullable|date',
            'expires_at'     => 'nullable|date|after_or_equal:issued_at',
            'credential_url' => 'nullable|url|max:255',
        ]);

        $data = [
            'user_id'        => auth()->id(),
            'name'           => $this->name,
            'issuer'         => $this->issuer,
            'issued_at'      => $this->issued_at  ?: null,
            'expires_at'     => $this->expires_at ?: null,
            'credential_url' => $this->credential_url,
        ];

        if ($this->editingId) {
            Certification::where('user_id', auth()->id())->findOrFail($this->editingId)->update($data);
        } else {
            $max = Certification::where('user_id', auth()->id())->max('sort_order') ?? 0;
            Certification::create(array_merge($data, ['sort_order' => $max + 1]));
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Certification::where('user_id', auth()->id())->findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->showForm       = false;
        $this->editingId      = null;
        $this->name           = '';
        $this->issuer         = '';
        $this->issued_at      = '';
        $this->expires_at     = '';
        $this->credential_url = '';
    }

    public function render()
    {
        return view('livewire.career-brain.certification-list', [
            'certifications' => auth()->user()->certifications,
        ]);
    }
}
