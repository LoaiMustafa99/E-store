<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n20 border">
            <label<?= $this->labelFloat('FirstName') ?>><?= $text_label_FirstName ?></label>
            <input required type="text" name="FirstName" maxlength="10" value="<?= $this->showValue('FirstName') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_first_name'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n20 border padding">
            <label<?= $this->labelFloat('LastName') ?>><?= $text_label_LastName ?></label>
            <input required type="text" name="LastName" maxlength="10" value="<?= $this->showValue('LastName') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_last_name'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n20 padding border">
            <label<?= $this->labelFloat('Username') ?>><?= $text_label_Username ?></label>
            <input required type="text" name="Username" maxlength="30" value="<?= $this->showValue('Username') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_username'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n20 border padding">
            <label<?= $this->labelFloat('Password') ?>><?= $text_label_Password ?></label>
            <input required type="password" name="Password" value="<?= $this->showValue('Password') ?>">
            <?php  $error = $this->messenger->getMessages('filed_error_password'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n20 padding">
            <label<?= $this->labelFloat('CPassword') ?>><?= $text_label_CPassword ?></label>
            <input required type="password" name="CPassword" value="<?= $this->showValue('CPassword') ?>">
            <?php  $error = $this->messenger->getMessages('filed_error_confirm_password'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n40 border">
            <label<?= $this->labelFloat('Email') ?>><?= $text_label_Email ?></label>
            <input required type="email" name="Email" maxlength="40" value="<?= $this->showValue('Email') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_email'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n30 padding border">
            <label<?= $this->labelFloat('PhoneNumber') ?>><?= $text_label_PhoneNumber ?></label>
            <input type="text" name="PhoneNumber" value="<?= $this->showValue('PhoneNumber') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_phone_number'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper_other padding n30 select">
            <?php  $error = $this->messenger->getMessages('field_error_group_id'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
            <select required name="GroupId">
                <option value=""><?= $text_user_GroupId ?></option>
                <?php if (false !== $groups): foreach ($groups as $group): ?>
                    <option value="<?= $group->GroupId ?>"><?= $group->GroupName ?></option>
                <?php endforeach;endif; ?>
            </select>
        </div>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>