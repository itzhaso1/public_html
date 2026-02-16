<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource {
    public function toArray($request) {
        return [
            'slug' => $this->slug,
            'category_name' => $this->category ? $this->category->translate('ar')->name ?? null : null,
            'type_name' => $this->type ? $this->type->translate('ar')->name ?? null : null,
            'price_before_discount' => $this->price_before_discount,
            'price' => $this->price,
            'stock' => $this->stock,
            'sku' => $this->sku,
            'erp_id' => $this->erp_id,
            'product_name_ar' => $this->translate('ar')->name ?? null,
            'product_name_en' => $this->translate('en')->name ?? null,
        ];
    }
}