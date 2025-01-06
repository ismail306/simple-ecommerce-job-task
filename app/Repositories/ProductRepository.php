<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Traits\CommonHelperTrait;

class ProductRepository implements ProductInterface
{
    use CommonHelperTrait;

    public function all()
    {
        return Category::all();
    }

    public function store($data)
    {

        $data['category_id'] =  $data['category'];
        $product = Product::create($data);
        $path = 'storage/images/category-images';
        if (isset($data['options']) && is_array($data['options'])) {
            foreach ($data['options'] as $option) {
                $filename = isset($option['image']) ? $this->storeImage($path, $option['image']) : null;
                $product->options()->create([
                    'name' => $option['name'],
                    'price' => $option['price'],
                    'image' => $filename,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }

    public function update($data, $categoryId)
    {

        $category = Category::findOrFail($categoryId);

        if (isset($data['image']) && $data['image']) {
            $path = 'storage/images/category-images';
            $filename = $this->updateImage($path, $data['image'], $category->image);
            $category->image = $filename;
        }



        $category->name = $data['name'];
        $category->status = $data['status'];
        $category->description = $data['description'];
        $category->save();

        return $category;
    }

    public function show($product) {}
    public function delete($product) {}
}
