<x-admin.layouts.master>

    <x-slot:breadcrumb>
        Products
        </x-slot>
        <div class="content-wrap">
            <div class="main">
                <div class="container-fluid">
                    <section id="main-content">
                        @if (session('success'))
                        <div class="alert alert-success mx-3">
                            {{ session('success') }}
                        </div>
                        @endif
                        <div class="container-fluid">
                            <div class="row">

                                <div class="col-md-12 col-sm-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <h2>Products</h2>
                                        </div>
                                        <div class="col-md-6 col-lg-6 col-sm-6">
                                            <a href="{{ route('products.create') }}" class="btn btn-primary float-right"> <i class="fa fa-plus mr-2"></i>Add Product</a>
                                        </div>


                                    </div>
                                    <table class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Category</th>
                                                <th>Variant</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($products as $product)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                <td>
                                                    @foreach ($product->variants as $variant)
                                                    <div class="mb-2">
                                                        <strong>{{ $variant->name }}</strong> <br>
                                                        <img src="{{ asset('storage/images/product-images/'. $variant->image) }}" width="50" height="50" alt="ProdImg">
                                                        <br>
                                                        Price: ${{ number_format($variant->price, 2) }}
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('products.edit', $product->id) }}" class=" mx-1 btn btn-warning"><i class="fa fa-edit"></i></a>

                                                    <button class="btn btn-danger btn-sm" data-id="{{ $product->id }}">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Products Available</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>

</x-admin.layouts.master>