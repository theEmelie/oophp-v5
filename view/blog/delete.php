<?php
namespace Anax\View;

//var_dump($content);?>

<form method="post">
    <fieldset>
    <legend>Delete</legend>

    <input type="hidden" name="contentId" value="<?= $content->id ?>"/>

    <p>
        <label>Title:<br>
            <input type="text" name="contentTitle" value="<?= $content->title ?>" readonly/>
        </label>
    </p>

    <p>
        <button type="submit" name="doDelete"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
    </p>
    </fieldset>
</form>
