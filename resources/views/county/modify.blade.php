<table>
    <tbody>
    <tr>
        <th>Megye neve</th>
        <th></th>
        <th></th>
    </tr>
    <tr>
        <form action="{{route('counties.update')}}" method="post">
            @csrf
            <th>
                <input type="text" value="{{ $county['name'] }}" name="name">
            </th>
            <th></th>
            <th>
                <input type="submit" value="mentés">
            </th>
        </form>
    </tr>
    </tbody>
</table>
