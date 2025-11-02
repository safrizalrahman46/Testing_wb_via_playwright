<div class="flex justify-center mb-4">
    <!-- Menampilkan gambar KTP -->
    {{-- <img src="{{ asset('ktpDummy.jpg') }}" alt="KTP" class="max-w-full h-auto"> --}}
    <img src="{{ Storage::url($registration->ktp_path) }}" alt="KTP" class="max-w-full h-auto">
</div>

<div class="mt-4 text-center">
    <!-- Menyediakan link untuk mengunduh KTP -->
    <a href="{{ Storage::url($registration->ktp_path) }}" target="_blank" class="text-blue-500"></a>
</div>