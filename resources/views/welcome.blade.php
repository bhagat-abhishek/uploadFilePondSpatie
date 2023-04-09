@extends('layouts.app')

@section('content')
    <div class="container mt-4">

        <div class="row mt-4 mb-4">
            <div class="col-md-6 mx-auto">
                <a href="{{ route('home') }}" class="btn btn-sm btn-primary">Home</a>
                <a href="{{ route('create') }}" class="btn btn-sm btn-primary">Create</a>
            </div>
        </div>

        <div class="row mt-4 mb-4">
            <div class="col-md-6 mx-auto">
                @if (Session::get('msg'))
                    <div class="alert alert-primary" role="alert">
                        {{ Session::get('msg') }}
                    </div>
                @endif
            </div>
        </div>
        <div class="row mt-4 mx-auto">
            @forelse ($posts as $post)
                <div class="card m-2" style="width: 16rem;">
                    <section class="splide" id="slider{{ $post->id }}" aria-label="Listing">
                        <div class="splide__track">
                            <ul class="splide__list">
                                @foreach ($post->media as $image)
                                    <li class="splide__slide">
                                        <img src="{{ $image->getFullUrl() }}" alt="" class="img-fluid"
                                            style="display:block;margin-left: auto;margin-right:auto;height:300px;vertical-align:middle;object-fit:contain;background:white;">
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </section>
                    <div class="card-body">
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->description }}</p>
                        <a href="{{ route('edit', ['post' => $post->id]) }}" class="btn btn-sm btn-primary">edit</a>
                        <a href="{{ route('show', ['id' => $post->id]) }}" class="btn btn-sm btn-primary">Show</a>
                        <a href="{{ route('destroy', ['id' => $post->id]) }}" class="btn btn-sm btn-danger">Destroy</a>
                    </div>
                </div>

            @empty
                <div class="alert alert-primary" role="alert">
                    No data
                </div>
            @endforelse
        </div>
    </div>
@endsection

@section('header')
    {{-- Splade JS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
@endsection

@section('footer')
    {{-- Splade JS --}}
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <script>
        @foreach ($posts as $post)
            new Splide('#slider{{ $post->id }}').mount();
        @endforeach
    </script>
@endsection
