<div>

    {{-- IDLE: Upload zone --}}
    @if($status === 'idle')
        <div class="card mb-6">
            <div wire:drop.prevent="$set('file', $event.dataTransfer.files[0])"
                 class="border-2 border-dashed border-white/10 rounded-xl p-12 text-center hover:border-brand-500/40 transition-colors duration-200">
                <div class="w-12 h-12 rounded-xl bg-brand-500/15 border border-brand-500/20 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                    </svg>
                </div>
                <p class="text-slate-300 font-medium mb-1">Trage fișierul aici sau selectează-l</p>
                <p class="text-xs text-slate-500 mb-4">PDF, DOCX, TXT — maxim 10 MB</p>

                <label class="btn-primary cursor-pointer">
                    Selectează fișier
                    <input type="file" wire:model="file" accept=".pdf,.docx,.txt" class="hidden">
                </label>

                @if($file)
                    <p class="mt-3 text-sm text-brand-400">
                        ✓ {{ $file->getClientOriginalName() }}
                    </p>
                @endif
            </div>

            @error('file')
                <p class="mt-2 text-sm text-red-400 text-center">{{ $message }}</p>
            @enderror
        </div>

        @if($file)
            <div class="flex justify-center">
                <button wire:click="upload" class="btn-primary" wire:loading.attr="disabled">
                    <svg wire:loading wire:target="upload" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    Analizează CV-ul cu AI
                </button>
            </div>
        @endif
    @endif

    {{-- UPLOADING / PARSING --}}
    @if(in_array($status, ['uploading', 'parsing']))
        <div class="card text-center py-12">
            <div class="w-12 h-12 rounded-xl bg-brand-500/15 border border-brand-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-brand-400 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
            </div>
            <p class="text-slate-300 font-medium">
                {{ $status === 'uploading' ? 'Se încarcă fișierul...' : 'AI analizează CV-ul...' }}
            </p>
            <p class="text-xs text-slate-500 mt-1">Poate dura 10–20 de secunde</p>
        </div>
    @endif

    {{-- ERROR --}}
    @if($status === 'error')
        <div class="card border border-red-500/20 bg-red-500/5 mb-4">
            <p class="text-sm font-medium text-red-400 mb-1">Eroare la parsare</p>
            <p class="text-xs text-slate-400">{{ $errorMessage }}</p>
        </div>
        <button wire:click="reset" class="btn-primary">Încearcă din nou</button>
    @endif

    {{-- APPLIED --}}
    @if($status === 'applied')
        <div class="card border border-brand-500/20 bg-brand-500/5 mb-4 text-center py-8">
            <div class="w-12 h-12 rounded-xl bg-brand-500/15 border border-brand-500/20 flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </div>
            <p class="text-slate-200 font-semibold">CV importat cu succes!</p>
            <p class="text-xs text-slate-400 mt-1">Datele au fost adăugate în Career Brain.</p>
            <div class="flex gap-3 justify-center mt-4">
                <a href="{{ route('career-brain') }}" class="btn-primary">Vezi Career Brain</a>
                <button wire:click="reset"
                        class="px-4 py-2 text-sm text-slate-400 border border-white/10 rounded-lg hover:bg-white/5 transition-all">
                    Import alt CV
                </button>
            </div>
        </div>
    @endif

    {{-- REVIEW --}}
    @if($status === 'review')
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="text-base font-semibold text-slate-200">Verifică datele extrase</h2>
                <p class="text-xs text-slate-400 mt-0.5">AI a extras informațiile de mai jos din CV-ul tău. Verifică și aplică.</p>
            </div>
            <button wire:click="reset" class="text-xs text-slate-500 hover:text-slate-300 transition-colors">
                Anulează
            </button>
        </div>

        {{-- Apply mode --}}
        <div class="card mb-4">
            <p class="text-xs font-medium text-slate-400 mb-3">Cum aplici datele în Career Brain?</p>
            <div class="flex gap-3">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" wire:model="applyMode" value="append"
                           class="w-4 h-4 text-brand-500 border-white/20 bg-white/5">
                    <span class="text-sm text-slate-300">Adaugă (păstrează ce există)</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" wire:model="applyMode" value="replace"
                           class="w-4 h-4 text-brand-500 border-white/20 bg-white/5">
                    <span class="text-sm text-slate-300">Înlocuiește tot</span>
                </label>
            </div>
        </div>

        {{-- Personal --}}
        @if(!empty($parsed['personal']) && array_filter($parsed['personal']))
            <div class="card mb-3">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Date personale</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(array_filter($parsed['personal']) as $key => $value)
                        <div>
                            <p class="text-xs text-slate-500">{{ str_replace('_', ' ', $key) }}</p>
                            <p class="text-sm text-slate-200">{{ $value }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Summary --}}
        @if(!empty($parsed['summary']))
            <div class="card mb-3">
                <h3 class="text-sm font-semibold text-slate-300 mb-2">Rezumat profesional</h3>
                <p class="text-sm text-slate-400">{{ $parsed['summary'] }}</p>
            </div>
        @endif

        {{-- Experiences --}}
        @if(!empty($parsed['experiences']))
            <div class="card mb-3">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Experiențe ({{ count($parsed['experiences']) }})</h3>
                @foreach($parsed['experiences'] as $exp)
                    <div class="py-2 border-b border-white/5 last:border-0">
                        <p class="text-sm font-medium text-slate-200">{{ $exp['title'] ?? '' }} — {{ $exp['company'] ?? '' }}</p>
                        <p class="text-xs text-slate-500">{{ $exp['start_date'] ?? '' }} → {{ $exp['is_current'] ? 'Prezent' : ($exp['end_date'] ?? '—') }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Educations --}}
        @if(!empty($parsed['educations']))
            <div class="card mb-3">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Educație ({{ count($parsed['educations']) }})</h3>
                @foreach($parsed['educations'] as $edu)
                    <div class="py-2 border-b border-white/5 last:border-0">
                        <p class="text-sm font-medium text-slate-200">{{ $edu['institution'] ?? '' }}</p>
                        <p class="text-xs text-slate-500">{{ $edu['degree'] ?? '' }} {{ $edu['field_of_study'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Skills --}}
        @if(!empty($parsed['skills']))
            <div class="card mb-3">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Competențe ({{ count($parsed['skills']) }})</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($parsed['skills'] as $skill)
                        <span class="px-2.5 py-1 text-xs bg-white/5 border border-white/10 rounded-lg text-slate-300">
                            {{ $skill['name'] ?? '' }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Languages --}}
        @if(!empty($parsed['languages']))
            <div class="card mb-3">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Limbi ({{ count($parsed['languages']) }})</h3>
                <div class="flex flex-wrap gap-2">
                    @foreach($parsed['languages'] as $lang)
                        <span class="px-2.5 py-1 text-xs bg-brand-500/10 border border-brand-500/20 rounded-lg text-brand-400">
                            {{ $lang['name'] ?? '' }} · {{ $lang['proficiency'] ?? '' }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Certifications --}}
        @if(!empty($parsed['certifications']))
            <div class="card mb-4">
                <h3 class="text-sm font-semibold text-slate-300 mb-3">Certificări ({{ count($parsed['certifications']) }})</h3>
                @foreach($parsed['certifications'] as $cert)
                    <div class="py-2 border-b border-white/5 last:border-0">
                        <p class="text-sm font-medium text-slate-200">{{ $cert['name'] ?? '' }}</p>
                        <p class="text-xs text-slate-500">{{ $cert['issuer'] ?? '' }}</p>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="flex justify-end gap-3">
            <button wire:click="reset"
                    class="px-4 py-2 text-sm text-slate-400 border border-white/10 rounded-lg hover:bg-white/5 transition-all">
                Anulează
            </button>
            <button wire:click="apply" class="btn-primary" wire:loading.attr="disabled">
                <svg wire:loading wire:target="apply" class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                </svg>
                Aplică în Career Brain
            </button>
        </div>
    @endif

</div>
