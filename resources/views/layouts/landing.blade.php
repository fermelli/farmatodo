<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,300;0,400;0,700;1,300;1,400;1,700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body>
        <header>
            <div class="bg-emerald-100 font-[Poppins]">
                <div class="py-2 px-4 container mx-auto flex justify-between">
                    <div></div>
                    @if (Route::has('login'))
                        <div class="text-sm">
                            @auth
                                <a class="text-sm px-4 hover:text-slate-700" href="{{ url('/dashboard') }}">{{ __('Dashboard') }}</a>
                            @else
                                <a class="text-sm px-4 hover:text-slate-700" href="{{ route('login') }}">{{ __('Log in') }}</a>
        
                                @if (Route::has('register'))
                                    <a class="text-sm px-4 hover:text-slate-700" href="{{ route('register') }}">{{ __('Register') }}</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex py-4">
                <div class="container mx-auto">
                    <img class="my-4 mx-8" src="{{ asset('images/logo.webp') }}" alt="Logo">
                </div>
            </div>

            <nav class="bg-[#348A7B] px-8">
                <ul class="flex flex-wrap justify-between container mx-auto font-['Roboto_Condensed'] uppercase text-white">
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="{{ route('landing') }}">Inicio</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="{{ route('landing') }}#mision">Misión</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="{{ route('landing') }}#productos">Productos</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="{{ route('landing') }}#nosotros">Nosotros</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="{{ route('landing') }}#contacto">Contacto</a>
                    </li>
                </ul>
            </nav>
        </header>

        <main id="shopping-cart">
            {{ $slot }}
        </main>

        <footer class="bg-[#ecf4f3] py-16">
            <section id="contacto">
                <div class="flex flex-wrap gap-10 container mx-auto text-[#6F7987]">
                    <div class="md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)]">
                        <img class="m-4" src="{{ asset('images/logo.webp') }}" alt="Logo">
                        <p class="text-lg font-light py-8 px-4">Si necesita medicamentos, estamos aquí a su lado. ¡Manténgase seguro y compre en línea!</p>
                    </div>
                    <div class="md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)]">
                        <h6 class="text-xl">Enlaces útiles</h6>
                        <ul class="py-4">
                            <li>
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="{{ route('landing') }}">Inicio</a>
                            </li>
                            <li>
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="{{ route('landing') }}#mision">Misión</a>
                            </li>
                            <li>
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="{{ route('landing') }}#productos">Productos</a>
                            </li>
                            <li>
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="{{ route('landing') }}#nosotros">Nosotros</a>
                            </li>
                        </ul>
                    </div>
                    <div id="contacto" class="md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)]">
                        <h6 class="text-xl">Contactos</h6>
                        <ul class="py-4">
                            <li class="text-lg font-light py-2">
                                <img class="inline w-6 h-6" src="{{ asset('images/location-svgrepo-com.svg') }}" alt="location">
                                Junin #134, Sucre - Bolivia
                            </li>
                            <li class="text-lg font-light py-2">
                                <img class="inline w-6 h-6" src="{{ asset('images/phone-svgrepo-com.svg') }}" alt="phone">
                                +591-4-12345 <br>
                                +591-71234567
                            </li>
                            <li class="text-lg font-light py-2">
                                <img class="inline w-6 h-6" src="{{ asset('images/email-svgrepo-com.svg') }}" alt="email">
                                testo.test.55@gmail.com
                            </li>
                        </ul>
                    </div>
                    <div class="md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)]">
                        <h6 class="text-xl">Boletin informativo</h6>
                        <p class="text-lg font-light py-8">
                            Suscríbete a nuestro boletín y recibe 10% de descuento en tu primera compra
                        </p>
                        <form class="relative" action="">
                            <input class="relative w-full px-8 py-4 pr-12 rounded-full border-slate-400" type="email" name="email-newsletter" placeholder="Ingresa tu e-mail">
                            <input class="absolute right-0 w-[58px] h-[58px] rounded-full bg-[#348A7B] text-white cursor-pointer hover:bg-[#296e62]" type="submit" value="OK">
                        </form>
                    </div>
                </div>
            </section>   
        </footer>
    </body>
</html>
