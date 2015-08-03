<div class="ui grid">
    <div class="ten wide centered column">
        <form class="ui form primary" method="POST">
            {{ csrf_field() }}
            <h4 class="ui dividing header primary text">
                Edit {{ $forward->starting_port }} -> {{ $forward->destination_port }}
            </h4>
            <div class="field">
                <label for="starting_port">Starting Port</label>
                <input type="text" name="starting_port" value="{{ $forward->starting_port }}">
            </div>
            <div class="field">
                <label for="starting_port">Destination Port</label>
                <input type="text" name="destination_port" value="{{ $forward->destination_port }}">
            </div>
            <input type="submit" class="ui primary button" value="Update Port Forward" />
        </form>
    </div>
</div>