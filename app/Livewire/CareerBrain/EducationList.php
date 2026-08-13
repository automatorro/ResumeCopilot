<?php

namespace App\Livewire\CareerBrain;

use App\Models\Education;
use Livewire\Component;

class EducationList extends Component
{
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $institution = '';
    public string $degree = '';
    public string $field_of_study = '';
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
        $edu = Education::where('user_id', auth()->id())->findOrFail($id);
        $this->editingId      = $id;
        $this->institution    = $edu->institution    ?? '';
        $this->degree         = $edu->degree         ?? '';
        $this->field_of_study = $edu->field_of_study ?? '';
        $this->start_date     = $edu->start_date     ? $edu->start_date->format('Y-m-d') : '';
        $this->end_date       = $edu->end_date       ? $edu->end_date->format('Y-m-d')   : '';
        $this->is_current     = $edu->is_current;
        $this->description    = $edu->description    ?? '';
        $this->showForm       = true;
    }

    public function save(): void
    {
        $this->validate([
            'institution'    => 'required|string|max:200',
            'degree'         => 'nullable|string|max:150',
            'field_of_study' => 'nullable|string|max:150',
            'start_date'     => 'required|date',
            'end_date'       => 'nullable|date|after_or_equal:start_date',
            'is_current'     => 'boolean',
            'description'    => 'nullable|string|max:2000',
        ]);

        $data = [
            'user_id'       => auth()->id(),
            'institution'   => $this->institution,
            'degree'        => $this->degree,
            'field_of_study'=> $this->field_of_study,
            'start_date'    => $this->start_date,
            'end_date'      => $this->is_current ? null : ($this->end_date ?: null),
            'is_current'    => $this->is_current,
            'description'   => $this->description,
        ];

        if ($this->editingId) {
            Education::where('user_id', auth()->id())->findOrFail($this->editingId)->update($data);
        } else {
            $max = Education::where('user_id', auth()->id())->max('sort_order') ?? 0;
            Education::create(array_merge($data, ['sort_order' => $max + 1]));
        }

        $this->resetForm();
    }

    public function delete(int $id): void
    {
        Education::where('user_id', auth()->id())->findOrFail($id)->delete();
    }

    public function cancel(): void
    {
        $this->resetForm();
    }

    private function resetForm(): void
    {
        $this->showForm      = false;
        $this->editingId     = null;
        $this->institution   = '';
        $this->degree        = '';
        $this->field_of_study= '';
        $this->start_date    = '';
        $this->end_date      = '';
        $this->is_current    = false;
        $this->description   = '';
    }

    public function render()
    {
        return view('livewire.career-brain.education-list', [
            'educations' => auth()->user()->educations,
        ]);
    }
}
