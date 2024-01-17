@extends('layouts.app')

@section('content')
    <section>
        <div>
            <div class="col-md-3">
                <a id="excel" href="{{route('excel')}}"  class="btn btn-success">Экспорт в Excel</a>
            </div>

            <table id="table" class="table">
                <thead>
                <th>#</th>
                <th>Имя</th>
                <th>Категория</th>
                <th>Цена</th>
                <th colspan="2" class="text-center">Действие</th>
                </thead>
                <tbody>
                @foreach($goods as $good)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $good->name }}</td>
                        <td>{{ $good->category?->name }}</td>
                        <td>{{ $good->price }}</td>
                        <td>
                            <a href="{{ route('showGoodsWithDefects', $good->slug) }}" class="btn btn-primary">
                                Посмотреть
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
{{--            {{ $goods->links() }}--}}
        </div>
    </section>
@endsection
`
