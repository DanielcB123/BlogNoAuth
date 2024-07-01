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
                    <dt class="text-sm font-medium text-gray-500">Excerpt</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $article->excerpt }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Content</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $article->content }}</dd>
                </div>
            </dl>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('articles.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Back to Articles</a>
    </div>
</div>
@endsection
