<?php

namespace App\Interfaces;

interface CartInterface
{
    public function store(array $data);
    public function show(array $data);
    public function destroy($cart);
}
