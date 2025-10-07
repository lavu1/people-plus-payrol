<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md p-6 bg-white rounded-lg shadow-md">
        <h2 class="mb-6 text-xl font-semibold text-center text-gray-800">OTP Verification</h2>
        <form method="POST" action="{{ route('otp.verify') }}" class="space-y-4">
            @csrf
            <div>
                <label for="otp" class="block text-sm font-medium text-gray-700">Enter OTP</label>
                <input 
                    type="text" 
                    name="otp" 
                    id="otp" 
                    required 
                    class="w-full p-3 mt-1 text-sm border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500"
                    placeholder="Enter OTP code"
                />
            </div>
            <button 
                type="submit" 
                class="w-full p-3 text-white bg-amber-600 rounded-md hover:bg-amber-700 font-semibold"
            >
                Verify OTP
            </button>
        </form>
    </div>
</body>
</html>
