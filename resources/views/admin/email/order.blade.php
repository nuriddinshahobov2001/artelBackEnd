<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rizo</title>

    <link rel="stylesheet" href="{{asset('assets/css/main/app.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main/app-dark.css')}}">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.svg')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/png">

    <link rel="stylesheet" href="{{asset('assets/css/shared/iconly.css')}}">

</head>

<body>


<h2>Номер заказа: {{ $orders[0]->order_code }}</h2>
<h3>Статус: <b>На рассмотрение</b></h3>
<h3>Телефон заказчика: <b>{{ $orders[0]->login }}</b></h3>
<h3>Адрес: <b>{{ $orders[0]->address }}</b></h3>
<div>
    <table class="table">
        <thead>
        <th>#</th>
        <th>Имя</th>
        <th>Количество</th>
        <th>Цена</th>
        </thead>
        <tbody>
        @foreach($orders as $good)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $good->good?->name }}</td>
                <td>{{ $good->count }}</td>
                <td>{{ $good->price }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>



