<!-- resources/views/components/success-message.blade.php -->
<div id="successMessageOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div id="successMessage" class="bg-sky-500 border-white border-2 text-white p-4 rounded">
        {{-- 
            message displayed here from         
            const successMessage = document.getElementById('successMessage');
            successMessage.textContent = message; 
            in index.blade.php
        --}}
       
    </div>
</div>

@if (session('success'))
<div id="successMessageRedirect" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-sky-500 border-white border-2 text-white p-4 rounded">
        {{ session('success') }}
    </div>
</div>
@endif
