

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "以下のURLをクリックしてパスワードを再発行して下さい",
    [
        'actionText' => $actionText,
    ]
) <span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endslot
@endisset

