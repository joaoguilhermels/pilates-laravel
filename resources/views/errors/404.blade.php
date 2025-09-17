@extends('layouts.salient')

@section('content')
  <section class="min-h-[70vh] flex items-center">
    <div class="mx-auto max-w-2xl px-4 text-center">
      <p class="text-base font-semibold text-indigo-600">404</p>
      <h1 class="mt-2 text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-5xl">Page not found</h1>
      <p class="mt-4 text-base leading-7 text-gray-600 dark:text-gray-300">Sorry, we couldn't find the page you're looking for.</p>
      <div class="mt-10 flex items-center justify-center gap-4">
        <a href="{{ url('/') }}" class="inline-flex items-center rounded-md bg-indigo-600 px-4 py-2 text-white hover:bg-indigo-500">Go back home</a>
        @guest
          <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300">Sign in <span aria-hidden="true">→</span></a>
        @else
          <a href="{{ route('home') }}" class="text-sm font-semibold text-gray-900 dark:text-white hover:text-gray-700 dark:hover:text-gray-300">Dashboard <span aria-hidden="true">→</span></a>
        @endguest
      </div>
    </div>
  </section>
@endsection
