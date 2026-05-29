@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">
        <div class="card-body">

            <h3 class="mb-4">Edit Product</h3>

            <form action="{{ route('products.update', withLang(['product' => $product->id])) }}" 
                  method="POST" 
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="row">

                    {{-- LEFT --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text"
                                   name="product_name"
                                   class="form-control"
                                   value="{{ old('product_name', $product->product_name) }}">
                        </div>

                        <div class="mb-3">
                            <label>Product IMEI</label>
                            <input type="text"
                                   name="product_imei"
                                   class="form-control"
                                   value="{{ old('product_imei', $product->product_imei) }}">
                        </div>

                        <div class="mb-3">
                            <label>Product Code</label>
                            <input type="text"
                                   name="product_code"
                                   class="form-control"
                                   value="{{ old('product_code', $product->product_code) }}">
                        </div>

                        <div class="mb-3">
                            <label>Brand</label>
                            <select name="brand" class="form-control">
                                @foreach($brands as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->brand_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Series</label>
                            <select name="series" class="form-control">
                                @foreach($series as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->series_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Color</label>
                            <select name="color" class="form-control">
                                @foreach($colors as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->color_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Model Type</label>
                            <select name="model_type" class="form-control">
                                @foreach($modelTypes as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->model_type_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Condition</label>
                            <select name="condition" class="form-control">
                                @foreach($conditions as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $product->condition == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-md-6">

                        <div class="mb-3">
                            <label>Storage</label>
                            <select name="storage" class="form-control">
                                @foreach($storage as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ $product->storage_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Type Of Machine</label>
                            <select name="type_of_machine" class="form-control">
                                @foreach($type_of_machines as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $product->type_of_machine == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Network</label>
                            <input type="text"
                                   name="network"
                                   class="form-control"
                                   value="{{ old('network', $product->network_id) }}">
                        </div>

                        <div class="mb-3">
                            <label>Battery Percentage</label>
                            <input type="text"
                                   name="battery_percentage"
                                   class="form-control"
                                   value="{{ old('battery_percentage', $product->battery_percentage) }}">
                        </div>

                        <div class="mb-3">
                            <label>Percentage</label>
                            <input type="text"
                                   name="percentage"
                                   class="form-control"
                                   value="{{ old('percentage', $product->percentage) }}">
                        </div>

                        <div class="mb-3">
                            <label>Purchase Price</label>
                            <input type="text"
                                   name="purchase_price"
                                   class="form-control"
                                   value="{{ old('purchase_price', $product->purchase_price) }}">
                        </div>

                        <div class="mb-3">
                            <label>Selling Price</label>
                            <input type="text"
                                   name="selling_price"
                                   class="form-control"
                                   value="{{ old('selling_price', $product->selling_price) }}">
                        </div>

                        <div class="mb-3">
                            <label>Purchase Date</label>
                            <input type="date"
                                   name="purchase_date"
                                   class="form-control"
                                   value="{{ old('purchase_date', $product->purchase_date) }}">
                        </div>

                        <div class="mb-3">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                @foreach($status as $key => $value)
                                    <option value="{{ $key }}"
                                        {{ $product->status == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Note</label>
                            <textarea name="note"
                                      class="form-control"
                                      rows="3">{{ old('note', $product->note) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Image</label>

                            <input type="file"
                                   name="image"
                                   class="form-control">

                            <div class="mt-2">
                                <img src="{{ asset('images/product/' . $product->image) }}"
                                     width="100"
                                     class="rounded border">
                            </div>
                        </div>

                    </div>

                </div>

                <button type="submit" class="btn btn-primary">
                    Update Product
                </button>

                <a href="{{ route('products.index', withLang()) }}"
                   class="btn btn-secondary">
                    Back
                </a>

            </form>

        </div>
    </div>

</div>

@endsection