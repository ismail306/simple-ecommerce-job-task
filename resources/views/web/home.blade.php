<x-web.layouts.master>
    <div class="container mt-5">
        <h2 class="mb-4">Available Products</h2>
        <div class="row">
            @forelse ($products as $product)
            @foreach ($product->options as $option)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="card-title text-truncate">{{ $option->name }}</h6>
                        <img src="{{ asset('storage/images/product-images/' . $option->image) }}"
                            alt="{{ $option->name }}"
                            class="img-fluid mt-2"
                            style="max-height: 150px;">
                        <p class="mt-2">
                            <strong>Price:</strong> ${{ number_format($option->price, 2) }}
                        </p>
                        <button class="btn btn-success btn-sm add-to-cart"
                            data-product-id="{{ $product->id }}"
                            data-option-id="{{ $option->id }}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
            @empty
            <div class="col-12">
                <p class="text-center">No products available</p>
            </div>
            @endforelse
        </div>



        <!-- Cart Summary -->
        <div class="mt-5">
            <h3>Cart Summary</h3>
            <ul id="cart-items" class="list-group">
                <!-- Cart items will be dynamically updated -->
            </ul>
        </div>
    </div>


</x-web.layouts.master>