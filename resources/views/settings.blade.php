<x-app-layout title="Setări">

    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-slate-100">Setări</h1>
        <p class="text-slate-400 mt-1 text-sm">Gestionează preferințele contului tău.</p>
    </div>

    <div class="max-w-2xl space-y-4">

        {{-- Profile info --}}
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Informații cont</h2>
            <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                @csrf
                @method('patch')
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Nume afișat</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                           class="field" placeholder="Numele tău">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400 mb-1.5">Adresă email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                           class="field" placeholder="email@exemplu.com">
                </div>
                <button type="submit" class="btn-primary">Salvează modificările</button>
            </form>
        </div>

        {{-- Language --}}
        @php $currentLocale = auth()->user()->profile?->language_preference ?? session('locale', 'ro'); @endphp
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Limbă interfață</h2>
            <div class="flex gap-3">
                <form method="POST" action="{{ route('language.switch', 'ro') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                                   {{ $currentLocale === 'ro' ? 'bg-brand-500/20 text-brand-400 border border-brand-500/30' : 'bg-white/5 text-slate-400 border border-white/10 hover:bg-white/10' }}">
                        🇷🇴 Română
                    </button>
                </form>
                <form method="POST" action="{{ route('language.switch', 'en') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200
                                   {{ $currentLocale === 'en' ? 'bg-brand-500/20 text-brand-400 border border-brand-500/30' : 'bg-white/5 text-slate-400 border border-white/10 hover:bg-white/10' }}">
                        🇬🇧 English
                    </button>
                </form>
            </div>
        </div>

        {{-- Delete account --}}
        <div class="card border border-red-500/20 bg-red-500/5">
            <h2 class="text-base font-semibold text-red-400 mb-2">Ștergere cont</h2>
            <p class="text-xs text-slate-400 mb-4">Odată șters, contul și toate datele sunt pierdute permanent.</p>
            <form method="POST" action="{{ route('profile.destroy') }}"
                  onsubmit="return confirm('Ești sigur? Această acțiune nu poate fi anulată.')">
                @csrf
                @method('delete')
                <input type="hidden" name="password" value="">
                <button type="submit"
                        class="px-4 py-2 bg-red-500/20 hover:bg-red-500/30 border border-red-500/30 text-red-400 text-sm font-semibold rounded-lg transition-all duration-200">
                    Șterge contul
                </button>
            </form>
        </div>

    </div>

</x-app-layout>
