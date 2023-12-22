@extends('layouts.app')

@section('content')
    <section>
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

        <a href="{{ route('good.get') }}" class="btn btn-outline-success">
            Загрузить
        </a>
        <div class="col-12">
            <table class="table">
                <thead>
                <th>#</th>
                <th>Имя</th>
                <th>Описание</th>
                <th>Цена</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @foreach($goods as $good)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $good->name }}</td>
                        <td>{{ Str::limit($good->description, 50) }}</td>
                        <td>{{ $good->price }}</td>
                        <td width="200px">
                            <a href="{{ route('good.show', $good->id) }}" class="btn btn-warning">
                                <i class="bi bi-eye"></i>
                            </a>
                            <a href="#" role="button" class="btn btn-danger"
                               data-bs-toggle="modal" data-bs-target="#deleteGood{{ $good->id }}">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="deleteGood{{ $good->id }}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление товара</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('good.destroy', $good->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <p>Вы точно хотите удалить?</p>
                                        <hr>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Нет
                                            </button>
                                            <button type="submit" class="btn btn-primary">Да</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection
