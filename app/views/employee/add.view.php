<form class="appForm clearfix" action="" method="post" enctype="application/x-www-form-urlencoded" autocomplete="off">
    <fieldset>
        <legend>معلومات الموظف</legend>
        <div class="input_wrapper n40 border">
            <label for="name">اسم الموظف:</label>
            <input required type="text" name="name" id="name" maxlength="50">
        </div>
        <div class="input_wrapper n30 border">
            <label for="age">عمر الموظف:</label>
            <input required type="number" min="22" max="60" name="age" id="age">
        </div>
        <div class="input_wrapper n20 padding border">
            <label for="salary">راتب الموظف:</label>
            <input required type="number" id="salary" step="0.01" name="salary" min="1500" max="9000">
        </div>
        <div class="input_wrapper n40 padding border">
            <label for="address">عنوان الموظف:</label>
            <input required type="text" id="address" name="address" maxlength="100">
        </div>
        <div class="input_wrapper n20 padding border">
            <label for="tax">الخصم على الموظف:</label>
            <input required type="number" id="tax" step="0.01" name="tax" min="1" max="5">
        </div>
        <input class="no_float" type="submit" name="submit" value="حفظ">
    </fieldset>
</form>

