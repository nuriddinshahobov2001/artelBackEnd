@extends('layouts.app')

@section('content')
    <section>
        <div>
            <a onclick="history.back()" class="btn btn-outline-danger">Назад</a>
            @if($goods[0]->status_id == 1)
                <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#acceptOrder">Завершить</a>
            @endif

            @if($goods[0]->status_id == 1 || $goods[0]->status_id == 2)
               <a href="#" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectOrder">Отклонить</a>
            @endif
        </div>
        <div>
            <table class="table">
                <thead>
                <th>#</th>
                <th>Название товара</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Скидка</th>
                </thead>
                <tbody>
                @foreach ($goods as $good)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $good->name }}</td>
                        <td>{{$good->count}}</td>
                        <td>{{$good->price}}</td>
                        <td>{{$good->sale}}</td>
                        <td>

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div class="modal fade" id="acceptOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Одобрение заказа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <form action="{{route('orders.completeOrder', $goods[0]->order_code)}}" method="POST">
                    @csrf

                    <div class="modal-body">
                        Вы уверены что хотите одобрить заказ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-primary">Одобрить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="rejectOrder" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Одобрение заказа</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <form action="{{route('orders.rejectOrder',  $goods[0]->order_code)}}" method="POST">
                    @csrf

                    <div class="modal-body">
                        Вы уверены что хотите отменить заказ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                        <button type="submit" class="btn btn-danger">Отклонить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

