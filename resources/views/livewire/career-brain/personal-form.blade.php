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
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Nume afișat</label>
                <input type="text" wire:model="display_name" class="field" placeholder="Ex: Lucian Cebuc">
                @error('display_name') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Titlu profesional</label>
                <input type="text" wire:model="headline" class="field" placeholder="Ex: Senior Software Engineer">
                @error('headline') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Telefon</label>
                <input type="text" wire:model="phone" class="field" placeholder="+40 7xx xxx xxx">
                @error('phone') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Email de contact</label>
                <input type="email" wire:model="email_contact" class="field" placeholder="email@exemplu.com">
                @error('email_contact') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Locație</label>
                <input type="text" wire:model="location" class="field" placeholder="Ex: București, România">
                @error('location') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">Website personal</label>
                <input type="url" wire:model="website" class="field" placeholder="https://exemplu.com">
                @error('website') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">LinkedIn</label>
                <input type="url" wire:model="linkedin" class="field" placeholder="https://linkedin.com/in/...">
                @error('linkedin') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-400 mb-1.5">GitHub</label>
                <input type="url" wire:model="github_url" class="field" placeholder="https://github.com/...">
                @error('github_url') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
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
