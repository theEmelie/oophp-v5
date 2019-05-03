<?php
// var_dump($res);
$movie = $res[0];
?>

<form method="post">
        <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>
        <input type="submit" name="doSave" value="Delete Movie">
</form>
