<?php
namespace Anax\View;

if (isset($errorMsg)) {
    echo('<p class="error">' . $errorMsg . '</p>');
}?>
<form method="post">
    <fieldset>
    <legend>Create</legend>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input type="text" name="contentPath"/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="contentData"></textarea>
     </p>

     <p>
         <label>Type:<br>
         <input type="text" name="contentType"/>
     </p>

     <p>
         <label>Filter:<br>
         <input type="text" name="contentFilter"/>
     </p>

    <p>
        <button type="submit" name="doSave"><i class="fa fa-floppy-o" aria-hidden="true"></i> Save</button>
    </p>
    </fieldset>
</form>
