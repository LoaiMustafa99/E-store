<?php $massege = $this->messenger->getMessages("UserGroup");?>
<?php if($massege !== null):?>
    <p class="message t<?= $massege[1] ?>"><?= $massege[0] ?><a href="" class="closeBtn"><i class="fa fa-times"></i></a></p>
<?php endif;?>
<div class="container">
    <a href="/usersgroups/add" class="button"><i class="fa fa-plus"></i> <?= $text_new_item ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_group_name ?></th>
            <th><?= $text_table_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if(false !== $groups): foreach ($groups as $group): ?>
            <tr>
                <td><?= $group->GroupName ?></td>
                <td>
                    <a href="/usersgroups/edit/<?= $group->GroupId ?>"><i class="fa fa-edit"></i></a>
                    <a href="/usersgroups/delete/<?= $group->GroupId ?>" onclick="if(!confirm('<?= $text_table_control_delete_confirm ?>')) return false;"><i class="fa fa-trash"></i></a>
                </td>
            </tr>
        <?php endforeach; endif; ?>
        </tbody>
    </table>
</div>