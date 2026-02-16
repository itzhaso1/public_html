<div class="form-group">
    @if($label)
    <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <select name="{{ $multiple ? $name . '[]' : $name }}" id="{{ $name }}" {{ $attributes->merge(['class' => 'form-control']) }} {{ $multiple
        ? 'multiple' : '' }}>
        @foreach($options as $optionValue => $optionLabel)
        <option value="{{ $optionValue }}" @if($multiple) {{ in_array($optionValue, (array) $value) ? 'selected' : '' }}
            @else {{ $value==$optionValue ? 'selected' : '' }} @endif>{{ $optionLabel }}</option>
        @endforeach
    </select>
</div>
