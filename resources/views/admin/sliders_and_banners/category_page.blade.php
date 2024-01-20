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
        <div>
            <a href="" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addCategoryPage"
            >Добавить</a>
            <table class="table">
                <thead>
                <th>#</th>
                <th>Картинка</th>
                <th>Тип</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @foreach($images as $image)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::url($image->image) }}" alt="" width="100">
                        </td>
                        <td>
                            @if($image->type == 2)
                                Акционные
                            @elseif($image->type == 3)
                                Хит продаж
                            @elseif($image->type == 4)
                                Сезонные товары
                            @else Не указано
                            @endif
                        </td>
                        <td>
                            <a href="#" role="button" class="btn btn-danger"
                               data-bs-toggle="modal" data-bs-target="#deleteBanner{{ $image->id }}"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <div class="modal fade" id="deleteBanner{{ $image->id }}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление слайдера</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('sliders_and_banners.destroy', $image->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="image" value="{{ $image->image }}">
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
    <div class="modal fade" id="addCategoryPage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление баннера</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <form action="{{ route('sliders_and_banners.add_category_page') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="image">Выберите изображение</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
