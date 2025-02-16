<html>
<head>
    <x-base-head-tags />
    <title>Parts</title>
</head>

<body>
    <a class="absolute bg-gray-300 py-2 px-4 rounded-md text-2xl font-bold top-5 left-10 hover:text-red-500 transition-colors duration-200" href="/">< Home</a>

    <div class="mx-auto bg-gray-300 pb-14 pt-10 px-20 mt-36 w-5/6 rounded-md">
        <h2 class="text-center font-extrabold text-5xl">Parts</h2>

        <div class="h-[550px] flex flex-col gap-5 mt-14 bg-gray-100 rounded-md p-10 pt-0 overflow-y-auto border-gray-100 border-[30px] border-gray-100 rounded-md">
            <div class="bg-gray-100 sticky top-0 z-10 flex px-4 py-2 flex items-center gap-4 font-bold">
                <p class="w-[12%] px-1 truncate ...">Supplier</p>

                <p class="w-[6%] px-1 truncate ...">Days Valid</p>
                
                <p class="w-[6%] px-1 truncate ...">Priority</p>

                <p class="w-[10%] px-1 truncate ...">Part No.</p>

                <p class="w-[20%] px-1 truncate ...">Part Desc.</p>

                <p class="w-[6%] px-1 truncate ...">Quantity</p>

                <p class="w-[8%] px-1 truncate ...">Price</p>

                <p class="w-[10%] px-1 truncate ...">Condition</p>

                <p class="w-[10%] px-1 truncate ...">Category</p>

                <p class="w-[6%] px-1 truncate ..."></p>

                <p class="w-[6%] px-1 truncate ..."></p>
            </div>

            @foreach ($parts as $part)
                <div class="bg-gray-400 p-4 rounded-md flex items-center gap-4">
                    {{-- Supplier --}}
                    <select class="supplier-select border w-[12%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">---</option>

                        @foreach($allSuppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ isset($part) && $supplier->id == $part['supplier_id'] ? 'selected' : '' }}>{{ $supplier->supplier_name }}</option>
                        @endforeach
                    </select>

                    {{-- Days Valid --}}
                    <input placeholder="N/A" class="days-valid-input border w-[6%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['days_valid'] ?? '' }}">

                    {{-- Priority --}}
                    <input placeholder="N/A" class="priority-input border w-[6%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['priority'] ?? '' }}">

                    {{-- Part Number --}}
                    <input class="part-number-input border w-[10%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['part_number'] }}">

                    {{-- Part Description --}}
                    <input class="part-description-input border w-[20%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['part_desc'] }}">

                    {{-- Quantity --}}
                    <input placeholder="N/A" class="quantity-input border w-[6%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['quantity'] ?? '' }}">

                    {{-- Price --}}
                    <input placeholder="N/A" class="price-input border w-[8%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['price'] ?? '' }}">

                    {{-- Condition --}}
                    <select class="condition-select border w-[10%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                        <option value="">---</option>

                        @foreach($allConditions as $condition)
                            <option value="{{ $condition->id }}" {{ isset($part) && $condition->id == $part['condition_id'] ? 'selected' : '' }}>{{ $condition->condition_name }}</option>
                        @endforeach
                    </select>

                    {{-- Category --}}
                    <select class="category-select border w-[10%] border-gray-300 h-10 px-2 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $part['category']['category_name'] ?? '' }}">
                        <option value="">---</option>

                        @foreach($allCategories as $category)
                            <option value="{{ $category->id }}" {{ isset($part['category_id']) && $category->id == $part['category_id'] ? 'selected' : '' }}>{{ $category->category_name }}</option>
                        @endforeach
                    </select>

                    <button data-part-id="{{ $part['id'] }}" class="save-part-button truncate ... bg-blue-800 w-[6%] px-2 h-10 rounded-md block hover:bg-blue-950 transition-bg duration-200 text-white hover:text-gray-100 transition-colors duration-200">Save</button>

                    <button data-part-id="{{ $part['id'] }}" class="delete-part-button truncate ... bg-red-500 w-[6%] px-2 h-10 rounded-md block hover:bg-red-600 transition-bg duration-200 text-white hover:text-gray-100 transition-colors duration-200">Delete</button>
                </div>
            @endforeach
        </div>
    </div>

    @vite('resources/js/inits/parts_init.js')
</body>
</html>