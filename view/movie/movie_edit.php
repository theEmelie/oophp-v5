<?php
$movie = $res[0]; ?>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/>
        </label>
    </p>
    <p>
        <label>Director:<br>
        <input type="text" name="movieDirector" value="<?= $movie->director ?>"/>
        </label>
    </p>
    <p>
        <label>Plot:<br>
        <input type="text" name="moviePlot" value="<?= $movie->plot ?>"/>
        </label>
    </p>
    <p>
        <label>Length:<br>
        <input type="number" name="movieLength" value="<?= $movie->length ?>"/>
        </label>
    </p>
    <p>
        <label>Subtext:<br>
        <input type="text" name="movieSubtext" value="<?= $movie->subtext ?>"/>
        </label>
    </p>
    <p>
        <label>Speech:<br>
        <input type="text" name="movieSpeech" value="<?= $movie->speech ?>"/>
        </label>
    </p>
    <p>
        <label>Quality:<br>
        <input type="text" name="movieQuality" value="<?= $movie->quality ?>"/>
        </label>
    </p>
    <p>
        <label>Format:<br>
        <input type="text" name="movieFormat" value="<?= $movie->format ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="reset" value="Reset">
    </p>
    </fieldset>
</form>
