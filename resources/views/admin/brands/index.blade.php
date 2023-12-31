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
            <a href="{{ route('brands.get') }}" class="btn btn-outline-success">
                Загрузить
            </a>
        <div>
            <table class="table">
                <thead>
                <th>#</th>
                <th>Имя</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @foreach($brands as $brand)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $brand->name }}</td>
                        <td>
                            <a href="#" role="button" class="btn btn-danger"
                               data-bs-toggle="modal" data-bs-target="#deleteBrand{{ $brand->id }}">
                                <i class="bi bi-trash"></i>
                            </a>
                        </td>
                    </tr>

                    <div class="modal fade" id="deleteBrand{{ $brand->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление бренда</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <p>Вы точно хотите удалить?</p>
                                        <hr>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Нет</button>
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



<div class="modal fade" id="addBrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавление бренда</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('brands.store') }}" method="POST">
                    @csrf

                    <label for="name">Имя</label>
                    <input type="text" name="name" class="form-control">
                    <br>
                    <div class="float-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
