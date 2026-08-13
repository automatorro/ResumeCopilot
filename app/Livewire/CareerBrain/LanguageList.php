<?php

namespace App\Livewire\CareerBrain;

use App\Models\Language;
use Livewire\Component;

class LanguageList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $proficiency = 'B2';

    public array $proficiencies = [
        'A1' => 'A1 — Începător',
        'A2' => 'A2 — Elementar',
        'B1' => 'B1 — Intermediar',
        'B2' => 'B2 — Intermediar superior',
        'C1' => 'C1 — Avansat',
        'C2' => 'C2 — Maestru',
        'Native' => 'Nativă',
    ];

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $lang = Language::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId   = $id;
        $this->name        = $lang->name        ?? '';
        $this->proficiency = $lang->proficiency ?? 'B2';
        $this->showForm    = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'        => 'required|string|max:80',
            'proficiency' => 'required|in:A1,A2,B1,B2,C1,C2,Native',
        ]);

        $data = [
            'user_id'     => auth()->id(),
            'name'        => $this->name,
            'proficiency' => $this->proficiency,
        ];

        if ($this->editingId) {
            Language::where('user_id', auth()->id())->findOrFail($this->editingId)->update($data);
        } else {
            $max = Language::where('user_id', auth()->id())->max('sort_order') ?? 0;
            Language::create(array_merge($data, ['sort_order' => $max + 1]));
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Language::where('user_id', auth()->id())->findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->showForm    = false;
        $this->editingId   = null;
        $this->name        = '';
        $this->proficiency = 'B2';
    }

    public function render()
    {
        return view('livewire.career-brain.language-list', [
            'languages' => auth()->user()->languages,
        ]);
    }
}
