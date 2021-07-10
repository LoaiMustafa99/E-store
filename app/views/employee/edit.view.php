<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend>Employee Information</legend>
        <div class="input_wrapper n40 border">
            <label class="floated" for="name">Employees Name:</label>
            <input required type="text" name="name" id="name" maxlength="50" value="<?= $employees->name ?>">
        </div>
        <div class="input_wrapper n40 padding border">
            <label class="floated" for="address">Employees Address:</label>
            <input required type="text" id="address" name="address" maxlength="100" value="<?= $employees->address ?>">
        </div>
        <div class="input_wrapper n30 border">
            <label class="floated" for="age">Employees Age:</label>
            <input required type="number" min="22" max="60" name="age" id="age" value="<?= $employees->age ?>">
        </div>
        <div class="input_wrapper n20 padding border">
            <label class="floated" for="salary">Employees Salary:</label>
            <input required type="number" id="salary" step="0.01" name="salary" min="1500" max="9000" value="<?= $employees->salary ?>">
        </div>
        <div class="input_wrapper n20 padding border">
            <label class="floated" for="tax">Employees Tax:</label>
            <input required type="number" id="tax" step="0.01" name="tax" min="1" max="5" value="<?= $employees->tax ?>">
        </div>
        <input type="submit" name="submit" value="Save">
    </fieldset>
</form>