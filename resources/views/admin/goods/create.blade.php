@extends('layouts.app')

@section('content')
    <a href="{{ route('good.index') }}" class="btn btn-outline-danger mb-2 col-1">
        Назад
    </a>
    <div class="card">
        <form action="{{ route('good.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input tabindex="1" type="text" id="name" name="name" class="form-control mt-3"
                               placeholder="Имя" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="price">Цена</label>
                        <input tabindex="1" type="number" name="price" class="form-control mt-3"
                               placeholder="Цена" value="{{ old('price') }}" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="category_id">Категория</label>
                        <select name="category_id" class="form-control mt-3">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Количество</label>
                        <input tabindex="1" type="number" name="count" class="form-control mt-3"
                               placeholder="Количество" value="{{ old('count') }}" required>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="brand_id">Бренд</label>
                        <select name="brand_id" class="form-control mt-3">
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="price">Скидка</label>
                        <input tabindex="1" type="number" name="sale" class="form-control mt-3"
                               placeholder="Скидка" value="{{ old('sale') }}" required>
                    </div>
                </div>
                <div class="col-5">
                    <label for="description">Описание</label>
                    <textarea name="description" class="form-control" cols="30" rows="3"></textarea>
                </div>

                <div class="col-7">
                    <label for="full_description">Полное описание</label>
                    <textarea name="full_description" class="form-control" cols="30" rows="3"></textarea>
                </div>
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>
    </form>
    </div>
@endsection
