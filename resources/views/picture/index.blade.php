<h1>一覧画面</h1>

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div>
    <a href="{{ route('picture.create') }}">新規登録</a>
</div>

@foreach ($pictures as $pic)
    <img src="{{ Storage::url($pic->img_path) }}" width="25%">
@endforeach
