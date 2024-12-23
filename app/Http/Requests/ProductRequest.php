<?php

namespace App\Http\Requests;

use App\Rules\CurrentPasswordCheckRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'serial_number'=> 'required',
            'name'=> 'required',
            'description'=> 'required',
            'product_category_id'=> 'required',
            'unit_cost'=> 'required',
            'price'=> 'required',
            'stock'=> 'required',
            'stock_defective'=> 'required',
            'image_url' => 'required|image|mimes:jpeg,png,jpg|max:20480'
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
        ];
    }

    protected function prepareForValidation()
    {
        // You can cast the request data here if necessary
        $this->merge([
            'product_category_id' => (int) $this->product_category_id,
            'unit_cost' => (float) $this->unit_cost,
            'product_price' => (float) $this->product_price,
            'price' => (float) $this->price,
            'stock' => (int) $this->stock,
            'stock_defective' => (int) $this->stock_defective, // Cast to float
        ]);
    }
}
