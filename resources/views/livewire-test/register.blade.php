<html>
    <head>
        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <span class="text-blue-500">livewireレジスター</span>
        <livewire:register />
        @livewireScripts
    </body>
</html>
