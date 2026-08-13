<x-app-layout title="Dashboard">

    {{-- Header --}}
    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-slate-100">
            Bună ziua, {{ explode(' ', auth()->user()->name)[0] }}
        </h1>
        <p class="text-slate-400 mt-1 text-sm">Iată o prezentare a profilului tău de carieră.</p>
    </div>

    {{-- Completeness --}}
    @php
        $user = auth()->user();
        $sections = [
            'Profil personal'  => $user->profile?->display_name ? 1 : 0,
            'Obiective carieră'=> $user->careerBrain?->goals ? 1 : 0,
            'Experiență'       => $user->experiences()->count() > 0 ? 1 : 0,
            'Educație'         => $user->educations()->count() > 0 ? 1 : 0,
            'Competențe'       => $user->skills()->count() > 0 ? 1 : 0,
            'Limbi'            => $user->languages()->count() > 0 ? 1 : 0,
        ];
        $completed = array_sum($sections);
        $total = count($sections);
        $percent = (int)(($completed / $total) * 100);
    @endphp

    <div class="card mb-6">
        <div class="flex items-center justify-between mb-3">
            <div>
                <p class="text-sm font-medium text-slate-300">Completitudine profil</p>
                <p class="text-xs text-slate-500 mt-0.5">{{ $completed }} din {{ $total }} secțiuni completate</p>
            </div>
            <span class="text-2xl font-display font-bold text-brand-400">{{ $percent }}%</span>
        </div>
        <div class="w-full bg-white/5 rounded-full h-2">
            <div class="bg-gradient-to-r from-brand-500 to-brand-400 h-2 rounded-full transition-all duration-500"
                 style="width: {{ $percent }}%"></div>
        </div>
        <div class="mt-4 grid grid-cols-2 sm:grid-cols-3 gap-2">
            @foreach($sections as $name => $done)
                <div class="flex items-center gap-2 text-xs {{ $done ? 'text-brand-400' : 'text-slate-500' }}">
                    @if($done)
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    @else
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke-width="2"/>
                        </svg>
                    @endif
                    {{ $name }}
                </div>
            @endforeach
        </div>
    </div>

    {{-- Stat tiles --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        @php
            $stats = [
                ['label' => 'Experiențe', 'value' => $user->experiences()->count(), 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                ['label' => 'Educație',   'value' => $user->educations()->count(),  'icon' => 'M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'],
                ['label' => 'Competențe','value' => $user->skills()->count(),       'icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z'],
                ['label' => 'Limbi',     'value' => $user->languages()->count(),    'icon' => 'M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129'],
            ];
        @endphp

        @foreach($stats as $stat)
            <div class="stat-tile">
                <div class="w-8 h-8 rounded-lg bg-brand-500/15 border border-brand-500/20 flex items-center justify-center mb-1">
                    <svg class="w-4 h-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                    </svg>
                </div>
                <p class="text-2xl font-display font-bold text-slate-100">{{ $stat['value'] }}</p>
                <p class="text-xs text-slate-400">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>

    {{-- Quick actions --}}
    <div class="card">
        <h2 class="text-sm font-semibold text-slate-300 mb-4">Acțiuni rapide</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('career-brain') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Completează profilul
            </a>
            <a href="{{ route('cv-import') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white/5 hover:bg-white/10 border border-white/10 text-slate-300 text-sm font-semibold rounded-lg transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
                Importă CV
            </a>
        </div>
    </div>

</x-app-layout>
