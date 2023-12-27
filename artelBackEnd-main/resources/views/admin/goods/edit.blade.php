@extends('layouts.app')

@section('content')
    <a href="{{ route('good.index') }}" class="btn btn-outline-danger mb-2 col-1">
        Назад
    </a>
    <div class="card">
        <form action="{{ route('good.update', $good->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input tabindex="1" type="text" id="name" name="name" class="form-control mt-3"
                                   placeholder="Имя" value="{{ $good->name }}" required>
                            @if($errors->has('name')) <p
                                style="color: red;">{{ $errors->first('name') }}</p> @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Цена</label>
                            <input tabindex="4" type="number" name="price" class="form-control mt-3"
                                   placeholder="Цена" value="{{ $good->price }}" required>
                            @if($errors->has('price')) <p
                                style="color: red;">{{ $errors->first('price') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="category_id">Категория</label>
                            <select name="category_id" class="form-control mt-3" tabindex="2">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $good->category_id === $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('category_id')) <p
                                style="color: red;">{{ $errors->first('category_id') }}</p> @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Количество</label>
                            <input tabindex="5" type="number" name="count" class="form-control mt-3"
                                   placeholder="Количество" value="{{ $good->count }}" required>
                            @if($errors->has('count')) <p
                                style="color: red;">{{ $errors->first('count') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="brand_id">Бренд</label>
                            <select name="brand_id" class="form-control mt-3" tabindex="3">
                                @foreach($brands as $brand)
                                    <option value="{{ $brand->id }}" {{ $good->brand_id === $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('brand_id')) <p
                                style="color: red;">{{ $errors->first('brand_id') }}</p> @endif
                        </div>
                        <div class="form-group">
                            <label for="price">Скидка</label>
                            <input tabindex="6" type="number" name="sale" class="form-control mt-3"
                                   placeholder="Скидка" value="{{ $good->sale }}" required>
                            @if($errors->has('sale')) <p
                                style="color: red;">{{ $errors->first('sale') }}</p> @endif
                        </div>
                    </div>
                    <div class="col-5">
                        <label for="description">Описание</label>
                        <textarea name="description" class="form-control" cols="30" rows="3" tabindex="7">{{ $good->description }}</textarea>
                        @if($errors->has('description')) <p
                            style="color: red;">{{ $errors->first('description') }}</p> @endif
                    </div>
                    <div class="col-7">
                        <label for="full_description">Полное описание</label>
                        <textarea name="full_description" class="form-control" cols="30" rows="3" tabindex="8"
                                >@foreach(json_decode($good->full_description) as $item) @foreach($item as $key => $value){{ $key }}: {{ $value ."\n"}} @endforeach @endforeach
                        </textarea>
                        @if($errors->has('full_description')) <p
                            style="color: red;">{{ $errors->first('full_description') }}</p> @endif
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-primary" tabindex="9">Обновить</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
