@component('mail::message')
# Disk Space Low!

This disk for the server: [{{ gethostname() }}] &mdash; {{ request()->server('SERVER_ADDR') }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
