<x-table-column>
    <x-shopper.status :shopper="$shopper"/>
</x-table-column>

<x-table-column>
    {{ $shopper['first_name'] }} {{ $shopper['last_name'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['email'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['check_in'] }}
</x-table-column>

<x-table-column>
    {{ $shopper['check_out'] }}
</x-table-column>
@if(\Auth::user())
    <x-table-column>
  @if($shopper['status_id']==1 )
        <a href="{{ route('store.markAsComplete', ['shopperUuid' => $shopper['uuid']]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"> Complete</a>
  @endif
</x-table-column>
@endif


{{--<x-table-column>--}}

{{--</x-table-column>--}}
