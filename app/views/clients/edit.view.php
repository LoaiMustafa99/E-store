<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n50 border">
            <label<?= $this->labelFloat('Name', $client) ?>><?= $text_label_Name ?></label>
            <input required type="text" name="Name" maxlength="40" value="<?= $this->showValue('Name', $client) ?>">
            <?php  $error = $this->messenger->getMessages('field_error_name'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n50 padding">
            <label<?= $this->labelFloat('Email', $client) ?>><?= $text_label_Email ?></label>
            <input required type="email" name="Email" maxlength="40" value="<?= $this->showValue('Email', $client) ?>">
            <?php  $error = $this->messenger->getMessages('field_error_email'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n50 border">
            <label<?= $this->labelFloat('PhoneNumber', $client) ?>><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" maxlength="15" value="<?= $this->showValue('PhoneNumber', $client) ?>">
            <?php  $error = $this->messenger->getMessages('field_error_phone_number'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n50 padding">
            <label<?= $this->labelFloat('Address', $client) ?>><?= $text_label_Address ?></label>
            <input required type="text" name="Address" value="<?= $this->showValue('Address', $client) ?>">
            <?php  $error = $this->messenger->getMessages('field_error_address'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>