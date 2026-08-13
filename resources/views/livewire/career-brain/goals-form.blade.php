<div>
    @if($saved)
        <div class="mb-4 flex items-center gap-2 text-sm text-brand-400 bg-brand-500/10 border border-brand-500/20 rounded-lg px-4 py-2.5">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Modificările au fost salvate.
        </div>
    @endif

    <form wire:submit="save" class="space-y-4">
        <div>
            <label class="block text-xs font-medium text-slate-400 mb-1.5">Rezumat profesional</label>
            <textarea wire:model="summary" rows="4" class="field resize-none"
                      placeholder="Scurtă descriere a experienței și valorii tale profesionale..."></textarea>
            @error('summary') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs font-medium text-slate-400 mb-1.5">Obiective de carieră</label>
            <textarea wire:model="goals" rows="4" class="field resize-none"
                      placeholder="Ce îți dorești să realizezi pe termen scurt și lung..."></textarea>
            @error('goals') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Rol țintă</label>
                <input type="text" wire:model="target_role" class="field" placeholder="Ex: Product Manager">
                @error('target_role') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Industrie țintă</label>
                <input type="text" wire:model="target_industry" class="field" placeholder="Ex: Fintech, SaaS">
                @error('target_industry') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Disponibilitate</label>
                <input type="text" wire:model="availability" class="field" placeholder="Ex: Imediat, 2 săptămâni">
                @error('availability') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex justify-end pt-2">
            <button type="submit" class="btn-primary" wire:loading.attr="disabled">
                <svg wire:loading class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Salvează
            </button>
        </div>
    </form>
</div>
