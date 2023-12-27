@extends('layouts.app')
@section('title')
    Login
@endsection
@section('login')
    <div class="d-flex align-items-center justify-content-center my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                <div class="col mx-auto" style="margin-top: 100px;">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show mt-3">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class="bx bxs-message-square-x"></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Ошибка!</h6>
                                    <div class="text-white">Пароль или логин неправилно!</div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="my-4 text-center">
                        <h4>RIZO</h4>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h3 class="">Вход</h3>
                                </div>
                                <div class="form-body">
                                    <form class="row g-3" action="{{ route('login') }}" method="POST">
                                        @csrf
                                        <div class="col-12">
                                            <label for="inputEmailAddress" class="form-label">E-mail</label>
                                            <input type="email" class="form-control" id="inputEmailAddress" placeholder="Введите email" name="email">
                                        </div>
                                        <div class="col-12">
                                            <label for="inputChoosePassword" class="form-label">Пароль</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" class="form-control border-end-0" id="inputChoosePassword" placeholder="Введите пароль" name="password">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-outline-primary"><i class="bx bx-user"></i>Вход</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>

@endsection
