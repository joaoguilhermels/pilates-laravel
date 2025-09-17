@extends('layouts.salient')

@section('content')
  <!-- Hero Section -->
  <section class="relative overflow-hidden bg-white">
    <div class="mx-auto max-w-7xl px-4 pt-20 pb-16 sm:px-6 lg:px-8 lg:pt-32">
      <div class="text-center">
        <h1 class="mx-auto max-w-4xl text-5xl font-bold tracking-tight text-slate-900 sm:text-7xl">
          Pilates Studio 
          <span class="relative whitespace-nowrap text-blue-600">
            <svg aria-hidden="true" viewBox="0 0 418 42" class="absolute top-2/3 left-0 h-[0.58em] w-full fill-blue-300/70" preserveAspectRatio="none">
              <path d="M203.371.916c-26.013-2.078-76.686 1.963-124.73 9.946L67.3 12.749C35.421 18.062 18.2 21.766 6.004 25.934 1.244 27.561.828 27.778.874 28.61c.07 1.214.828 1.121 9.595-1.176 9.072-2.377 17.15-3.92 39.246-7.496C123.565 7.986 157.869 4.492 195.942 5.046c7.461.108 19.25 1.696 19.17 2.582-.107 1.183-7.874 4.31-25.75 10.366-21.992 7.45-35.43 12.534-36.701 13.884-2.173 2.308-.202 4.407 4.442 4.734 2.654.187 3.263.157 15.593-.78 35.401-2.686 57.944-3.488 88.365-3.143 46.327.526 75.721 2.23 130.788 7.584 19.787 1.924 20.814 1.98 24.557 1.332l.066-.011c1.201-.203 1.53-1.825.399-2.335-2.911-1.31-4.893-1.604-22.048-3.261-57.509-5.556-87.871-7.36-132.059-7.842-23.239-.254-33.617-.116-50.627.674-11.629.54-42.371 2.494-46.696 2.967-2.359.259 8.133-3.625 26.504-9.81 23.239-7.825 27.934-10.149 28.304-14.005.417-4.348-3.529-6-16.878-7.066Z" />
            </svg>
            <span class="relative">made simple</span>
          </span>
          for modern studios.
        </h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg tracking-tight text-slate-700">
          Most studio management software is complex and hard to use. We make it simple, beautiful, and powerful.
        </p>
        <div class="mt-10 flex justify-center gap-x-6">
          @guest
            <a href="{{ route('register') }}" class="inline-flex items-center rounded-md bg-blue-600 px-6 py-3 text-white hover:bg-blue-500 font-semibold">Start free trial</a>
            <a href="#features" class="inline-flex items-center rounded-md border border-gray-300 px-6 py-3 text-gray-700 hover:bg-gray-50 font-semibold">
              <svg class="h-3 w-3 flex-none fill-blue-600 mr-3" viewBox="0 0 12 12">
                <path d="m9.997 6.91-7.583 3.447A1 1 0 0 1 1 9.447V2.553a1 1 0 0 1 1.414-.91L9.997 5.09c.782.355.782 1.465 0 1.82Z" />
              </svg>
              Watch demo
            </a>
          @else
            <a href="{{ route('home') }}" class="inline-flex items-center rounded-md bg-blue-600 px-6 py-3 text-white hover:bg-blue-500 font-semibold">Go to Dashboard</a>
          @endguest
        </div>
        <div class="mt-36 lg:mt-44">
          <p class="text-base text-slate-900 font-semibold">Trusted by studios worldwide</p>
          <div class="mt-8 flex items-center justify-center gap-x-12 opacity-60">
            <div class="text-2xl font-bold text-slate-400">Zen Studio</div>
            <div class="text-2xl font-bold text-slate-400">Flow Pilates</div>
            <div class="text-2xl font-bold text-slate-400">Core Balance</div>
          </div>
        </div>
      </div>
    </div>
  </section>

  @include('components.homepage-sections')
@endsection
