<form autocomplete="off" class="appForm clearfix" method="post" enctype="multipart/form-data">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n100">
            <label<?= $this->labelFloat('Name', $category) ?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" id="Name" maxlength="20" value="<?= $this->showValue('Name', $category) ?>">
            <?php  $error = $this->messenger->getMessages('field_error_name'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n100">
            <label class="floated"><?= $text_label_Image ?></label>
            <input type="file" name="image" accept="image/*">
            <?php  $error = $this->messenger->getMessages('UploadImage'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <?php if ($category->Image !== null): ?>
            <div class="input_wrapper_other n100">
                <img src="/uploads/images/<?= $category->Image ?>" width="30%">
            </div>
        <?php endif; ?>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>