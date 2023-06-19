@component('mail::message')

{{-- Subcopy --}}
@isset($actionText)
@lang("パスワード再発行")<br>
@lang("以下のURLをクリックしてパスワードを再発行してください。", ['actionText' => $actionText,])<br>
<span class="break-all">[{{ $displayableActionUrl }}]({{ $actionUrl }})</span>
@endisset
@endcomponent
