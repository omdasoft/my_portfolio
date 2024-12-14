@props(['name', 'class' => ''])

<button {{ $attributes->merge(['class' => 'bg-gray-200 hover:bg-gray-300 text-gray-600 font-bold py-2 px-4 rounded inline-flex items-center ' . $class]) }}>
    <span>{{ $name }}</span>
</button>