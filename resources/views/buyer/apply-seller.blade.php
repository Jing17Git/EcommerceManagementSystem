<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply as Seller - Support Local</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Outfit', sans-serif; background-color: #FAFAFA; color: #1A1A1A; }
        .display-font { font-family: 'Playfair Display', serif; }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div>
                <h2 class="mt-6 text-center display-font text-3xl font-bold text-gray-900">
                    Become a Seller
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Join our marketplace and start selling your products
                </p>
            </div>
            
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            
            @if(session('info'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('info') }}</span>
                </div>
            @endif
            
            <form class="mt-8 space-y-6" action="{{ route('buyer.submitSellerApplication') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="rounded-md shadow-sm -space-y-px">
                    <div class="mb-4">
                        <label for="business_name" class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                        <input id="business_name" name="business_name" type="text" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your business name" value="{{ old('business_name') }}">
                        @error('business_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="business_email" class="block text-sm font-medium text-gray-700 mb-1">Business Email</label>
                        <input id="business_email" name="business_email" type="email" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your business email" value="{{ old('business_email') }}">
                        @error('business_email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="business_phone" class="block text-sm font-medium text-gray-700 mb-1">Business Phone</label>
                        <input id="business_phone" name="business_phone" type="text" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your business phone" value="{{ old('business_phone') }}">
                        @error('business_phone')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label for="business_address" class="block text-sm font-medium text-gray-700 mb-1">Business Address</label>
                        <textarea id="business_address" name="business_address" rows="3" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            placeholder="Enter your business address">{{ old('business_address') }}</textarea>
                        @error('business_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="business_permit" class="block text-sm font-medium text-gray-700 mb-1">Business Permit <span class="text-red-500">*</span></label>
                        <input id="business_permit" name="business_permit" type="file" required accept=".pdf,.jpg,.jpeg,.png"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm">
                        <p class="text-xs text-gray-500 mt-1">Upload your valid business permit (PDF, JPG, PNG - Max 5MB)</p>
                        @error('business_permit')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="business_permit_name" class="block text-sm font-medium text-gray-700 mb-1">Name on Business Permit <span class="text-red-500">*</span></label>
                        <input id="business_permit_name" name="business_permit_name" type="text" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            placeholder="Enter name exactly as shown on permit" value="{{ old('business_permit_name') }}">
                        <p class="text-xs text-gray-500 mt-1">Must match business name and ID card name</p>
                        @error('business_permit_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="permit_expiry_date" class="block text-sm font-medium text-gray-700 mb-1">Permit Expiry Date <span class="text-red-500">*</span></label>
                        <input id="permit_expiry_date" name="permit_expiry_date" type="date" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            value="{{ old('permit_expiry_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        <p class="text-xs text-gray-500 mt-1">Permit must not be expired</p>
                        @error('permit_expiry_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_card" class="block text-sm font-medium text-gray-700 mb-1">ID Card <span class="text-red-500">*</span></label>
                        <input id="id_card" name="id_card" type="file" required accept=".pdf,.jpg,.jpeg,.png"
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm">
                        <p class="text-xs text-gray-500 mt-1">Upload your valid ID card (PDF, JPG, PNG - Max 5MB)</p>
                        @error('id_card')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="id_card_name" class="block text-sm font-medium text-gray-700 mb-1">Name on ID Card <span class="text-red-500">*</span></label>
                        <input id="id_card_name" name="id_card_name" type="text" required 
                            class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-orange-500 focus:border-orange-500 focus:z-10 sm:text-sm"
                            placeholder="Enter name exactly as shown on ID" value="{{ old('id_card_name') }}">
                        <p class="text-xs text-gray-500 mt-1">Must match business name</p>
                        @error('id_card_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-yellow-50 border border-yellow-200 rounded-md p-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Automatic Validation</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>Business permit must not be expired</li>
                                    <li>Business name must match ID card name</li>
                                    <li>Business permit name must match business name</li>
                                    <li>Business permit name must match ID card name</li>
                                    <li>All three names must be identical</li>
                                    <li>Application will be automatically approved or rejected</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <button type="submit" 
                        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-orange-500 hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-store"></i>
                        </span>
                        Submit Application
                    </button>
                </div>
                
                <div class="text-center">
                    <a href="{{ route('buyer.dashboard') }}" class="text-sm text-orange-500 hover:text-orange-600">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
