@if ($errors->any())
<div {{ $attributes }}>
    <div class="gap-2 p-3 border rounded bg-danger/10 text-danger dark:border-rose-500">

        <div class="font-medium text-red-600">{{ __('Whoops! Something went wrong.') }}</div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>

    </div>
</div>
@endif