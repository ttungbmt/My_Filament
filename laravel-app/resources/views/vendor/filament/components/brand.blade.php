@if (filled($brand = config('filament.brand')))
    <div @class([
        'flex items-center gap-2',
        'text-xl font-bold tracking-tight filament-brand',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
        <img src="https://love2dev.com/img/2000px-instagram_logo_2016svg-2000x2000.png" alt="Logo" class="h-10">
        {{ $brand }}
    </div>
@endif
