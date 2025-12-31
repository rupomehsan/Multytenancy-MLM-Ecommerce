<style>
    .pos-modern-search {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .pos-search-box {
        flex: 1;
        min-width: 200px;
        position: relative;
    }

    .pos-search-input {
        width: 100%;
        height: 42px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0 45px 0 15px;
        font-size: 14px;
        transition: all 0.3s;
    }

    .pos-search-input:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .pos-search-icon {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #667eea;
        font-size: 16px;
        pointer-events: none;
    }

    .pos-filter-select {
        flex: 0 0 180px;
        height: 42px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 0 35px 0 15px;
        font-size: 14px;
        background: white;
        cursor: pointer;
        transition: all 0.3s;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23667eea' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 12px center;
    }

    .pos-filter-select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    }

    .pos-refresh-btn {
        flex: 0 0 42px;
        height: 42px;
        border: 2px solid #667eea;
        border-radius: 8px;
        background: white;
        color: #667eea;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        transition: all 0.3s;
    }

    .pos-refresh-btn:hover {
        background: #667eea;
        color: white;
        transform: rotate(180deg);
    }

    @media (max-width: 768px) {
        .pos-filter-select {
            flex: 1 1 calc(50% - 5px);
        }
    }
</style>

<div class="pos-modern-search">
    <div class="pos-search-box">
        <input type="text" id="search_keyword" class="pos-search-input" onkeyup="liveSearchProduct()"
            placeholder="🔍 Search products..." />
        <i class="fa fa-search pos-search-icon"></i>
    </div>

    <select class="pos-filter-select" id="product_category_id" onchange="liveSearchProduct()">
        <option value="">-All Categories-</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>

    <select class="pos-filter-select" id="product_brand_id" onchange="liveSearchProduct()">
        <option value="">-All Brands-</option>
        @foreach ($brands as $brand)
            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
        @endforeach
    </select>

    <button type="button" class="pos-refresh-btn" onclick="resetFilters()" title="Reset Filters">
        <i class="fas fa-sync-alt"></i>
    </button>
</div>

<script>
    function resetFilters() {
        document.getElementById('search_keyword').value = '';
        document.getElementById('product_category_id').value = '';
        document.getElementById('product_brand_id').value = '';
        liveSearchProduct();
    }
</script>
