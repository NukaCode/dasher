<div class="ui grid">
    <div class="ten wide centered column">
        <form class="ui form primary" method="POST">
            {{ csrf_field() }}
            <h4 class="ui dividing header primary text">Detail a Forwarded Port</h4>
            <div class="field">
                <label for="starting_port">Starting Port</label>
                <input type="text" name="starting_port">
            </div>
            <div class="field">
                <label for="starting_port">Destination Port</label>
                <input type="text" name="destination_port">
            </div>
            <input type="submit" class="ui primary button" value="Add Port Forward" />
        </form>
    </div>
</div>