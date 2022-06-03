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
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="#mision">Misión</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="#productos">Productos</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="#nosotros">Nosotros</a>
                    </li>
                    <li>
                        <a class="inline-block p-4 hover:text-[#FAC400] border-b-4 border-b-transparent hover:border-b-[#FAC400]" href="#contacto">Contacto</a>
                    </li>
                </ul>
            </nav>
        </header>
        <main>
            <div class="w-full h-[750px] bg-[#94b9b4] relative overflow-hidden">
                <img class="absolute top-[33%] left-[33%]" src="{{ asset('images/layer7.webp') }}" alt="Layer7-1">
                <img class="absolute top-[10%] right-[33%]" src="{{ asset('images/layer7.webp') }}" alt="Layer7-1">
                <img class="absolute bottom-[10%] right-[33%]" src="{{ asset('images/layer7.webp') }}" alt="Layer7-1">
                <img class="absolute top-1/2 left-1/2" src="{{ asset('images/layer3-tl.webp') }}" alt="Layer3">
                <img class="absolute" src="{{ asset('images/layer5-mc.webp') }}" alt="Layer5">
                <img class="absolute bottom-0 right-[-25%]" src="{{ asset('images/layer1.webp') }}" alt="Layer1">
                <img class="absolute bottom-0" src="{{ asset('images/layer2.webp') }}" alt="Layer2">
                <div class="absolute bg-black/20 md:bg-transparent md:w-1/2 h-full top-0 right-0 font-[Poppins] text-white flex items-center">
                    <div>
                        <p class="text-6xl font-bold text-center leading-[1.25] px-8">¿Qué necesitas sobre nosotros y nuestros productos?</p>
                        <p class="text-center text-base">Manten protegida a tu familia</p>
                    </div>
                </div>
            </div>

            <section id="mision">
                <div class="flex flex-wrap container mx-auto my-32">
                    <div class="w-full md:w-1/2">
                        <h2 class="text-[#348A7B] font-[Poppins] text-6xl text-center my-16 w-full px-4">Nuestra Misión</h2>
                    </div>
                    <div class="md:w-1/2">
                        <p class="font-[Poppins] text-[#696A6E] text-base p-4">
                            Contribuir al cuidado y bienestar de la salud de nuestra población a través de la provisión de productos farmacéuticos de calidad a precios accesibles con profesionalismo y amabilidad en la atención del cliente/paciente.
                        </p>
                        <p class="font-[Poppins] text-[#696A6E] text-base p-4">
                            Acompañados de un equipo humano altamente capacitado con espíritu innovador y compromiso de mejora continua.
                        </p>
                    </div>
                </div>
            </section>

            <section id="nosotros">
                <div class="relative w-full h-[900px] bg-[#348A7B] xl:bg-[url('/images/bg.jpg')] bg-[25%_top] xl:bg-[30%_top]">
                    <div class="absolute xl:w-1/2 right-0 py-4 md:p-16 xl:px-32,py-16">
                        <h2 class="font-[Poppins] text-white text-5xl p-4">Nosotros</h2>
                        <p class="font-[Poppins] text-white text-base p-4">
                            Somos una empresa 100% Chuquisaqueña establecida en 1989 dedicada a la salud, el cuidado y bienestar de nuestros clientes.
                        </p>
                        <p class="font-[Poppins] text-white text-base p-4">
                            Son 33 años de servicio caracterizados por dispensar medicamentos de garantía y calidad a precios accesibles. Contamos con 14 sucursales distribuidas por la ciudad de Sucre y más de 150 colaboradores con el fiel compromiso de llevar salud a todos los hogares.
                        </p>
                        <p class="font-[Poppins] text-white text-base p-4">
                            Nuestro modelo innovador nos impulsó a ampliar nuevos servicios, así es como creamos Farmatodo Express, anexos que se encuentran en 8 de nuestras sucursales donde el cliente tiene la libertad de escoger sus productos de manera directa.
                        </p>
                    </div>
                </div>

                <div class="translate-y-[-150px] w-full">
                    <div class="container mx-auto flex flex-wrap gap-10 px-4">
                        <div class="rounded w-full md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)] bg-white drop-shadow-2xl p-8">
                            <div>
                                <img class="w-12 h-12" src="{{ asset('images/moto_icono2.svg') }}" alt="Envio">
                            </div>
                            <h3 class="text-xl my-4">Envío Rápido</h3>
                            <p class="text-lg">A domicilio</p>
                        </div>
                        <div class="rounded w-full md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)] bg-white drop-shadow-2xl p-8">
                            <div>
                                <img class="w-12 h-12" src="{{ asset('images/tienda_icono2.svg') }}" alt="Envio">
                            </div>
                            <h3 class="text-xl my-4">Retiro Gratis</h3>
                            <p class="text-lg">En sucursales</p>
                        </div>
                        <div class="rounded w-full md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)] bg-white drop-shadow-2xl p-8">
                            <div>
                                <img class="w-12 h-12" src="{{ asset('images/pago_icono2.svg') }}" alt="Envio">
                            </div>
                            <h3 class="text-xl my-4">Pago en línea</h3>
                            <p class="text-lg">100% seguro</p>
                        </div>
                        <div class="rounded w-full md:w-[calc(50%_-_40px)] xl:w-[calc(25%_-_40px)] bg-white drop-shadow-2xl p-8">
                            <div>
                                <img class="w-12 h-12" src="{{ asset('images/localizacion_icono2.svg') }}" alt="Envio">
                            </div>
                            <h3 class="text-xl my-4">Localiza</h3>
                            <p class="text-lg">Tu sucursal</p>
                        </div>
                    </div>
                </div>
            </section>
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
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="#mision">Misión</a>
                            </li>
                            <li>
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="#productos">Productos</a>
                            </li>
                            <li>
                                <a class="block text-lg font-light py-2 hover:text-[#ff8367]" href="#nosotros">Nosotros</a>
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
