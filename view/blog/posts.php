<?php
namespace Anax\View;

?><article><?php
foreach ($res as $content) :
    if (!isset($content->deleted)) :
        ?>
        <section>
            <header>
                <h1><?=$content->title?></h1>
            </header>
            <i>Published: <?=$content->created?></i>
            <p><?=$content->data?></p>
        </section>
        <?php
    endif;
endforeach; ?>
</article>
