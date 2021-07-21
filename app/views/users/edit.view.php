<form autocomplete="off" class="appForm clearfix" method="post" enctype="application/x-www-form-urlencoded">
    <fieldset>
        <legend><?= $text_legend ?></legend>
        <div class="input_wrapper n50 padding border">
            <label<?= $this->labelFloat('PhoneNumber', $user) ?>><?= $text_label_PhoneNumber ?></label>
            <input required type="text" name="PhoneNumber" value="<?= $this->showValue('PhoneNumber', $user) ?>">
            <?php  $error = $this->messenger->getMessages('field_error_phone_number'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
        </div>
        <div class="input_wrapper_other padding n50 select">
            <?php  $error = $this->messenger->getMessages('field_error_group_id'); ?>
            <?php if(!empty($error)): ?>
                <span class="error_message"><?= $error[0] ?></span>
            <?php endif; ?>
            <select required name="GroupId">
                <option value=""><?= $text_user_GroupId ?></option>
                <?php if (false !== $groups): foreach ($groups as $group): ?>
                    <option value="<?= $group->GroupId ?>" <?= $this->selectedIf('GroupId', $group->GroupId, $user) ?>><?= $group->GroupName ?></option>
                <?php endforeach;endif; ?>
            </select>
        </div>
        <input class="no_float" type="submit" name="submit" value="<?= $text_label_save ?>">
    </fieldset>
</form>