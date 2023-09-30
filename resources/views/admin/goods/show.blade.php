@extends('layouts.app')

@section('content')
    <a href="{{ route('good.index') }}" class="btn btn-outline-danger mb-2 col-1">
        Назад
    </a>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input tabindex="1" class="form-control mt-3" value="{{ $good->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input class="form-control mt-3" value="{{ $good->price }}" disabled>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="category_id">Категория</label>
                        <input class="form-control mt-3" value="{{ $good->category?->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="price">Количество</label>
                        <input tabindex="1" class="form-control mt-3" value="{{ $good->count }}" disabled>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="brand_id">Бренд</label>
                        <input type="text" class="form-control mt-3" value="{{ $good->brand?->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="price">Скидка</label>
                        <input name="sale" class="form-control mt-3" value="{{ $good->sale }}" disabled>
                    </div>
                </div>
                <div class="col-5">
                    <label for="description">Описание</label>
                    <textarea class="form-control" cols="30" rows="3" disabled>{{ $good->description }}</textarea>
                </div>

                <div class="col-7">
                    <label for="full_description">Полное описание</label>
                    <textarea class="form-control" cols="30" rows="3" disabled>{{ $good->full_description }}</textarea>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary">Обновить</button>
                </div>
            </div>
        </div>
    </div>
    @if(isset($good->images))
        @foreach($good->images as $image)
            <img src="{{ Storage::url($image->image) }}" class="w-25">
        @endforeach
    @endif
@endsection
