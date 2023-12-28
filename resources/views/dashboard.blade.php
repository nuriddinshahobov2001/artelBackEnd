@extends('layouts.app')

@section('content')

    @if(\Session::has('success'))
        <div class="alert alert-success alert-dismissible show fade">
            {{ \Session::get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @elseif(\Session::has('error'))
        <div class="alert alert-danger alert-dismissible show fade">
            {{ \Session::get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div>
        <a href="{{ route('good.get') }}" class="btn btn-outline-primary">Загрузить товаров</a>
        <a href="{{ route('brands.get') }}" class="btn btn-outline-success">Загрузить бренды</a>
        <a href="{{ route('category.get') }}" class="btn btn-outline-danger">Загрузить категорий</a>
        <a href="{{ route('image.get') }}" class="btn btn-outline-warning">Загрузить изображений</a>
    </div>

@endsection
