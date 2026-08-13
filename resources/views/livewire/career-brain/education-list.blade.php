<div>
    {{-- List --}}
    @if($educations->isEmpty() && !$showForm)
        <div class="text-center py-10 text-slate-500 text-sm">
            Nicio educație adăugată încă.
        </div>
    @endif

    @foreach($educations as $edu)
        <div class="flex items-start justify-between gap-4 py-4 border-b border-white/5 last:border-0">
            <div class="min-w-0">
                <p class="text-sm font-semibold text-slate-200">{{ $edu->institution }}</p>
                <p class="text-sm text-slate-400">
                    @if($edu->degree){{ $edu->degree }}@endif
                    @if($edu->degree && $edu->field_of_study) · @endif
                    @if($edu->field_of_study){{ $edu->field_of_study }}@endif
                </p>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $edu->start_date->format('Y') }} –
                    {{ $edu->is_current ? 'Prezent' : ($edu->end_date ? $edu->end_date->format('Y') : '—') }}
                </p>
            </div>
            <div class="flex gap-2 shrink-0">
                <button wire:click="openEdit({{ $edu->id }})"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <button wire:click="delete({{ $edu->id }})"
                        wire:confirm="Ești sigur că vrei să ștergi această înregistrare?"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>
        </div>
    @endforeach

    {{-- Inline form --}}
    @if($showForm)
        <div class="mt-4 p-4 bg-white/3 border border-white/10 rounded-xl space-y-4">
            <h3 class="text-sm font-semibold text-slate-200">
                {{ $editingId ? 'Editează educația' : 'Adaugă educație' }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Instituție *</label>
                    <input type="text" wire:model="institution" class="field" placeholder="Ex: Universitatea Politehnică București">
                    @error('institution') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Grad</label>
                    <input type="text" wire:model="degree" class="field" placeholder="Ex: Licență, Master">
                    @error('degree') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Specializare</label>
                    <input type="text" wire:model="field_of_study" class="field" placeholder="Ex: Informatică">
                    @error('field_of_study') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center gap-2 pt-5">
                    <input type="checkbox" wire:model.live="is_current" id="edu_current"
                           class="w-4 h-4 rounded border-white/20 bg-white/5 text-brand-500">
                    <label for="edu_current" class="text-sm text-slate-300">Sunt student în prezent</label>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Anul start *</label>
                    <input type="date" wire:model="start_date" class="field">
                    @error('start_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                @if(!$is_current)
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Anul absolvire</label>
                        <input type="date" wire:model="end_date" class="field">
                        @error('end_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
            <div class="flex gap-2 justify-end">
                <button wire:click="cancel" type="button"
                        class="px-4 py-2 text-sm text-slate-400 hover:text-slate-200 border border-white/10 rounded-lg hover:bg-white/5 transition-all">
                    Anulează
                </button>
                <button wire:click="save" type="button" class="btn-primary" wire:loading.attr="disabled">
                    Salvează
                </button>
            </div>
        </div>
    @endif

    @if(!$showForm)
        <div class="mt-4">
            <button wire:click="openCreate"
                    class="flex items-center gap-2 text-sm text-brand-400 hover:text-brand-300 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adaugă educație
            </button>
        </div>
    @endif
</div>
