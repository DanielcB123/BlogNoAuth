@extends('layout')

@section('content')
<div class="container mx-auto my-8 px-0 md:px-4 sm:px-8">
    <!-- Success message overlay -->
    <div id="successMessageOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div id="successMessage" class="bg-green-500 text-white p-4 rounded"></div>
    </div>

    @if (session('success'))
    <div id="successMessageRedirect" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-green-500 text-white p-4 rounded">
            {{ session('success') }}
        </div>
    </div>
    @endif

    <h1 class="w-full flex justify-center items-center text-2xl sm:text-4xl font-semibold py-5">Jonah Digital Article Homework</h1>
    <div class="flex justify-end mb-4 px-4 md:px-0">
        <button id="createArticleButton" class="bg-blue-500 text-white px-4 py-2 rounded">New Article</button>
    </div>
    <div class="overflow-x-auto">
        <table id="articlesTable" class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="w-1/12 px-2 sm:px-4 py-2">ID</th>
                    <th class="w-1/5 px-2 sm:px-4 py-2">Title</th>
                    <th class="w-1/5 px-2 sm:px-4 py-2">Excerpt</th>
                    <th class="w-1/5 px-2 sm:px-4 py-2">Content</th>
                    <th class="w-1/12 px-2 sm:px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data will be loaded via AJAX -->
            </tbody>
        </table>
    </div>
    <div id="paginationControls" class="mt-4 flex justify-center space-x-2">
        <!-- Pagination links will be added here -->
    </div>

    <!-- Create Article Modal -->
    <div id="createArticleModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pb-48 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom w-full bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="createArticleForm">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Create Article</h3>
                                <div class="mt-2">
                                    <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="title" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md mb-5">
                                    <label for="excerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                                    <textarea name="excerpt" id="excerpt" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md mb-5"></textarea>
                                    <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                                    <textarea name="content" id="content" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="saveArticleButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Save</button>
                        <button type="button" id="cancelCreateButton" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Article Modal -->
    <div id="editArticleModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pb-36 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
            <div class="inline-block align-bottom w-full bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="editArticleForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="editArticleId">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 w-full text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Article</h3>
                                <div class="mt-2">
                                    <label for="editTitle" class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" id="editTitle" class="mt-1 h-24 block w-full shadow-sm text-xs md:text-base border-gray-300 rounded-md mb-5">
                                    <label for="editExcerpt" class="block text-sm font-medium text-gray-700">Excerpt</label>
                                    <textarea name="excerpt" id="editExcerpt" class="mt-1 h-24 block w-full shadow-sm text-xs md:text-base border-gray-300 rounded-md mb-5"></textarea>
                                    <label for="editContent" class="block text-sm font-medium text-gray-700">Content</label>
                                    <textarea name="content" id="editContent" class="mt-1 h-24 block w-full shadow-sm text-xs md:text-base border-gray-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" id="updateArticleButton" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-500 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">Update</button>
                        <button type="button" id="cancelEditButton" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:w-auto sm:text-sm">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadArticles();

    document.getElementById('createArticleButton').addEventListener('click', function() {
        document.getElementById('createArticleModal').classList.remove('hidden');
    });

    document.getElementById('cancelCreateButton').addEventListener('click', function() {
        document.getElementById('createArticleModal').classList.add('hidden');
    });

    document.getElementById('saveArticleButton').addEventListener('click', function() {
        var data = {
            title: document.getElementById('title').value,
            excerpt: document.getElementById('excerpt').value,
            content: document.getElementById('content').value,
            _token: '{{ csrf_token() }}'
        };

        fetch('{{ route("articles.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('createArticleModal').classList.add('hidden');
            document.getElementById('title').value = '';
            document.getElementById('excerpt').value = '';
            document.getElementById('content').value = '';
            loadArticles();
            showSuccessMessage('Article created successfully');
        })
        .catch(error => {
            alert('Error saving article');
        });
    });

    document.getElementById('cancelEditButton').addEventListener('click', function() {
        document.getElementById('editArticleModal').classList.add('hidden');
    });

    document.getElementById('updateArticleButton').addEventListener('click', function() {
        var id = document.getElementById('editArticleId').value;
        var data = {
            title: document.getElementById('editTitle').value,
            excerpt: document.getElementById('editExcerpt').value,
            content: document.getElementById('editContent').value,
            _token: '{{ csrf_token() }}',
            _method: 'PUT'
        };

        fetch('/articles/' + id, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify(data)
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('editArticleModal').classList.add('hidden');
            loadArticles();
            showSuccessMessage('Article updated successfully');
        })
        .catch(error => {
            alert('Error updating article');
        });
    });

    document.getElementById('articlesTable').addEventListener('click', function(event) {
        if (event.target.classList.contains('editArticleButton')) {
            var id = event.target.dataset.id;
            fetch('/articles/' + id + '/edit')
            .then(response => response.json())
            .then(data => {
                document.getElementById('editArticleId').value = data.id;
                document.getElementById('editTitle').value = data.title;
                document.getElementById('editExcerpt').value = data.excerpt;
                document.getElementById('editContent').value = data.content;
                document.getElementById('editArticleModal').classList.remove('hidden');
            })
            .catch(error => {
                console.log(error);
                alert('Error loading article');
            });
        } else if (event.target.classList.contains('deleteArticleButton')) {
            var id = event.target.dataset.id;
            if (confirm('Are you sure you want to delete this article?')) {
                fetch(`/articles/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'  // Custom header to indicate AJAX request
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    if (data.success) {
                        loadArticles();
                        showSuccessMessage('Article deleted successfully');
                    }
                })
                .catch(error => {
                    alert('Error deleting article');
                    console.error('There was a problem with the fetch operation:', error);
                });
            }
        } else if (event.target.classList.contains('showArticleButton')) {
            var id = event.target.dataset.id;
            window.location.href = `/articles/${id}`;
        }
    });

    function loadArticles(page = 1) {
        fetch('{{ route("articles.data") }}' + `?page=${page}`)
        .then(response => response.json())
        .then(data => {
            var articlesTableBody = document.querySelector('#articlesTable tbody');
            articlesTableBody.innerHTML = '';
            data.data.forEach(article => {
                var row = document.createElement('tr');
                row.innerHTML = `
                    <td class="border px-1 sm:px-4 py-2 text-xs md:text-base"><p class="flex justify-center">${article.id}</p></td>
                    <td class="border px-1 sm:px-4 py-2 text-xs md:text-base">${article.title}</td>
                    <td class="border px-1 sm:px-4 py-2 text-xs md:text-base">${article.excerpt}</td>
                    <td class="border px-1 sm:px-4 py-2 text-xs md:text-base">${article.content}</td>
                    <td class="border px-1 sm:px-4 py-2">
                        <button class="showArticleButton text-blue-500" data-id="${article.id}">Show</button><br>
                        <button class="editArticleButton text-yellow-500" data-id="${article.id}">Edit</button><br>
                        <button class="deleteArticleButton text-red-500" data-id="${article.id}">Delete</button>
                    </td>
                `;
                articlesTableBody.appendChild(row);
            });
            renderPagination(data);
        })
        .catch(error => {
            alert('Error loading articles');
        });
    }

    function renderPagination(data) {
        var paginationControls = document.getElementById('paginationControls');
        paginationControls.innerHTML = '';

        if (data.current_page > 1) {
            let prevButton = document.createElement('button');
            prevButton.textContent = 'Previous';
            prevButton.className = 'mx-1 px-1 md:px-3 py-1 rounded bg-gray-300';
            prevButton.addEventListener('click', function() {
                loadArticles(data.current_page - 1);
            });
            paginationControls.appendChild(prevButton);
        }

        for (let page = 1; page <= data.last_page; page++) {
            let pageButton = document.createElement('button');
            pageButton.textContent = page;
            pageButton.className = 'mx-1 px-1 md:px-3 py-1 rounded bg-gray-300';
            if (page === data.current_page) {
                pageButton.className += ' bg-gray-500 text-white';
            }
            pageButton.addEventListener('click', function() {
                loadArticles(page);
            });
            paginationControls.appendChild(pageButton);
        }

        if (data.current_page < data.last_page) {
            let nextButton = document.createElement('button');
            nextButton.textContent = 'Next';
            nextButton.className = 'mx-1 px-1 md:px-3 py-1 rounded bg-gray-300';
            nextButton.addEventListener('click', function() {
                loadArticles(data.current_page + 1);
            });
            paginationControls.appendChild(nextButton);
        }
    }

    const successMessage = document.getElementById('successMessageRedirect');
    if (successMessage) {
        setTimeout(() => {
            successMessage.classList.add('hidden');
        }, 3000);
    }

    function showSuccessMessage(message) {
        const successMessageOverlay = document.getElementById('successMessageOverlay');
        const successMessage = document.getElementById('successMessage');
        successMessage.textContent = message;
        successMessageOverlay.classList.remove('hidden');
        setTimeout(() => {
            successMessageOverlay.classList.add('hidden');
        }, 3000);
    }
});
</script>
@endsection
