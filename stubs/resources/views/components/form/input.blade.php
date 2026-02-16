<div class="form-group mb-3">
    @if($label)
    <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" {{ $attributes->merge(['class' => 'form-control']) }} />
</div>
