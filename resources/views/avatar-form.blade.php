<x-layout>
    <div class="container container--narow py-md-5">
        <h2 class="text-center mb-3">Uploada a new Avatar</h2>
        <form action="/manage/avatar" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="avatar" id="">
                @error('avatar')
                    <p class="small alert alert-danger shadow-sm">{{ $message }}</p>
                @enderror
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
    </div>
</x-layout>
