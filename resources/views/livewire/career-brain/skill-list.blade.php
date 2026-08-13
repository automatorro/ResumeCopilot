<div>
    {{-- List grouped by category --}}
    @if($skills->isEmpty() && !$showForm)
        <div class="text-center py-10 text-slate-500 text-sm">
            Nicio competență adăugată încă.
        </div>
    @endif

    @php $grouped = $skills->groupBy('category') @endphp
    @foreach($grouped as $cat => $items)
        @if($cat)
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider mt-4 mb-2 first:mt-0">{{ $cat }}</p>
        @endif
        <div class="flex flex-wrap gap-2 mb-2">
            @foreach($items as $skill)
                <div class="flex items-center gap-1.5 px-3 py-1.5 bg-white/5 border border-white/10 rounded-lg group">
                    <span class="text-sm text-slate-200">{{ $skill->name }}</span>
                    <span class="text-xs text-slate-500">·</span>
                    <span class="text-xs text-slate-400">{{ ['beginner'=>'Începător','intermediate'=>'Intermediar','advanced'=>'Avansat','expert'=>'Expert'][$skill->level] ?? $skill->level }}</span>
                    <button wire:click="openEdit({{ $skill->id }})"
                            class="ml-1 text-slate-500 hover:text-slate-200 opacity-0 group-hover:opacity-100 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                    </button>
                    <button wire:click="delete({{ $skill->id }})"
                            wire:confirm="Ștergi competența '{{ $skill->name }}'?"
                            class="text-slate-500 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-all">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            @endforeach
        </div>
    @endforeach

    {{-- Inline form --}}
    @if($showForm)
        <div class="mt-4 p-4 bg-white/3 border border-white/10 rounded-xl space-y-4">
            <h3 class="text-sm font-semibold text-slate-200">
                {{ $editingId ? 'Editează competența' : 'Adaugă competență' }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Competență *</label>
                    <input type="text" wire:model="name" class="field" placeholder="Ex: Laravel, Excel">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Categorie</label>
                    <input type="text" wire:model="category" class="field" placeholder="Ex: Programare, Soft skills">
                    @error('category') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nivel</label>
                    <select wire:model="level" class="field">
                        @foreach($levels as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('level') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
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
                Adaugă competență
            </button>
        </div>
    @endif
</div>
