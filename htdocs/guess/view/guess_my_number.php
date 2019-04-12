<h1>Guess my number</h1>
<p>Guess a number between 1 and 100, you have <?= $maxTries - $tries + 1 ?> left.</p>

<form method="post">
    <input type="text" name="guess">
    <!-- Too see which is the correct number -->
    <input type="hidden" name="number" value="<?= $number ?>">
    <input type="submit" name="doGuess" value="Make a Guess">
    <input type="submit" name="doInit" value="Start From Beginning">
</form>

<?php if ($doGuess) : ?>
    <p><b><?= $res ?></b></p>
<?php endif; ?>
