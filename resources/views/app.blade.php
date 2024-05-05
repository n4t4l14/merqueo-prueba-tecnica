<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite(['resources/js/app.js'])
    @stack('scripts')
    <title>Championship</title>
</head>
<body class="h-full">
    <div class="min-h-full">
        <nav class="bg-gray-800">
            <div class="mx-auto max-w-7xl">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-8 w-8" src="{{url('storage/championship.png')}}" alt="Championship">
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <a href="/"
                                   @class([
                                        'bg-gray-900 text-white' => $homePage ?? false,
                                        'text-gray-300 hover:bg-gray-700 hover:text-white' => !($homePage ?? false),
                                        'rounded-md',
                                        'px-3',
                                        'py-2',
                                        'text-sm',
                                        'font-medium',
                                   ])
                                   aria-current="page"
                                >Home</a>

                                <a href="#"
                                   @class([
                                        'bg-gray-900 text-white' => $teamPage ?? false,
                                        'text-gray-300 hover:bg-gray-700 hover:text-white' => !($teamPage ?? false),
                                        'rounded-md',
                                        'px-3',
                                        'py-2',
                                        'text-sm',
                                        'font-medium',
                                   ])
                                   aria-current="page"
                                >{{ isset($teamName) ? 'Equipo ' . $teamName : '' }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        @yield('header')
        <main>
            <div class="container mx-auto px-10 mt-4 py-4 w-full bg-white border border-gray-200 rounded-md">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
