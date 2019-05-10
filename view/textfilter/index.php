<?php
namespace Anax\View;

?>
<h1>Textfilter Tests</h1>
<table>
    <tr>
        <th>Filter Name</th>
        <th>Input Text</th>
        <th>Output Text</th>
    </tr>
    <tr>
        <td>BBCode</td>
        <td><?=$bbIn?></td>
        <td><?=e($bbOut)?></td>
    </tr>
    <tr>
        <td>Clickable</td>
        <td><?=$clIn?></td>
        <td><?=e($clOut)?></td>
    </tr>
    <tr>
        <td>Markdown</td>
        <td><pre><?=$markIn?></pre></td>
        <td><?=e($markOut)?></td>
    </tr>
    <tr>
        <td>Nl2br</td>
        <td><pre><?=$nlIn?></pre></td>
        <td><?=e($nlOut)?></td>
    </tr>
</table>
