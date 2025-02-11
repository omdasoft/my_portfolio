<div>
    <x-slot:title>
        Portfolio List
    </x-slot:title>
    
    @section('header')
        <livewire:frontend.includes.blog-nav />
    @endsection

    <x-portfolio-list :portfolios="$portfolios" name="My Projects"/>
    <x-pagination :collection="$portfolios"/>
</div>
