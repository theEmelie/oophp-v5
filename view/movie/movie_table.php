<?php
if (isset($resultset)) {
    ?>
    <table>
        <tr class="first">
            <th>Id</th>
            <th>Bild</th>
            <th>Titel</th>
            <th>År</th>
            <th>Action</th>
        </tr>
    <?php foreach ($resultset as $row) :
        ?>
        <tr>
            <td><?= $row->id ?></td>
            <td><img class="thumb" src="../<?= $row->image ?>"></td>
            <td><?= $row->title ?></td>
            <td><?= $row->year ?></td>
            <td><a href="viewMovie/<?=$row->id?>">View</a><br />
            <a href="editMovie/<?=$row->id?>">Edit</a><br />
            <a href="deleteMovie/<?=$row->id?>">Delete</a><br></td>
        </tr>
    <?php endforeach; ?>
    </table>
    <?php
}
?>
