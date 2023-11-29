@extends('layouts.app')

@section('content')
    <div class="collapse my-3 show">
        <a href="{{ route('goodsWithDefects') }}" class="btn btn-outline-danger mb-2">
            Назад
        </a>
        <div class="card">
            <div class="row p-3">
                <div class="col-4">
                    <div class="form-group">
                        <label for="name">Имя</label>
                        <input type="text" id="name" class="form-control"
                               value="{{ $good?->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="user">Цена</label>
                        <input type="text" id="user" class="form-control"
                               value="{{ $good?->price }}" disabled>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="user">Категория</label>
                        <input type="text" id="user" class="form-control"
                               value="{{ $good?->category?->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="user">Количество</label>
                        <input type="text" id="user" class="form-control"
                               value="{{ $good?->amount }}" disabled>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group">
                        <label for="user">Бренд</label>
                        <input type="text" id="user" class="form-control"
                               value="{{ $good?->brand?->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="user">Скидка</label>
                        <input type="text" id="user" class="form-control"
                               value="{{ $good?->sale }}" disabled>
                    </div>
                </div>

                <div class="col-7">
                    <label for="user">Полное описание</label>
                    <textarea class="form-control" rows="5"
                              disabled>@foreach(json_decode($good->full_description) as $item) @foreach($item as $key => $value){{ $key }}: {{ $value . "\n" }}@endforeach @endforeach
                    </textarea>
                </div>
            </div>
        </div>

        @if(isset($good->images))
            @foreach($good->images as $good_img)
                <img src="{{ $good_img?->image }}" width="200px" height="200px" alt="">
                @if($good_img->is_main)
                    <p>main</p>
                @endif
            @endforeach
        @endif
    </div>

@endsection
