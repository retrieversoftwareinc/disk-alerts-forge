@component('mail::message')
# Disk Space Low!

This disk for the server: [{{ gethostname() }}] &mdash; {{ file_get_contents('http://canihazip.com/s') }}

@component('mail::table')
| | |
| ------------- |:-------------:|
| Total disk space | {{ $total_disk }} GB |
| Total disk space free | {{ $disk_free }} GB |
| Total disk used | {{ $disk_used }} GB |
| Location checked | `{{ $location }}` |
| Alert when free space is less than | {{ $alert }} GB |
@endcomponent


Thanks,<br>
{{ config('app.name') }}
@endcomponent
