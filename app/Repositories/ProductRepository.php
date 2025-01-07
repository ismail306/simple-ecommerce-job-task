<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Traits\CommonHelperTrait;
use Illuminate\Support\Facades\Log;

class ProductRepository implements ProductInterface
{
    use CommonHelperTrait;

    public function all()
    {
        return Category::all();
    }

    public function store($data)
    {
        try {
            // Create the product
            $data['category_id'] = $data['category'];
            $product = Product::create($data);

            $path = 'storage/images/product-images';

            if (isset($data['variants']) && is_array($data['variants'])) {
                foreach ($data['variants'] as $variant) {
                    // store the variant image and create the variant
                    $filename = isset($variant['image']) ? $this->storeImage($path, $variant['image']) : null;
                    $product->variants()->create([
                        'name' => $variant['name'],
                        'price' => $variant['price'],
                        'image' => $filename,
                    ]);
                }
            }

            return redirect()->route('products.index')->with('success', 'Product created successfully');
        } catch (\Exception $e) {
            Log::error('Error creating product or variant: ' . $e->getMessage());

            return redirect()->route('products.index')->with('error', 'Product created successfully, but there was an issue with variants');
        }
    }


    public function update($data, $product)
    {
        // dd($data);
        // Update basic product details
        $product->update([
            'name' => $data['name'],
            'category_id' => $data['category'],
        ]);

        // Define the image path
        $path = 'storage/images/product-images';

        // Process variants
        if (isset($data['variants']) && is_array($data['variants'])) {
            foreach ($data['variants'] as $key => $variant) {
                // Check if the variant exists (for updates)
                if (isset($variant['id'])) {
                    $existingVariant = $product->variants()->find($variant['id']);
                    // dd($variant['image']);
                    if ($existingVariant) {
                        // Update image using updateImage function
                        $filename = isset($variant['image']) && $variant['image'] ? $this->updateImage($path, $variant['image'], $existingVariant->image)
                            : $existingVariant->image;
                        // dd($filename);
                        // Update the existing variant
                        $existingVariant->update([
                            'name' => $variant['name'],
                            'price' => $variant['price'],
                            'image' => $filename,
                        ]);
                    }
                } else {
                    // New variant
                    $filename = isset($variant['image']) && $variant['image'] ? $this->storeImage($path, $variant['image'])
                        : null;

                    $product->variants()->create([
                        'name' => $variant['name'],
                        'price' => $variant['price'],
                        'image' => $filename,
                    ]);
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }



    public function show($product) {}


    public function destroy($product)
    {
        return $product->delete();
    }
}
