@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('picture.store') }}" method="POST" enctype="multipart/form-data">
@csrf
<input type="file" name="img_path">
<input type="submit" value="アップロード">
</form>
