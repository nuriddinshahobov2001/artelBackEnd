@extends('layouts.app')

@section('content')
    <section>
        @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissible show fade">
                {{ \Session::get('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <a href="#" role="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addImage">
            Добавить
        </a>
        <div>
            <table class="table">
                <thead>
                <th>#</th>
                <th>Товар</th>
                <th>Картинка</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $image->good->name }}</td>
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::url($image->image) }}" alt="" width="50"></td>
                        <td>
                            <a href="#" role="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editImage{{ $image->id }}">Изменить</a>
                            <a href="#" role="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteImage{{ $image->id }}">Удалить</a>
                        </td>
                    </tr>

                    <div class="modal fade" id="editImage{{ $image->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Изменение категории</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('image.update', $image->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <label for="name">Имя</label>
                                        <select name="good_id" class="form-control" id="">
                                            @foreach($goods as $good)
                                                <option value="{{ $good->id }}" {{ $image->good_id === $good->id ? 'selected' : '' }}>{{ $good->name }}</option>
                                            @endforeach
                                        </select>

                                        <label for="name">Выберите картинку</label>
                                        <input type="file" name="image" class="form-control">

                                        <br>
                                        <div class="float-end">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                            <button type="submit" class="btn btn-primary">Изменить</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteImage{{ $image->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление картики</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('image.destroy', $image->id) }}" method="POST">
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

    <div class="modal fade" id="addImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление категории</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('image.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div>
                            <label for="name">Имя</label>
                            <select name="good_id" id="" class="form-control">
                                @foreach($goods as $good)
                                    <option value="{{ $good->id }}">{{ $good->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="name">Выберите картинку</label>
                            <input type="file" name="image" class="form-control">
                        </div>
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
