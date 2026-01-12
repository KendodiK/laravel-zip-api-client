@extends('layouts.layout')
@section('content')
    <table>
        <tr>
            <th>Városnév</th>
            <th>ZIP code</th>
            <th>Megye Id</th>
            <th></th>
        </tr>
        <tr>
            <form action="{{ route('cities.update', $entity->id) }}" method="post">
                @method('PUT')
                @csrf
                <td>
                    <input type="text" name="name" value="{{$entity->name}}">
                </td>
                <td>
                    <input type="number" name="postalCode" value="{{$entity->postalCode}}">
                </td>
                <td>
                    <input type="number" readonly name="countyId" value="{{$entity->countyId}}">
                </td>
                <td>
                    <input type="submit" value="módosítás">
                </td>
            </form>
        </tr>
    </table>
@endsection
