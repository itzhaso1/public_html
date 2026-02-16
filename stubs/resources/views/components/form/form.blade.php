@props(['action' => '', 'method' => 'POST', 'enctype' => null])
<form method="{{ $method !== 'GET' ? 'POST' : 'GET' }}"
      action="{{ $action }}"
      @if($enctype) enctype="{{ $enctype }}" @endif>

    @csrf
    @if($method !== 'GET' && $method !== 'POST')
        @method($method)
    @endif

    {{ $slot }}
</form>
