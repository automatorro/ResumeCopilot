<div>
    @if($certifications->isEmpty() && !$showForm)
        <div class="text-center py-10 text-slate-500 text-sm">
            Nicio certificare adăugată încă.
        </div>
    @endif

    @foreach($certifications as $cert)
        <div class="flex items-start justify-between gap-4 py-4 border-b border-white/5 last:border-0">
            <div class="min-w-0">
                <p class="text-sm font-semibold text-slate-200">{{ $cert->name }}</p>
                @if($cert->issuer)
                    <p class="text-sm text-slate-400">{{ $cert->issuer }}</p>
                @endif
                <p class="text-xs text-slate-500 mt-0.5">
                    @if($cert->issued_at)Emis: {{ $cert->issued_at->format('M Y') }}@endif
                    @if($cert->expires_at) · Expiră: {{ $cert->expires_at->format('M Y') }}@endif
                </p>
                @if($cert->credential_url)
                    <a href="{{ $cert->credential_url }}" target="_blank" rel="noopener"
                       class="text-xs text-brand-400 hover:text-brand-300 mt-0.5 inline-block transition-colors">
                        Vezi certificat →
                    </a>
                @endif
            </div>
            <div class="flex gap-2 shrink-0">
                <button wire:click="openEdit({{ $cert->id }})"
                        class="p-1.5 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-white/5 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                </button>
                <button wire:click="delete({{ $cert->id }})"
                        wire:confirm="Ștergi certificarea '{{ $cert->name }}'?"
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
                {{ $editingId ? 'Editează certificarea' : 'Adaugă certificare' }}
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nume certificare *</label>
                    <input type="text" wire:model="name" class="field" placeholder="Ex: AWS Solutions Architect">
                    @error('name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Emitent</label>
                    <input type="text" wire:model="issuer" class="field" placeholder="Ex: Amazon Web Services">
                    @error('issuer') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">URL certificat</label>
                    <input type="url" wire:model="credential_url" class="field" placeholder="https://...">
                    @error('credential_url') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Data emiterii</label>
                    <input type="date" wire:model="issued_at" class="field">
                    @error('issued_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Data expirării</label>
                    <input type="date" wire:model="expires_at" class="field">
                    @error('expires_at') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
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
                Adaugă certificare
            </button>
        </div>
    @endif
</div>
