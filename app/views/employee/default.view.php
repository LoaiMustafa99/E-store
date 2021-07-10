<?php if(isset($_SESSION['message'])): ?>
    <p class="message <?php isset($error) ? 'error' : ''; ?>"><?= $_SESSION['message'] ?></p>
<?php unset($_SESSION['message']); ?>
<?php endif; ?>
<a class="button" href="/employee/add"><i class="fa fa-plus"></i><?= $text_add_employee ?></a>
    <table class="data">
        <thead>
        <tr>
            <th><?= $text_table_employee_name ?></th>
            <th><?= $text_table_employee_age ?></th>
            <th><?= $text_table_employee_address ?></th>
            <th><?= $text_table_employee_salary ?></th>
            <th><?= $text_table_employee_tax ?></th>
            <th><?= $text_table_employee_control ?></th>
        </tr>
        </thead>
        <tbody>
        <?php if($employees !== false): ?>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= $employee->name ?></td>
                    <td><?= $employee->age ?></td>
                    <td><?= $employee->address ?></td>
                    <td><?= $employee->salary ?></td>
                    <td><?= $employee->tax ?></td>
                    <td>
                        <a href="/employee/edit/<?= $employee->id ?>"><i class="fa fa-edit"></i></a>
                        <a href="/employee/delete/<?= $employee->id ?>" onclick="if(!confirm('<?= $text_confirm_delete ?>')) return false;"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5"><p>Sorry no employees to list</p></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
