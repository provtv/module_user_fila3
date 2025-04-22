<div class="relative">
    <!-- SVG Background Pattern (opzionale) -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-5">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0,0 L100,0 L100,100 L0,100 Z" fill="none" stroke="#003d73" stroke-width="0.5"></path>
            <circle cx="20" cy="20" r="15" fill="none" stroke="#003d73" stroke-width="0.5"></circle>
            <circle cx="80" cy="80" r="15" fill="none" stroke="#003d73" stroke-width="0.5"></circle>
            <path d="M0,0 Q50,50 100,100" fill="none" stroke="#003d73" stroke-width="0.5"></path>
            <path d="M100,0 Q50,50 0,100" fill="none" stroke="#003d73" stroke-width="0.5"></path>
        </svg>
    </div>

    <!-- Intestazione form -->
    <div class="relative z-10 mb-6">
        <div class="flex items-center justify-center mb-4">
            <div class="w-12 h-1 bg-blue-900 rounded-full mr-2"></div>
            <h2 class="text-xl font-medium text-blue-900">Crea il tuo account</h2>
            <div class="w-12 h-1 bg-blue-900 rounded-full ml-2"></div>
        </div>
        <p class="text-center text-gray-500 text-sm">Compila il form per accedere a tutti i servizi di SaluteOra</p>
    </div>

    <!-- Form di registrazione -->
    <div class="relative z-10 bg-white rounded-xl shadow-md p-1">
        <form wire:submit.prevent="register" class="space-y-2">
            {{ $this->form }}
        </form>
    </div>

    <!-- Footer con link di accesso -->
    <div class="relative z-10 text-sm text-center text-gray-600 mt-6 flex items-center justify-center space-x-2">
        <span>Hai già un account?</span>
        <a href="{{ route('login') }}" class="inline-flex items-center text-blue-800 hover:text-blue-600 transition-colors duration-200">
            <span>Accedi</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </a>
    </div>

    <!-- Informazioni aggiuntive -->
    <div class="relative z-10 mt-8 text-xs text-center text-gray-500 px-4">
        <p>Registrandoti, accetti i <a href="#" class="text-blue-800 hover:underline">Termini di Servizio</a> e l'<a href="#" class="text-blue-800 hover:underline">Informativa sulla Privacy</a> di SaluteOra</p>
    </div>
</div>
