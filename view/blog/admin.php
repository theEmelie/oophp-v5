<?php
namespace Anax\View;

?>
<?php
//var_dump($resultset);
if (!$resultset) {
    return;
}
?>
<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Path</th>
        <th>Slug</th>
        <th>Action</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <?php if (!isset($row->deleted)) {
        ?>
    <tr>
        <?php
    } else {
        ?><tr class="deleted">
        <?php
    }?>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
        <td>
            <?php if (!isset($row->deleted)) {
                ?>
                <a class="icons" href="edit/<?= $row->id ?>" title="Edit this content">
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                </a>
                <a class="icons" href="delete/<?= $row->id ?>" title="Delete this content">
                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                </a>
                <?php
            }?>

        </td>
    </tr>
<?php endforeach; ?>
</table>
