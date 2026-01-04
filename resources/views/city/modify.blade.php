<table>
    <tr>
        <th>Városnév</th>
        <th>ZIP code</th>
        <th>Megye Id</th>
        <th></th>
    </tr>
    <tr>
        <form action="{{ route('cities.update') }}" method="post">
            @method('POST')
            @csrf
            <td>
                <input type="text" name="name" value="{{$entity['name']}}">
            </td>
            <td>
                <input type="number" name="postalCode" value="{{$entity['postalCode']}}">
            </td>
            <td>
                <input type="hidden" name="countyId" value="{{$entity['countyId']}}">
            </td>
            <td>
                <input type="submit" value="módosítás">
            </td>
        </form>
    </tr>
</table>
