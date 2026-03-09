@extends('layouts.public')

@section('content')

<!-- HEADER -->
<div class="bg-gradient-to-r from-[#0e3a4d] to-[#134e65] py-28 text-center text-white">
    <h1 class="text-5xl md:text-6xl font-extrabold mb-4 drop-shadow-lg">
        Driver School Formations
    </h1>
    <p class="text-lg md:text-xl text-gray-200">
        Choisissez votre pack et commencez votre formation aujourd'hui
    </p>
</div>

<!-- FORMATIONS GRID -->
<div class="bg-gray-50 py-20">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-10">

            @foreach($formations as $formation)
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden transform transition duration-500 hover:-translate-y-3 hover:shadow-2xl">

                <!-- IMAGE -->
                <div class="relative h-60 overflow-hidden">
                    @if($formation->image_path)
                    <img src="{{ Storage::url($formation->image_path) }}"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    @else
                    <img src="https://images.unsplash.com/photo-1503376780353-7e6692767b70"
                        class="w-full h-full object-cover transition-transform duration-500 hover:scale-105">
                    @endif

                    <span class="absolute top-4 right-4 bg-orange-500 text-white px-4 py-2 rounded-full font-semibold shadow-md">
                        {{ $formation->prix }} DH
                    </span>
                </div>

                <!-- CONTENT -->
                <div class="p-6">
                    <h2 class="text-2xl font-bold mb-3 text-gray-800 transition-colors duration-300 hover:text-orange-500">
                        {{ $formation->nom }}
                    </h2>

                    <p class="text-gray-500 mb-4 line-clamp-3">
                        {{ $formation->description }}
                    </p>

                    <p class="text-sm text-gray-600 mb-6 flex items-center">
                        ⏱ {{ $formation->duree_heures ?? 20 }} heures
                    </p>

                    <a href="{{ route('register') }}"
                        class="w-full block text-center bg-gradient-to-r from-orange-400 to-orange-500 hover:from-orange-500 hover:to-orange-600 text-white py-3 rounded-xl font-semibold shadow-lg transition-all duration-300">
                        S'inscrire
                    </a>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>

@endsection