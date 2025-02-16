<html>
<head>
    <x-base-head-tags />
    <title>Suppliers</title>
</head>

<body>
    <a class="absolute bg-gray-300 py-2 px-4 rounded-md text-2xl font-bold top-5 left-10 hover:text-red-500 transition-colors duration-200" href="/">< Home</a>
    
    <div class="mx-auto bg-gray-300 pb-14 pt-10 px-20 mt-36 w-3/4 rounded-md">
        <h2 class="text-center font-extrabold text-5xl">Suppliers</h2>

        <div class="h-[550px] flex flex-col gap-5 mt-14 bg-gray-100 rounded-md p-10 overflow-y-auto border-gray-100 border-[30px] border-gray-100 rounded-md">
            @foreach ($suppliers as $supplier)
                <div class="bg-gray-400 py-4 px-8 rounded-md flex items-center">
                    <div class="flex w-4/6">
                        <div class="flex w-full">
                            <input class="supplier-name-input border w-full border-gray-300 h-10 px-4 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" value="{{ $supplier['supplier_name'] }}">
                        
                            <button data-supplier-id="{{ $supplier['id'] }}" class="save-supplier-name-button bg-blue-800 px-4 h-10 rounded-md rounded-l-none block -ml-16 w-16 hover:bg-blue-950 transition-bg duration-200 text-white hover:text-gray-100 transition-colors duration-200">Save</button>
                        </div>
                    </div>

                    <div class="w-2/6 flex gap-4">
                        <a href="/products?supplier={{ $supplier['id'] }}" class="bg-blue-800 px-4 h-10 rounded-md flex items-center cursor-pointer ml-auto hover:bg-blue-950 transition-bg duration-200 text-white hover:text-gray-100 transition-colors duration-200">Products</a>

                        <button data-supplier-id="{{ $supplier['id'] }}" class="delete-supplier-button bg-red-500 px-4 h-10 rounded-md block hover:bg-red-600 transition-bg duration-200 text-white hover:text-gray-100 transition-colors duration-200">Delete</button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @vite('resources/js/inits/suppliers_init.js')
</body>
</html>