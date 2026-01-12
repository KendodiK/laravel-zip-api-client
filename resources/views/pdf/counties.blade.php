@extends('pdf')

@section('content')
    <br>
    <table class="center">
        <thead>
        <tr>
            <th class="header" colspan="2">Megyék</th>
        </tr>
        <tr>
            <th>#</th>
            <th class="search-field">Megnevezés</th>
        </tr>
        </thead>
        <tbody>
        <!--
        az $entities változót a kontroller exportPdf metódusban adtuk át
        ebben a sorban:
        $pdf = Pdf::loadView('pdf.counties', ['entities' => $counties]);
        -->
        @foreach($entities as $entity)
            @if($loop->iteration % 2 == 0)
                <tr class="even">
            @else
                <tr class="odd">
                    @endif
                    <td> {{$entity->id}}</td>
                    <td>{{$entity->name}}</td>
                </tr>
                @endforeach
        </tbody>
    </table>
@endsection
