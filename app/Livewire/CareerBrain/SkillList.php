<?php

namespace App\Livewire\CareerBrain;

use App\Models\Skill;
use Livewire\Component;

class SkillList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $name = '';
    public string $category = '';
    public string $level = 'intermediate';

    public array $levels = [
        'beginner'     => 'Începător',
        'intermediate' => 'Intermediar',
        'advanced'     => 'Avansat',
        'expert'       => 'Expert',
    ];

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $skill = Skill::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId = $id;
        $this->name      = $skill->name     ?? '';
        $this->category  = $skill->category ?? '';
        $this->level     = $skill->level    ?? 'intermediate';
        $this->showForm  = true;
    }

    public function save(): void
    {
        $this->validate([
            'name'     => 'required|string|max:100',
            'category' => 'nullable|string|max:100',
            'level'    => 'required|in:beginner,intermediate,advanced,expert',
        ]);

        $data = [
            'user_id'  => auth()->id(),
            'name'     => $this->name,
            'category' => $this->category,
            'level'    => $this->level,
        ];

        if ($this->editingId) {
            Skill::where('user_id', auth()->id())->findOrFail($this->editingId)->update($data);
        } else {
            $max = Skill::where('user_id', auth()->id())->max('sort_order') ?? 0;
            Skill::create(array_merge($data, ['sort_order' => $max + 1]));
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Skill::where('user_id', auth()->id())->findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->showForm  = false;
        $this->editingId = null;
        $this->name      = '';
        $this->category  = '';
        $this->level     = 'intermediate';
    }

    public function render()
    {
        return view('livewire.career-brain.skill-list', [
            'skills' => auth()->user()->skills()->orderBy('category')->orderBy('sort_order')->get(),
        ]);
    }
}
