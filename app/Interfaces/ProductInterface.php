<?php

namespace App\Interfaces;

interface ProductInterface
{

    public function all();
    public function store(array $data);
    public function show($product);
    public function update(array $data, $product);
    public function destroy( $product);
}
