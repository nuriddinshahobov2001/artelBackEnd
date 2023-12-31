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
        <a href="{{ route('image.get') }}" class="btn btn-outline-success">
            Загрузить
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
                        <td>{{ $image->good?->name }}</td>
                        <td><img src="{{ $image->image }}" alt="" width="50"></td>
                        <td>
                            <a href="#" role="button" class="btn btn-danger"
                               data-bs-toggle="modal" data-bs-target="#deleteImage{{ $image->id }}"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>

                    <div class="modal fade" id="deleteImage{{ $image->id }}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление картики</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('image.destroy', $image->id) }}" method="POST">
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
            {{ $images->links() }}
        </div>
    </section>
@endsection
