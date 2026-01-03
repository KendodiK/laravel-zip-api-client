@extends('layouts.layout')
@section('content')
    <h1>Városok</h1>
    <p>Vállasz megyét:</p>
    <form action="{{route('cities.getAbc')}}">
        <select name="county">
            @foreach(Session::get('counties') as $county)
                @if(Session::get('selectedCounty') == $county['id'])
                    <option value="{{$county['id']}}" selected>{{$county['name']}}</option>
                @else
                    <option value="{{$county['id']}}">{{$county['name']}}</option>
                @endif
            @endforeach
        </select>
        <input type="submit" value="Mutasd!">
    </form>
    @if(Session::has('abc'))
        <div style="display: flex; flex-direction: row;">
            @foreach(Session::get('abc') as $char)
                <form action="{{ route('cities.showByCharAndCounty', $char) }}">
                    <input type="submit" value="{{$char}}">
                </form>
            @endforeach
        </div>
    @endif
    @if(isset($cities))
        <table>
            <tbody>
            <tr>
                <th>Városnév</th>
                <th>ZIP code</th>
                <th>módosítás</th>
                <th>törlés</th>
            </tr>
            @foreach($cities as $citi)
                <tr>
                    <td>{{$citi['name']}}</td>
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
    @endif
@endsection
