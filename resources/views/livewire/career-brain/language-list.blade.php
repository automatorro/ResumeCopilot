<div>
    @if($languages->isEmpty() && !$showForm)
        <div class="text-center py-10 text-slate-500 text-sm">
            Nicio limbă adăugată încă.
        </div>
    @endif

    <div class="space-y-2">
        @foreach($languages as $lang)
            <div class="flex items-center justify-between gap-4 py-3 border-b border-white/5 last:border-0">
                <div class="flex items-center gap-3">
                    <span class="text-sm font-medium text-slate-200">{{ $lang->name }}</span>
                    <span class="px-2 py-0.5 text-xs rounded-full bg-brand-500/15 text-brand-400 border border-brand-500/20">
                        {{ $lang->proficiency }}
                    </span>
                </div>
                <div class="flex gap-2 shrink-0">
                    <button wire:click="openEdit({{ $lang->id }})"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button wire:click="delete({{ $lang->id }})"
                            wire:confirm="Ștergi limba '{{ $lang->name }}'?"
                            class="p-1.5 rounded-lg text-slate-400 hover:text-red-400 hover:bg-red-500/10 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Inline form --}}
    @if($showForm)
        <div class="mt-4 p-4 bg-white/3 border border-white/10 rounded-xl space-y-4">
            <h3 class="text-sm font-semibold text-slate-200">
                {{ $editingId ? 'Editează limba' : 'Adaugă limbă' }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Limbă *</label>
                    <input type="text" wire:model="name" class="field" placeholder="Ex: Engleză, Franceză">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nivel *</label>
                    <select wire:model="proficiency" class="field">
                        @foreach($proficiencies as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('proficiency') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
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
                Adaugă limbă
            </button>
        </div>
    @endif
</div>
