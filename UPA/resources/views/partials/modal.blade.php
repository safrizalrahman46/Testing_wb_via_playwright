<!-- Modal for KTP -->
<div id="myModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden justify-center items-center z-50">
    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm w-full">
        <h3 class="text-2xl font-semibold mb-4">KTP</h3>
        
        <!-- KTP content will be loaded here dynamically -->
        <div id="ktpContent" class="flex justify-center mb-4">
            <!-- Dynamically loaded KTP content will go here -->
        </div>
        
        <div class="mt-4 text-center">
            <a href="{{ Storage::url($registration->ktp_path) }}" id="ktpDownloadLink" class="text-blue-500" target="_blank">Download KTP</a>
        </div>

        <div class="mt-4">
            <button class="bg-gray-500 text-white py-2 px-4 rounded" id="closeKTPModalBtn" onclick="closeModal()">Close</button>
        </div>
    </div>
</div>
