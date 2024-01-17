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
            <a href="" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addSlider"
            >Добавить</a>
            <table class="table">
                <thead>
                <th>#</th>
                <th>Картинка</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @foreach($sliders as $slider)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><img src="{{ \Illuminate\Support\Facades\Storage::url($slider->image) }}" alt="" width="100"></td>
                        <td>
                            <a href="#" role="button" class="btn btn-danger"
                               data-bs-toggle="modal" data-bs-target="#deleteSlider{{ $slider->id }}"><i
                                    class="bi bi-trash"></i></a>
                        </td>
                    </tr>
                    <div class="modal fade" id="deleteSlider{{ $slider->id }}" tabindex="-1"
                         aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Удаление слайдера</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Закрыть"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('sliders_and_banners.destroy', $slider->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <input type="hidden" name="image" value="{{ $slider->image }}">
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
    <div class="modal fade" id="addSlider" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление слайдера</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <form action="{{ route('sliders_and_banners.add_slider') }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <label for="image">Выберите изображение</label>
                        <input type="file" class="form-control" name="image">
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
