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

                            <!-- Options -->
                            <div id="options">
                                <h5>Options</h5>
                                <div class="card mb-3 option">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <!-- Option Name -->
                                            <div class="form-group col-md-4">
                                                <label for="optionName_0">Name</label>
                                                <input type="text" id="optionName_0" name="options[0][name]" class="form-control" placeholder="Enter option name" required>
                                            </div>

                                            <!-- Option Image -->
                                            <div class="form-group col-md-4">
                                                <label for="optionImage_0">Image</label>
                                                <input type="file" id="optionImage_0" name="options[0][image]" class="form-control">
                                            </div>

                                            <!-- Option Price -->
                                            <div class="form-group col-md-3">
                                                <label for="optionPrice_0">Price</label>
                                                <input type="number" id="optionPrice_0" name="options[0][price]" class="form-control" placeholder="Enter price" required>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="form-group col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-option" title="Remove Option">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Add Option Button -->
                            <button type="button" id="add-option" class="btn btn-primary mb-4">Add Option</button>
                            <br>
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
                let optionIndex = 1;

                // Add Option
                $('#add-option').click(function() {
                    $('#options').append(`
                <div class="card mb-3 option">
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label for="optionName_${optionIndex}">Option Name</label>
                                <input type="text" id="optionName_${optionIndex}" name="options[${optionIndex}][name]" class="form-control" placeholder="Enter option name" required>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="optionImage_${optionIndex}">Option Image</label>
                                <input type="file" id="optionImage_${optionIndex}" name="options[${optionIndex}][image]" class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="optionPrice_${optionIndex}">Price</label>
                                <input type="number" id="optionPrice_${optionIndex}" name="options[${optionIndex}][price]" class="form-control" placeholder="Enter price" required>
                            </div>
                            <div class="form-group col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-option" title="Remove Option">&times;</button>
                            </div>
                        </div>
                    </div>
                </div>
            `);
                    optionIndex++;
                });

                // Remove Option
                $(document).on('click', '.remove-option', function() {
                    $(this).closest('.option').remove();
                });

                // Add to Cart
                $('.add-to-cart').click(function() {
                    const optionId = $(this).data('id');
                    $.post('/cart/add', {
                        option_id: optionId,
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