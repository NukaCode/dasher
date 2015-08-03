<div class="ui grid">
    <div class="ten wide centered column">
        <form class="ui form primary" method="POST">
            {{ csrf_field() }}
            <h4 class="ui dividing header primary text">Clone a new site</h4>
            <div class="field">
                <label for="clone_id">Clone Repo</label>
                <select name="clone_id" id="clone_id" class="ui search dropdown">
                    <option value="">Select One</option>
                    @foreach ($clones as $id => $clone)
                        <option value="{{ $id }}">{{ $clone }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="group_id">Group</label>
                <select name="group_id" id="group_id" class="ui search dropdown">
                    <option value="">Select One</option>
                    @foreach ($groups as $id => $group)
                        <option value="{{ $id }}">{{ $group }}</option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label for="name">Site Name</label>
                <input type="text" name="name" />
            </div>
            <input type="submit" class="ui primary button" value="Clone Site" />
        </form>
    </div>
</div>

@section('js')
    <script>
        $('#clone_id').dropdown();
        $('#group_id').dropdown();
    </script>
@endsection