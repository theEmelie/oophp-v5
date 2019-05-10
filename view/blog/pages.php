<?php
namespace Anax\View;

?>

<?php
if (!$res) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
    </tr>
<?php foreach ($res as $row) :?>
    <?php if (!isset($row->deleted)) {
        ?>
    <tr>
        <?php
    } else {
        ?><tr class="deleted">
        <?php
    }?>
        <td><?= $row->id ?></td>
        <td><a href="showPage/<?= $row->id ?>"><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
    </tr>
<?php endforeach; ?>
</table>
