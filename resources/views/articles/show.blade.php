@extends('layout')

@section('content')
<div class="container mx-auto my-12">
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <h1 class="text-xl mb-2 leading-6 font-medium text-gray-900">Article ID: {{ $article->id }}</h1>
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $article->title }}</h3>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Title</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <input type="text" id="title" value="{{ $article->title }}" class="mt-1 block w-full p-x2 py-1 shadow-sm sm:text-sm rounded-md" disabled>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Excerpt</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <textarea id="excerpt" class="mt-1 block w-full p-x2 py-1 shadow-sm sm:text-sm rounded-md" disabled>{{ $article->excerpt }}</textarea>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Content</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <img id="contentImage" src="{{ $article->content }}" alt="Article Image" class="mt-2 mb-5" style="max-width: 100%; height: auto;">
                        <input type="file" id="newContent" name="content" accept="image/*" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md hidden">
                    </dd>
                </div>
            </dl>
        </div>
    </div>
    <div class="mt-4 flex justify-center space-x-4">
        <a href="{{ route('articles.index') }}" class="bg-blue-500 text-white text-sm md:text-base px-4 py-2 rounded">Back to Articles</a>
        <button id="editButton" class="bg-yellow-500 text-white text-sm md:text-base px-4 py-2 rounded">Edit Article</button>
        <button id="confirmEditButton" class="bg-green-500 text-white text-sm md:text-base px-4 py-2 rounded hidden">Confirm Edit</button>
        <form action="{{ route('articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this article?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white text-sm md:text-base px-4 py-2 rounded">Delete Article</button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButton = document.getElementById('editButton');
    const confirmEditButton = document.getElementById('confirmEditButton');
    const titleField = document.getElementById('title');
    const excerptField = document.getElementById('excerpt');
    const newContentField = document.getElementById('newContent');
    const contentImage = document.getElementById('contentImage');

    editButton.addEventListener('click', function() {
        // Enable the input fields and add the active class
        titleField.disabled = false;
        excerptField.disabled = false;
        newContentField.classList.remove('hidden');

        // Add focus styles to all fields
        titleField.classList.add('border-green-500', 'ring', 'ring-green-200', 'border-2');
        excerptField.classList.add('border-green-500', 'ring', 'ring-green-200', 'border-2');

        confirmEditButton.classList.remove('hidden');
        editButton.classList.add('hidden');
    });

    confirmEditButton.addEventListener('click', function() {
        // Create a FormData object to handle file uploads
        const formData = new FormData();
        formData.append('title', titleField.value);
        formData.append('excerpt', excerptField.value);
        if (newContentField.files.length > 0) {
            formData.append('content', newContentField.files[0]);
        }
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        // Send a POST request to update the article
        fetch('{{ route("articles.update", $article->id) }}', {
            method: 'POST',
            body: formData // Use FormData to send the file
        })
        .then(response => response.json()) // Parse JSON response
        .then(data => {
            if (data.success) {
                // Disable the input fields and remove the active class
                titleField.disabled = true;
                excerptField.disabled = true;
                newContentField.classList.add('hidden');

                titleField.classList.remove('border-green-500', 'ring', 'ring-green-200', 'border-2');
                excerptField.classList.remove('border-green-500', 'ring', 'ring-green-200', 'border-2');

                confirmEditButton.classList.add('hidden');
                editButton.classList.remove('hidden');
                alert('Article updated successfully');

                // Update the image source if a new image was uploaded
                if (data.article.content) {
                    contentImage.src = data.article.content;
                }
            } else {
                console.log(data);
                alert('Error updating article');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Error updating article');
        });
    });

});
</script>
@endsection