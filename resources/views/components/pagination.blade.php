@props(['collection'])
<div class="py-4 px-4">
    @if ($collection)
        <div>
            {{ $collection->links() }}
        </div>
    @endif
</div>