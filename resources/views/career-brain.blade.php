<x-app-layout title="Career Brain">

    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-slate-100">Career Brain</h1>
        <p class="text-slate-400 mt-1 text-sm">Profilul tău complet de carieră — baza pentru orice CV sau scrisoare de intenție.</p>
    </div>

    {{-- Tabs --}}
    <div x-data="{ tab: 'personal' }">

        <div class="flex gap-1 p-1 bg-white/5 rounded-xl mb-6 overflow-x-auto">
            @foreach([
                'personal'     => 'Personal',
                'goals'        => 'Obiective',
                'experience'   => 'Experiență',
                'education'    => 'Educație',
                'skills'       => 'Competențe',
                'languages'    => 'Limbi',
                'certificates' => 'Certificări',
            ] as $key => $label)
                <button @click="tab = '{{ $key }}'"
                        :class="tab === '{{ $key }}' ? 'bg-brand-500/20 text-brand-400 border border-brand-500/30' : 'text-slate-400 hover:text-slate-200'"
                        class="px-4 py-2 rounded-lg text-sm font-medium whitespace-nowrap transition-all duration-200">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        {{-- Personal --}}
        <div x-show="tab === 'personal'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Informații personale</h2>
            <p class="text-sm text-slate-400">Formularul vine în curând.</p>
        </div>

        {{-- Goals --}}
        <div x-show="tab === 'goals'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Obiective de carieră</h2>
            <p class="text-sm text-slate-400">Formularul vine în curând.</p>
        </div>

        {{-- Experience --}}
        <div x-show="tab === 'experience'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Experiență profesională</h2>
            <p class="text-sm text-slate-400">Lista vine în curând.</p>
        </div>

        {{-- Education --}}
        <div x-show="tab === 'education'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Educație</h2>
            <p class="text-sm text-slate-400">Lista vine în curând.</p>
        </div>

        {{-- Skills --}}
        <div x-show="tab === 'skills'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Competențe</h2>
            <p class="text-sm text-slate-400">Lista vine în curând.</p>
        </div>

        {{-- Languages --}}
        <div x-show="tab === 'languages'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Limbi cunoscute</h2>
            <p class="text-sm text-slate-400">Lista vine în curând.</p>
        </div>

        {{-- Certifications --}}
        <div x-show="tab === 'certificates'" class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Certificări</h2>
            <p class="text-sm text-slate-400">Lista vine în curând.</p>
        </div>

    </div>

</x-app-layout>
