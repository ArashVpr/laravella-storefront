<div class="relative group">
    <button class="inline-flex items-center gap-1 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none transition-colors py-2">
        <span>Documentation</span>
        <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    
    <div class="absolute left-0 mt-2 w-40 bg-white rounded-xl shadow-lg ring-1 ring-black/5 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-left z-50">
        <div class="py-1">
            <a href="{{ route('docs') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">English</a>
            <a href="{{ route('docs.fr') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">Français</a>
            <a href="{{ route('erd') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-primary transition-colors">ERD Schema</a>
        </div>
    </div>
</div>
