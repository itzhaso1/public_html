{{ dd($action) }}
<x-form.form :action="$action" :method="$method" :enctype="$enctype">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <x-form.input name="code" label="Coupon Code" type="text" />
        </div>
        <div class="col-md-6">
            <x-form.select name="type" label="Type" :options="['fixed' => 'Fixed', 'percentage' => 'Percentage']" />
        </div>

        <div class="col-md-6">
            <x-form.input type="number" name="value" label="Value" />
        </div>
        <div class="col-md-6">
            <x-form.input type="number" name="min_spend" label="Minimum Spend" />
        </div>

        <div class="col-md-6">
            <x-form.input type="number" name="max_spend" label="Maximum Spend" />
        </div>
        <div class="col-md-6">
            <x-form.input type="date" name="starts_at" label="Starts At" />
        </div>

        <div class="col-md-6">
            <x-form.input type="date" name="expires_at" label="Expires At" />
        </div>
        <div class="col-md-6">
            <x-form.select name="status" label="Status" :options="['active' => 'Active', 'inactive' => 'Inactive']" />
        </div>

        <div class="col-md-6">
            <x-form.select name="products" label="Applicable Products" :options="$products"
                :value="old('products', $selectedProducts ?? [])" multiple />
        </div>
        <div class="col-md-6">
            <x-form.select name="excluded_products" label="Excluded Products" :options="$products"
                :value="old('excluded_products', $excludedProducts ?? [])" multiple />
        </div>

        <div class="col-md-6">
            <x-form.select name="categories" label="Applicable Categories" :options="$categories"
                :value="old('categories', $selectedCategories ?? [])" multiple />
        </div>
        <div class="col-md-6">
            <x-form.select name="excluded_categories" label="Excluded Categories" :options="$categories"
                :value="old('excluded_categories', $excludedCategories ?? [])" multiple />
        </div>
    </div>

    <div class="mt-4">
        <button type="submit" class="btn btn-primary w-100">Save Coupon</button>
    </div>
</x-form.form>
