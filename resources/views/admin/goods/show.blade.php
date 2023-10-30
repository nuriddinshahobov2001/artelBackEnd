@extends('layouts.app')

@section('content')
    <a href="{{ route('good.index') }}" class="btn btn-outline-danger mb-2 col-1" style="margin-right: 10px">
        Назад
    </a>
    <a href="{{ route('good.edit', $good->id) }}" class="btn btn-outline-primary mb-2 col-1">
        Изменить
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

                <div class="col-7" >
                    <label>Полное описание</label>
                    <textarea class="form-control" cols="30" rows="3" disabled
                            >@foreach(json_decode($good->full_description) as $item) @foreach($item as $key => $value){{ $key }}: {{ $value . "\n" }} @endforeach @endforeach
                    </textarea>
                </div>
            </div>
        </div>
    </div>

    @if(isset($good->images))
        @foreach($good->images as $image)
            <img src="{{ $image?->image }}"  style="width: 200px">
        @endforeach
    @endif
@endsection
