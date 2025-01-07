<x-admin.layouts.master>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="text-center">Edit Product</h2>

                    <div class="card-body">
                        <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf
                            @method('PUT')

                            <!-- Product Name -->
                            <div class="form-group">
                                <label for="productName">Product Name</label>
                                <input type="text" id="productName" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
                            </div>

                            <!-- Product Category -->
                            <div class="form-group">
                                <label class="control-label">Select Category</label>
                                <select class="custom-select" name="category" id="categories">
                                    <option value="" disabled>Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Variants -->
                            <div id="variants">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h5 class="mb-0">Variants / Options</h5>
                                    <button type="button" id="add-variant" class="btn btn-primary">Add Variant</button>
                                </div>

                                <!-- Existing Variants -->
                                @foreach ($product->variants as $index => $variant)
                                <div class="card mb-3 variant">
                                    <div class="card-body">
                                        <div class="form-row">
                                            <!-- Variant Name -->
                                            <div class="form-group col-md-4">
                                                <label for="variantName_{{ $index }}">Name</label>
                                                <input type="text" id="variantName_{{ $index }}" name="variants[{{ $index }}][name]" class="form-control" value="{{ old("variants.$index.name", $variant->name) }}" required>
                                            </div>
                                            <input type="hidden"  name="variants[{{ $index }}][id]" class="form-control" value="{{ old("variants.$index.id", $variant->id) }}" required>

                                            <!-- Variant Image -->
                                            <div class="form-group col-md-4">
                                                <label for="variantImage_{{ $index }}">Image</label>
                                                <input type="file" id="variantImage_{{ $index }}" name="variants[{{ $index }}][image]" class="form-control">
                                                @if($variant->image)
                                                <img src="{{ asset('storage/images/product-images/' . $variant->image) }}" alt="{{ $variant->name }}" class="img-thumbnail mt-2" style="max-height: 100px;">
                                                @endif
                                            </div>

                                            <!-- Variant Price -->
                                            <div class="form-group col-md-3">
                                                <label for="variantPrice_{{ $index }}">Price</label>
                                                <input type="number" id="variantPrice_{{ $index }}" name="variants[{{ $index }}][price]" class="form-control" value="{{ old("variants.$index.price", $variant->price) }}" required>
                                            </div>

                                            <!-- Remove Button -->
                                            <div class="form-group col-md-1 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger remove-variant" title="Remove Variant">&times;</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success">Update Product</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
            $(document).ready(function() {
                let variantIndex = {{ $product->variants->count() }};

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
            });
        </script>
        @endpush
</x-admin.layouts.master>
