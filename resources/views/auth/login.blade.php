@section('content')
    <h1 class="font-semibold text-center text-2xl">LOGIN</h1>
    <h1 class="mt-3 text-gray-600">PLEASE LOGIN TO CONTINUE TO YOUR ACCOUNT</h1>
@endsection
<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div>
        <livewire:login-user />
    </div>
</x-guest-layout>
