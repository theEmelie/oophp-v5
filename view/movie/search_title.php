<?php
namespace Anax\View;

?>

<form method="get">
    <fieldset>
    <legend>Search</legend>
    <input type="hidden" name="route" value="search-title">
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= $searchTitle ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    </fieldset>
</form>
