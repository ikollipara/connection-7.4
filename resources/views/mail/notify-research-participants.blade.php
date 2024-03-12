@php
    use Illuminate\Support\Str;
@endphp
@component('mail::message')
# New Message from {{ $study->title }}

{{!! Str::of($message)->markdown() !!}}
@endcomponent
