<x-web.layouts.master>
    <div class="container mt-5">
        <h2 class="mb-4">Available Products</h2>
        <div class="row">
            @forelse ($products as $product)
            @foreach ($product->variants as $option)
            <div class="col-md-3 mb-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6 class="card-title text-truncate">{{ $option->name }}</h6>
                        <img src="{{ asset('storage/images/product-images/' . $option->image) }}" alt="{{ $option->name }}"
                            class="img-fluid mt-2" style="max-height: 150px;">
                        <p class="mt-2">
                            <strong>Price:</strong> ${{ number_format($option->price, 2) }}
                        </p>
                        <button class="btn btn-success btn-sm add-to-cart"
                            data-product-id="{{ $product->id }}" data-option-id="{{ $option->id }}"
                            data-price="{{ $option->price }}">
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            let sessionId = localStorage.getItem("session_id");
            if (sessionId) {
                $.ajax({
                    url: "{{ route('carts.show') }}",
                    type: "GET",
                    data: {
                        session_id: sessionId
                    },
                    success: function(response) {
                        updateCartSummary(response.data);
                    },
                    error: function(error) {
                        console.error("Error fetching cart items:", error);
                    }
                });
            }

            $(".add-to-cart").click(function() {
                let productId = $(this).data("product-id");
                let optionId = $(this).data("option-id");
                let price = $(this).data("price");
                console.log(productId, optionId, price)

                if (!sessionId) {
                    sessionId = generateSessionId();
                    localStorage.setItem("session_id", sessionId);
                }

                // Send the data via AJAX to add the item to the cart
                $.ajax({
                    url: "{{ route('carts.store') }}",
                    type: "POST",
                    data: {
                        session_id: sessionId,
                        product_id: productId,
                        product_variant_id: optionId,
                        quantity: 1,
                        _token: '{{ csrf_token() }}'
                    },

                    success: function(response) {
                        console.log(response);
                        updateCartSummary(response.data);
                        // alert("Item added to cart");
                    },
                    error: function(error) {
                        console.log(error);
                        alert("Error adding item to cart");
                    }
                });
            });

            function updateCartSummary(cartItems) {
                //console.log(cartItems);
                let cartList = $('#cart-items');
                cartList.empty();
                cartItems.forEach(item => {
                    cartList.append(`
                    <li class="list-group-item">
                        ${item.variant.name} - ${item.quantity} x $${item.price} 
                        <button class="btn btn-danger btn-sm float-right remove-from-cart" data-cart-id="${item.id}">Remove</button>
                    </li>
                `);
                });
            }

            // Remove from cart functionality
            $(document).on("click", ".remove-from-cart", function() {
                let cartId = $(this).data("cart-id");
                console.log(cartId);
                $.ajax({
                    url: "{{ route('carts.destroy', ':id') }}".replace(':id', cartId),
                    type: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        updateCartSummary(response.data);
                        //alert("Item removed from cart");
                    },
                    error: function(error) {
                        alert("Error removing item from cart");
                    }
                });
            });

            // Helper function to generate session ID if it doesn't exist
            function generateSessionId() {
                return 'session_' + new Date().getTime();
            }
        });
    </script>



</x-web.layouts.master>