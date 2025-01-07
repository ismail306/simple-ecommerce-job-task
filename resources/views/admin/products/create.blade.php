<x-admin.layouts.master>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="text-center">Create New Product</h2>

                    <div class="card-body">
                        <form action="{{route('products.store')}}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" id="productName" name="name" class="form-control" placeholder="Enter product name" required>
                            </div>

                            <!-- Product Category -->
                            <div class="form-group">
                                <label class="control-label">Select Category</label>
                                <select class="custom-select" name="category" id="categories">
                                    <option value="" disabled selected> Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>


                                @error('category')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- variants -->
                            <div id="variants">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">Variants / Options</h5>
                                    <button type="button" id="add-variant" class="btn btn-primary">
                                        Add Variant
                                    </button>
                                </div>


                                <div class="card mb-3 variant">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <!-- Variant Name -->
                                            <div class="form-group col-md-4">
                                                <label for="variantName_0">Name</label>
                                                <input type="text" id="variantName_0" name="variants[0][name]" class="form-control" placeholder="Enter variant name" required>
                                            </div>

                                            <!-- Variant Image -->
                                            <div class="form-group col-md-4">
                                                <label for="variantImage_0">Image</label>
                                                <input type="file" id="variantImage_0" name="variants[0][image]" class="form-control" required>
                                            </div>

                                            <!-- Variant Price -->
                                            <div class="form-group col-md-3">
                                                <label for="variantPrice_0">Price</label>
                                                <input type="number" id="variantPrice_0" name="variants[0][price]" class="form-control" placeholder="Enter price" required>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="form-group col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-variant" title="Remove Variant">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success">Save Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @push('scripts')
        <script>
            $(document).ready(function() {
                let variantIndex = 1;

                // Add Variant
                $('#add-variant').click(function() {
                    $('#variants').append(`
                <div class="card mb-3 variant">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="variantName_${variantIndex}">Variant Name</label>
                                <input type="text" id="variantName_${variantIndex}" name="variants[${variantIndex}][name]" class="form-control" placeholder="Enter variant name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="variantImage_${variantIndex}">Variant Image</label>
                                <input type="file" id="variantImage_${variantIndex}" name="variants[${variantIndex}][image]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="variantPrice_${variantIndex}">Price</label>
                                <input type="number" id="variantPrice_${variantIndex}" name="variants[${variantIndex}][price]" class="form-control" placeholder="Enter price" required>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-variant" title="Remove Variant">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
                    variantIndex++;
                });

                // Remove Variant
                $(document).on('click', '.remove-variant', function() {
                    $(this).closest('.variant').remove();
                });

                // Add to Cart
                $('.add-to-cart').click(function() {
                    const variantId = $(this).data('id');
                    $.post('/cart/add', {
                        variant_id: variantId,
                        quantity: 1,
                        _token: '{{ csrf_token() }}'
                    }, function(response) {
                        alert('Added to cart!');
                    });
                });
            });
        </script>
        @endpush
</x-admin.layouts.master>