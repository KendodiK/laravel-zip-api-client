@extends('layouts.layout')
@section('content')
    <h1>Városok</h1>
    <table>
        <tbody>
        <tr>
            <th>Városnév</th>
            <th>ZIP code</th>
            <th>Megye</th>
            <th>módosítás</th>
            <th>törlés</th>
        </tr>
        @foreach($cities as $citi)
            <tr>
                <td>{{$citi['name']}}</td>
                <td>{{$citi['postalCode']}}</td>
                <td>{{$citi['countyId']}}</td>
                <td>
                    <form action="{{route('cities.update', $citi['id'])}}" method="post">
                        <input type="submit" value="módosítás">
                    </form>
                </td>
                <td>
                    <form action="{{route('cities.destroy', $citi['id'])}}" method="post">
                        <input type="submit" value="törlés">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
