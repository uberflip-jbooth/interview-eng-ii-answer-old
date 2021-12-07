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
            <!-- Pagination -->
            <tr><td colspan="6">{{ $universities->links() }}</td></tr>
        </tfoot>
        <tbody>
        @foreach($universities as $university)
            {{-- Add a background colour for universities with >1 domain --}}
            <tr
            @if(count($university->domains) > 1)
                class="bg-blue-100"
            @endif
            >
                <td>{{ $university['name'] }}</td>
                <td>{{ $university['state-province'] }}</td>
                <td>{{ $university['country'] }}</td>
                <td>{{ $university['alpha_two_code'] }}</td>
                <td>
                    @foreach($university->domains as $domain)
                        {{ $domain['domain_name'] }}<br/>
                    @endforeach
                </td>
                <td>
                    @foreach($university->webpages as $webpage)
                        <a href="{{ $webpage['url'] }}">{{ $webpage['url'] }}</a><br/>
                    @endforeach
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</x-layout>