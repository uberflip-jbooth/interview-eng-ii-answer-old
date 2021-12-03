<x-layout>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>State/Province</th>
                <th>Country</th>
                <th>Alpha-2-Code</th>
                <th>Domains</th>
                <th>Web Pages</th>
            </tr>
        </thead>
        <tfoot>
            <tr><td colspan="6">{{ $universities->links() }}</td></tr>
        </tfoot>
        <tbody>
        @foreach($universities as $university)
        {{ $university }}
            <tr>
                <td>{{ $university['name'] }}</td>
                <td>{{ $university['state-province'] }}</td>
                <td>{{ $university['country'] }}</td>
                <td>{{ $university['alpha_two_code'] }}</td>
                <td>{{ 1 /*implode('<br/>', $university['domains'])*/ }}</td>
                <td>{{ 1 /*implode('<br/>', $university['web_pages'])*/ }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout>