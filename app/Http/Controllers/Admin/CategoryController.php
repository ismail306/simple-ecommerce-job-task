<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Interfaces\CategoryInterface;
use App\Http\Requests\CategoryUpdateRequest;
use App\Models\Admin\Category;



class CategoryController extends Controller
{

    protected $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index()
    {
        $categories = $this->categoryRepository->all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }


    public function store(CategoryStoreRequest $request)
    {

        $data = $request->all();
        return $this->categoryRepository->store($data);
    }

    public function show(Category $category)
    {
        //

    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(CategoryUpdateRequest $request, Category $category)
    {
        //dd($request->all());
        $this->categoryRepository->update($request->all(), $category);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully');
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->destroy( $category);
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
    }
}
