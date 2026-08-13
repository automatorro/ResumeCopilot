<div>
    {{-- List --}}
    @if($experiences->isEmpty() && !$showForm)
        <div class="text-center py-10 text-slate-500 text-sm">
            Nicio experiență adăugată încă.
        </div>
    @endif

    @foreach($experiences as $exp)
        <div class="flex items-start justify-between gap-4 py-4 border-b border-white/5 last:border-0">
            <div class="min-w-0">
                <p class="text-sm font-semibold text-slate-200">{{ $exp->title }}</p>
                <p class="text-sm text-slate-400">{{ $exp->company }}@if($exp->location) · {{ $exp->location }}@endif</p>
                <p class="text-xs text-slate-500 mt-0.5">
                    {{ $exp->start_date->format('M Y') }} –
                    {{ $exp->is_current ? 'Prezent' : ($exp->end_date ? $exp->end_date->format('M Y') : '—') }}
                </p>
                @if($exp->description)
                    <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ $exp->description }}</p>
                @endif
            </div>
            <div class="flex gap-2 shrink-0">
                <button wire:click="openEdit({{ $exp->id }})"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <button wire:click="delete({{ $exp->id }})"
                        wire:confirm="Ești sigur că vrei să ștergi această experiență?"
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
                {{ $editingId ? 'Editează experiența' : 'Adaugă experiență' }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Funcție *</label>
                    <input type="text" wire:model="title" class="field" placeholder="Ex: Software Engineer">
                    @error('title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Companie *</label>
                    <input type="text" wire:model="company" class="field" placeholder="Ex: Acme SRL">
                    @error('company') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Locație</label>
                    <input type="text" wire:model="location" class="field" placeholder="Ex: București">
                    @error('location') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div class="flex items-center gap-2 pt-5">
                    <input type="checkbox" wire:model.live="is_current" id="exp_current"
                           class="w-4 h-4 rounded border-white/20 bg-white/5 text-brand-500">
                    <label for="exp_current" class="text-sm text-slate-300">Lucrez aici în prezent</label>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Data start *</label>
                    <input type="date" wire:model="start_date" class="field">
                    @error('start_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                @if(!$is_current)
                    <div>
                        <label class="block text-xs font-medium text-slate-400 mb-1.5">Data final</label>
                        <input type="date" wire:model="end_date" class="field">
                        @error('end_date') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                    </div>
                @endif
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Descriere</label>
                <textarea wire:model="description" rows="3" class="field resize-none"
                          placeholder="Responsabilități, realizări..."></textarea>
                @error('description') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
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

    {{-- Add button --}}
    @if(!$showForm)
        <div class="mt-4">
            <button wire:click="openCreate"
                    class="flex items-center gap-2 text-sm text-brand-400 hover:text-brand-300 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Adaugă experiență
            </button>
        </div>
    @endif
</div>
