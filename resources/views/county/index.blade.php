@extends('layouts.layout')
@section('content')
    <h1>Városok</h1>
    <form action="{{ route('counties.export.pdf') }}" method="get">
        <input type="submit" value="PDF">
    </form>
    <form action="{{ route('counties.export.csv') }}" method="get">
        <input type="submit" value="CSV">
    </form>
    <table>
        <tbody>
        <tr>
            <th>Megye neve</th>
            <th></th>
            <th></th>
        </tr>
        @if(Session::has('user_name'))
            <tr>
                <form action="{{route('counties.store')}}" method="post">
                    @csrf
                    <th>
                        <input type="text" name="name">
                    </th>
                    <th></th>
                    <th>
                        <input type="submit" value="Új hozzáadása">
                    </th>
                </form>
            </tr>
        @endif
        @foreach($counties as $county)
            <tr>
                <td>{{$county->name}}</td>
                <td>
                    @if(Session::has('user_name'))
                        <form action="{{route('counties.show', $county->id)}}" method="get">
                            <input type="submit" value="módosítás">
                        </form>
                    @endif
                </td>
                <td>
                    @if(Session::has('user_name'))
                        <form action="{{route('counties.destroy', $county->id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <input type="submit" value="törlés">
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
