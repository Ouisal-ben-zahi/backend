{{ \Filament\Facades\Filament::renderHook('footer.before') }}

<footer class="filament-footer fixed bottom-0 w-full border-t border-gray-200 bg-gray-50 z-50">
    <div class="w-full h-full flex items-center justify-center py-4 text-center text-sm text-gray-600 px-4">
        {{ \Filament\Facades\Filament::renderHook('footer.start') }}

        <p class="font-medium text-gray-700 m-0">
            © {{ date('Y') }} <span style="color: #CE9C5E; font-weight: 400;">My Marrakech Immo</span>.  
            Développé avec par  
            <a href="https://communik-agency.ma/" target="_blank" rel="noopener noreferrer" style="color: #CE9C5E; font-weight: 600; text-decoration: none;">
                Agence Communik
            </a>.  
            Tous droits réservés.
        </p>

        {{ \Filament\Facades\Filament::renderHook('footer.end') }}
    </div>
</footer>

{{ \Filament\Facades\Filament::renderHook('footer.after') }}
