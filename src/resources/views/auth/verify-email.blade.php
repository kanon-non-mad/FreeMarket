@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/verify-email.css') }}">
@endsection

@section('content')
<div class="verification">
    <p class="verification__message">
        登録していただいたメールアドレスに認証メールを送付しました。<br>
        メール認証を完了してください。
    </p>
    <div class="form__button">
      <button class="verification-submit" type="submit">認証はこちらから</button>
    </div>
    <div class="sendEmail__link">
        <form method="POST" action="{{route('verification.send')}}">
            @csrf
            <button type="submit" class="sendEmail-submit">認証メールを再送する</button>
    </form>
    </div>
</div>

@endsection