<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n20 padding border">
            <label<?= $this->labelFloat('Username') ?>><?= $text_label_Username ?></label>
            <input required type="text" name="Username" maxlength="30" value="<?= $this->showValue('Username') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_username'); ?>
            <?php if(!empty($error)): ?>
                <span><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n20 border padding">
            <label<?= $this->labelFloat('Password') ?>><?= $text_label_Password ?></label>
            <input required type="password" name="Password" value="<?= $this->showValue('Password') ?>">
        </div>
        <div class="input_wrapper n20 padding">
            <label<?= $this->labelFloat('CPassword') ?>><?= $text_label_CPassword ?></label>
            <input required type="password" name="CPassword" value="<?= $this->showValue('CPassword') ?>">
        </div>
        <div class="input_wrapper n30 border">
            <label<?= $this->labelFloat('Email') ?>><?= $text_label_Email ?></label>
            <input required type="email" name="Email" maxlength="40" value="<?= $this->showValue('Email') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_email'); ?>
            <?php if(!empty($error)): ?>
                <span><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper n20 padding border">
            <label<?= $this->labelFloat('PhoneNumber') ?>><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" value="<?= $this->showValue('PhoneNumber') ?>">
            <?php  $error = $this->messenger->getMessages('field_error_phone_number'); ?>
            <?php if(!empty($error)): ?>
                <span><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper_other padding n20 select">
            <?php  $error = $this->messenger->getMessages('field_error_group_id'); ?>
            <?php if(!empty($error)): ?>
                <span><?= $error[0] ?></span>
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