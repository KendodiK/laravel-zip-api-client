@extends('layouts.layout')
@section('content')
    <h1>Városok</h1>
    <p>Vállasz megyét:</p>
    <form action="{{route('cities.getAbc')}}">
        <select name="county">
            @if(Session::has('counties'))
                @foreach(Session::get('counties') as $county)
                    @if(Session::get('selectedCounty') == $county['id'])
                        <option value="{{$county['id']}}" selected>{{$county['name']}} ({{ $county['id'] }})</option>
                    @else
                        <option value="{{$county['id']}}">{{$county['name']}} ({{ $county['id'] }})</option>
                    @endif
                @endforeach
            @endif
        </select>
        <input type="submit" value="Mutasd!">
    </form>
    @if(Session::has('abc'))
        <table>
            <tr>
                <th>Városnév</th>
                <th>ZIP code</th>
                <th>Megye Id</th>
                <th></th>
            </tr>
            <tr>
                <form action="{{ route('cities.store') }}" method="post">
                    @method('POST')
                    @csrf
                    <td>
                        <input type="text" name="name">
                    </td>
                    <td>
                        <input type="number" name="postalCode">
                    </td>
                    <td>
                        {{ $selectedCounty = Session::get('selectedCounty') }}
                        <input type="hidden" value="{{ $selectedCounty }}">
                    </td>
                    <td>
                        <input type="submit" value="hozzáadás">
                    </td>
                </form>
            </tr>
        </table>
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
                <th></th>
                <th></th>
            </tr>
            @foreach($cities as $citi)
                <tr>
                    <td>{{$citi['name']}}</td>
                    <td>{{$citi['postalCode']}}</td>
                    <td>
                        <form action="{{route('cities.update', $citi['id'])}}" method="post">
                            <input type="submit" value="módosítás">
                        </form>
                    </td>
                    <td>
                        <form action="{{route('cities.destroy', $citi['id'])}}" method="post">
                            <input type="submit" value="törlés">
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection
