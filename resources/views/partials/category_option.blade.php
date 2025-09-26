<option value="{{ $category->id }}" 
        data-color="{{ $category->color }}"
        class="category-option"
        style="background-color: {{ $category->color }}20; 
               color: {{ $category->color }};
               border-left: 4px solid {{ $category->color }};
               padding: 8px 12px;
               margin: 2px 0;
               border-radius: 4px;
               font-weight: 500;">
    <span class="category-dot" style="background-color: {{ $category->color }}"></span>
    {{ $category->name }}
</option>

<style>
    .category-option {
        position: relative;
        transition: all 0.2s ease;
    }
    
    .category-option:hover {
        transform: translateX(4px);
        background-color: {{ $category->color }}40 !important;
    }
    
    .category-dot {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
    }
    
    select option:checked {
        background: linear-gradient(135deg, {{ $category->color }}20 0%, {{ $category->color }}40 100%);
        font-weight: 600;
    }
</style>