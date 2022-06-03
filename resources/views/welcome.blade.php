<x-landing-layout>
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

    <section id="productos" class="mb-24">
        <div class="container mx-auto">
            <h2 class="font-[Poppins] p-4 mb-4 text-2xl text-[#6c7480] border-b-2 border-b-[#6c7480]">Últimos productos agregados</h2>

            @forelse ($productsByCategory as $categoryName => $products)
                @if (count($products) > 0)
                    <h3 class="font-[Poppins] mx-4 text-xl text-[#6c7480]">{{ $categoryName }}</h3>

                    <div class="flex flex-wrap">
                        @foreach ($products as $product)
                            <div class="w-full px-4 md:px-0 sm:w-1/2 md:w-1/3 lg:w-1/4 xl:w-1/5">
                                <div class="bg-slate-200 mx-4 my-8 p-4 rounded hover:scale-[1.02] duration-150 ease-in-out">
                                    <div class="p-8">
                                        <img class="w-full" src="{{ asset('images/image-svgrepo-com.svg') }}" alt="Imagen producto">
                                    </div>
                                    <h4 class="text-base uppercase mb-2">{{ $product->name }}</h4>
                                    <span class="block text-sm">{{ $product->brand }}</span>
                                    <span class="block text-xl">Bs. {{ $product->price }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @empty
                <div class="w-full px-4">
                    <div class="bg-slate-200 my-8 p-4">
                        No hay productos registrados
                    </div>
                </div>
            @endforelse

            <div>
                <a class="mx-auto block text-center uppercase rounded-full w-[240px] p-4 bg-[#348A7B] text-white cursor-pointer hover:bg-[#296e62]" href="{{ route('product-search') }}">Ver todos</a>
            </div>
        </div>
    </section>
</x-landing-layout>