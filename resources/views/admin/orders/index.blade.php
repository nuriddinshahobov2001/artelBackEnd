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

      <h2>Список заказов</h2>
        <div class="col-12">
            <table class="table">
                <thead>
                <th>#</th>
                <th>Дата создания</th>
                <th>Номер заказа</th>
                <th>Телефон заказчика</th>
                <th>Адрес доставки</th>
                <th>Статус</th>
                <th>Действие</th>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->created_at }}</td>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->address }}</td>
                        @if($order->status == "На рассмотрение")
                        <td>
                            <button class="btn btn-warning">{{$order->status}}</button>
                        </td>
                        @elseif($order->status == "Завершено")
                            <td>
                                <button class="btn btn-success">{{$order->status}}</button>
                            </td>
                        @elseif($order->status == "Отклонен")
                            <td>
                                <button class="btn btn-danger">{{$order->status}}</button>
                            </td>
                        @endif

                        <td>
                            <a href="{{ route('orders.show', $order->order_code) }}" class="btn btn-primary">
                                Подробнее...
                            </a>
                        </td>
                    </tr>

                @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection
