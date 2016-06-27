@if (count($errors) > 0)
    <div class="message is-danger">
        <div class="message-header">Error</div>
        <div class="message-body">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div>
@endif