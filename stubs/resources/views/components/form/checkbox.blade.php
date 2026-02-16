<div class="form-check mb-3">
    <input type="checkbox" name="{{ $name }}" id="{{ $id }}" class="form-check-input {{ $class }}" value="1" {{ $checked
        ? 'checked' : '' }}>
    <label class="form-check-label" for="{{ $id }}">{{ $label }}</label>
</div>
