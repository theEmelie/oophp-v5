<?php

namespace Anax\View;

?>

<h1>Dice Game 100</h1>
<p>Roll the dices, save your current score or reset the game.</p>
<p>Your score is: <b><?=$playerScores[0]?></b></p>
<p>Computers score is: <b><?=$playerScores[1]?></b></p>
<?php if ($inPlayerTurn) :?>
    <?php
    $i = 1;
    if (is_array($dice)) :
        ?><p>You rolled: [ <?php
foreach ($dice as $score) :
    ?><?=$score . " "?>
            <?php $i++;
endforeach;
?> ]</p><?php
    endif; ?>
<?php endif;?>
<p><?= $resultMessage ?></p>


<form method="post">
    <?php if (!$gameOver) :?>
        <?php if ($humanTurn) :?>
            <input type="submit" name="doRoll" value="Roll">
            <?php if ($inPlayerTurn) : ?>
                <input type="submit" name="doSave" value="Save">
            <?php endif;?>
        <?php else :?>
            <input type="submit" name="doComputer" value="Play AI Turn">
        <?php endif;?>
    <?php endif;?>
    <input type="submit" name="doReset" value="Reset">
</form>
