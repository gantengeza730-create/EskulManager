@if (session('success'))<div class="flash ok">{{ session('success') }}</div>@endif
@if (session('error'))<div class="flash bad">{{ session('error') }}</div>@endif
@if ($errors->any())<div class="flash bad">@foreach ($errors->all() as $e)<div>{{ $e }}</div>@endforeach</div>@endif
