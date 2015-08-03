<div class="ui grid">
    <div class="ten wide centered column">
        <form class="ui form primary" method="POST">
            {{ csrf_field() }}
            <h4 class="ui dividing header primary text">Generate a new site</h4>
            <div class="inline fields">
                @foreach ($installerOptions as $option => $readable)
                    <div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name="installType" value="{{ $option }}" />
                            <label>{{ $readable }}</label>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="field">
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
            <input type="submit" class="ui primary button" value="Generate Site" />
        </form>
    </div>
</div>

@section('js')
    <script>
        $('#group_id').dropdown();
    </script>
@endsection