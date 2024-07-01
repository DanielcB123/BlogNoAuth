@extends('layout')

@section('content')
<div class="container mx-auto mt-8">
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
                        <input type="text" id="title" value="{{ $article->title }}" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" disabled>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Excerpt</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <textarea id="excerpt" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" disabled>{{ $article->excerpt }}</textarea>
                    </dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Content</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <textarea id="content" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" disabled>{{ $article->content }}</textarea>
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
    const contentField = document.getElementById('content');

    editButton.addEventListener('click', function() {
        titleField.disabled = false;
        excerptField.disabled = false;
        contentField.disabled = false;
        confirmEditButton.classList.remove('hidden');
        editButton.classList.add('hidden');
    });

    confirmEditButton.addEventListener('click', function() {
        const data = {
            title: titleField.value,
            excerpt: excerptField.value,
            content: contentField.value,
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };

        fetch('{{ route("articles.update", $article->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                titleField.disabled = true;
                excerptField.disabled = true;
                contentField.disabled = true;
                confirmEditButton.classList.add('hidden');
                editButton.classList.remove('hidden');
                alert('Article updated successfully');
            } else {
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
