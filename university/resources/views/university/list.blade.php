<x-layout>
    @foreach($universities as $university)
        <tr><td>{{ $university->name }}</td></tr>
    @endforeach
</x-layout>