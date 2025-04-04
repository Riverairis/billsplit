<option value="{{ $category->id }}" 
        style="background-color:{{ $category->color }}; color:{{ getContrastColor($category->color) }}">
    {{ $category->name }}
</option>