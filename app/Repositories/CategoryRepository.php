<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Admin\Category;
use App\Traits\CommonHelperTrait;

class CategoryRepository implements CategoryInterface
{
    use CommonHelperTrait;

    public function all()
    {
        return Category::all();
    }

    public function store($data)
    {

        $categories = new Category();
        $categories->create($data);
        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    public function update($data, $category)
    {
        return $category->update($data);
    }

    public function destroy($category)
    {
        return $category->delete();
    }
}
