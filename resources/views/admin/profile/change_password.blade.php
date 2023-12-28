@extends('layouts.app')

@section('content')
    <!-- Кнопка-триггер модального окна -->
    <button type="button" class="btn btn-outline-primary w-25" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Изменить пароль
    </button>

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

    <!-- Модальное окно -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменение пароля</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('change_password.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="oldPassword">Старый пароль <span class="text-danger">*</span></label>
                                        <input type="password" name="oldPassword" id="oldPassword" class="form-control" placeholder="Введите старый пароль">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Новый пароль <span class="text-danger">*</span></label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Введите новый пароль">
                                    </div>
                                    <div class="form-group">
                                        <label for="password_confirmation">Повторите пароль <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Повторите новый пароль">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                            <button type="submit" class="btn btn-primary">Изменить</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
