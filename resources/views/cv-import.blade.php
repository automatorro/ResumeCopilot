<x-app-layout title="Import CV">

    <div class="mb-8">
        <h1 class="text-2xl font-display font-bold text-slate-100">Import CV</h1>
        <p class="text-slate-400 mt-1 text-sm">Încarcă un CV existent (PDF, DOCX, TXT) și extrage automat informațiile cu AI.</p>
    </div>

    {{-- Upload zone --}}
    <div class="card mb-6">
        <div class="border-2 border-dashed border-white/10 rounded-xl p-12 text-center hover:border-brand-500/40 transition-colors duration-200">
            <div class="w-12 h-12 rounded-xl bg-brand-500/15 border border-brand-500/20 flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>
            <p class="text-slate-300 font-medium mb-1">Trage fișierul aici sau apasă pentru a selecta</p>
            <p class="text-xs text-slate-500">PDF, DOCX, TXT — maxim 10 MB</p>
            <button class="btn-primary mt-4">Selectează fișier</button>
        </div>
    </div>

    {{-- Coming soon notice --}}
    <div class="card border border-gold-500/20 bg-gold-500/5">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-gold-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
                <p class="text-sm font-medium text-gold-300">În dezvoltare</p>
                <p class="text-xs text-slate-400 mt-1">Funcționalitatea de parsare AI a CV-ului este în curs de implementare.</p>
            </div>
        </div>
    </div>

</x-app-layout>
