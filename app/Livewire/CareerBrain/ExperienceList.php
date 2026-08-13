<?php

namespace App\Livewire\CareerBrain;

use App\Models\Experience;
use Livewire\Component;

class ExperienceList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $company = '';
    public string $location = '';
    public string $start_date = '';
    public string $end_date = '';
    public bool $is_current = false;
    public string $description = '';

    public function openCreate(): void
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function openEdit(int $id): void
    {
        $exp = Experience::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId   = $id;
        $this->title       = $exp->title       ?? '';
        $this->company     = $exp->company     ?? '';
        $this->location    = $exp->location    ?? '';
        $this->start_date  = $exp->start_date  ? $exp->start_date->format('Y-m-d')  : '';
        $this->end_date    = $exp->end_date    ? $exp->end_date->format('Y-m-d')    : '';
        $this->is_current  = $exp->is_current;
        $this->description = $exp->description ?? '';
        $this->showForm    = true;
    }

    public function save(): void
    {
        $this->validate([
            'title'       => 'required|string|max:150',
            'company'     => 'required|string|max:150',
            'location'    => 'nullable|string|max:150',
            'start_date'  => 'required|date',
            'end_date'    => 'nullable|date|after_or_equal:start_date',
            'is_current'  => 'boolean',
            'description' => 'nullable|string|max:3000',
        ]);

        $data = [
            'user_id'     => auth()->id(),
            'title'       => $this->title,
            'company'     => $this->company,
            'location'    => $this->location,
            'start_date'  => $this->start_date,
            'end_date'    => $this->is_current ? null : ($this->end_date ?: null),
            'is_current'  => $this->is_current,
            'description' => $this->description,
        ];

        if ($this->editingId) {
            Experience::where('user_id', auth()->id())->findOrFail($this->editingId)->update($data);
        } else {
            $max = Experience::where('user_id', auth()->id())->max('sort_order') ?? 0;
            Experience::create(array_merge($data, ['sort_order' => $max + 1]));
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Experience::where('user_id', auth()->id())->findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->showForm    = false;
        $this->editingId   = null;
        $this->title       = '';
        $this->company     = '';
        $this->location    = '';
        $this->start_date  = '';
        $this->end_date    = '';
        $this->is_current  = false;
        $this->description = '';
    }

    public function render()
    {
        return view('livewire.career-brain.experience-list', [
            'experiences' => auth()->user()->experiences,
        ]);
    }
}
