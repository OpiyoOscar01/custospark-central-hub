@extends('layouts.employee')
@section('content')
<a href="{{ route('payment.start') }}" class="bg-indigo-600 text-white px-4 py-2 rounded">
    Pay with Flutterwave
</a>

@endsection