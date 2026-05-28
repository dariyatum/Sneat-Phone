@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-4">

            <h3 class="mb-4 fw-bold">Create Product</h3>

            <form action="{{ route('products.store', withLang()) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">

                    {{-- LEFT --}}
                    <div class="col-md-6">

                        {{-- Product Name --}}
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text"
                                   name="product_name"
                                   value="{{ old('product_name') }}"
                                   class="form-control @error('product_name') is-invalid @enderror"
                                   placeholder="Enter product name">

                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Product IMEI --}}
                        <div class="mb-3">
                            <label class="form-label">Product IMEI</label>
                            <input type="text"
                                   name="product_imei"
                                   value="{{ old('product_imei') }}"
                                   class="form-control @error('product_imei') is-invalid @enderror"
                                   placeholder="Enter IMEI">

                            @error('product_imei')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Product Code --}}
                        <div class="mb-3">
                            <label class="form-label">Product Code</label>
                            <input type="text"
                                   name="product_code"
                                   value="{{ old('product_code') }}"
                                   class="form-control"
                                   placeholder="Enter product code">
                        </div>

                        {{-- Brand --}}
                        <div class="mb-3">
                            <label class="form-label">Brand</label>

                            <select name="brand"
                                    class="form-select @error('brand') is-invalid @enderror">

                                <option value="">Select Brand</option>

                                @foreach($brands as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('brand') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('brand')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Series --}}
                        <div class="mb-3">
                            <label class="form-label">Series</label>

                            <select name="series"
                                    class="form-select @error('series') is-invalid @enderror">

                                <option value="">Select Series</option>

                                @foreach($series as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('series') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('series')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Color --}}
                        <div class="mb-3">
                            <label class="form-label">Color</label>

                            <select name="color"
                                    class="form-select @error('color') is-invalid @enderror">

                                <option value="">Select Color</option>

                                @foreach($colors as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('color') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Model Type --}}
                        <div class="mb-3">
                            <label class="form-label">Model Type</label>

                            <select name="model_type"
                                    class="form-select @error('model_type') is-invalid @enderror">

                                <option value="">Select Model</option>

                                @foreach($modelTypes as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('model_type') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('model_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    {{-- Condition --}}
                    <div class="mb-3">
                        <label class="form-label">Condition</label>

                        <select name="condition"
                                class="form-select @error('condition') is-invalid @enderror">

                            <option value="">Select Condition</option>

                            <option value="1" {{ old('condition') == 1 ? 'selected' : '' }}>
                                Used
                            </option>

                            <option value="2" {{ old('condition') == 2 ? 'selected' : '' }}>
                                New
                            </option>

                        </select>

                        @error('condition')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    </div>

                    {{-- RIGHT --}}
                    <div class="col-md-6">

                        {{-- Storage --}}
                        <div class="mb-3">
                            <label class="form-label">Storage</label>

                            <select name="storage"
                                    class="form-select">

                                <option value="">Select Storage</option>

                                @foreach($storage as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('storage') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Type Of Machine --}}
                        <div class="mb-3">
                            <label class="form-label">Type Of Machine</label>

                            <select name="type_of_machine"
                                    class="form-select @error('type_of_machine') is-invalid @enderror">

                                <option value="">Select Type</option>

                                <option value="1" {{ old('type_of_machine') == 1 ? 'selected' : '' }}>
                                    iCloud
                                </option>

                                <option value="2" {{ old('type_of_machine') == 2 ? 'selected' : '' }}>
                                    Unlock
                                </option>

                                <option value="3" {{ old('type_of_machine') == 3 ? 'selected' : '' }}>
                                    Original
                                </option>

                            </select>

                            @error('type_of_machine')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Network --}}
                        <div class="mb-3">
                            <label class="form-label">Network</label>

                            <select name="network"
                                    class="form-select @error('network') is-invalid @enderror">

                                <option value="">Select Network</option>

                                @foreach($network ?? [] as $id => $name)
                                    <option value="{{ $id }}"
                                        {{ old('network') == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>

                            @error('network')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Battery Percentage --}}
                        <div class="mb-3">
                            <label class="form-label">Battery Percentage</label>

                            <input type="text"
                                   name="battery_percentage"
                                   value="{{ old('battery_percentage') }}"
                                   class="form-control"
                                   placeholder="Battery percentage">
                        </div>

                        {{-- Percentage --}}
                        <div class="mb-3">
                            <label class="form-label">Percentage</label>

                            <input type="text"
                                   name="percentage"
                                   value="{{ old('percentage') }}"
                                   class="form-control"
                                   placeholder="Product percentage">
                        </div>

                        {{-- Purchase Price --}}
                        <div class="mb-3">
                            <label class="form-label">Purchase Price</label>

                            <input type="number"
                                   step="0.01"
                                   name="purchase_price"
                                   value="{{ old('purchase_price') }}"
                                   class="form-control @error('purchase_price') is-invalid @enderror"
                                   placeholder="Purchase price">

                            @error('purchase_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Selling Price --}}
                        <div class="mb-3">
                            <label class="form-label">Selling Price</label>

                            <input type="number"
                                   step="0.01"
                                   name="selling_price"
                                   value="{{ old('selling_price') }}"
                                   class="form-control @error('selling_price') is-invalid @enderror"
                                   placeholder="Selling price">

                            @error('selling_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Purchase Date --}}
                        <div class="mb-3">
                            <label class="form-label">Purchase Date</label>

                            <input type="date"
                                   name="purchase_date"
                                   value="{{ old('purchase_date') }}"
                                   class="form-control @error('purchase_date') is-invalid @enderror">

                            @error('purchase_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-3">
                            <label class="form-label">Status</label>

                            <select name="status"
                                    class="form-select @error('status') is-invalid @enderror">

                                <option value="">Select Status</option>

                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                                    Available
                                </option>

                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>
                                    Sold
                                </option>

                                <option value="3" {{ old('status') == 3 ? 'selected' : '' }}>
                                    Reserved
                                </option>
                                <option value="4" {{ old('status') == 4 ? 'selected' : '' }}>
                                    Pre-order
                                </option>

                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Note --}}
                        <div class="mb-3">
                            <label class="form-label">Note</label>

                            <textarea name="note"
                                      rows="4"
                                      class="form-control"
                                      placeholder="Enter note">{{ old('note') }}</textarea>
                        </div>

                        {{-- Image --}}
                        <div class="mb-3">
                            <label class="form-label">Product Image</label>

                            <input type="file"
                                   name="image"
                                   class="form-control">
                        </div>

                    </div>

                </div>

                {{-- Buttons --}}
                <div class="mt-4 d-flex gap-2">

                    <a href="{{ route('products.index', withLang()) }}"
                       class="btn btn-light border px-4">
                        Cancel
                    </a>

                    <button type="submit" class="btn btn-primary px-4">
                        Save Product
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection