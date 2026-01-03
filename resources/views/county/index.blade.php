@extends('layouts.layout')
@section('content')
    <h1>Városok</h1>
    <table>
        <tbody>
        <tr>
            <th>Megye neve</th>
            <th></th>
            <th></th>
        </tr>
        <tr>
            <form action="{{route('counties.store')}}" method="post">
                <th>
                    <input type="text" name="name">
                </th>
                <th></th>
                <th>
                    <input type="submit" value="Új hozzáadása">
                </th>
            </form>
        </tr>
        @foreach($counties as $county)
            <tr>
                <td>{{$county['name']}}</td>
                <td>
                    <form action="{{route('counties.update', $county['id'])}}" method="post">
                        @method('PUT')
                        <input type="submit" value="módosítás">
                    </form>
                </td>
                <td>
                    <form action="{{route('counties.destroy', $county['id'])}}" method="post">
                        @method('DELETE')
                        <input type="submit" value="törlés">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
