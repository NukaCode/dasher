<div class="ui grid">
    <div class="ten wide centered column">
        <form class="ui form primary" method="POST">
            {{ csrf_field() }}
            <h4 class="ui dividing header primary text">Save a Clone Repo</h4>
            <div class="field">
                <label for="name">Name</label>
                <input type="text" name="name">
            </div>
            <div class="field">
                <label for="url">URL</label>
                <input type="text" name="url">
            </div>
            <input type="submit" class="ui primary button" value="Add Clone Repo" />
        </form>
    </div>
</div>