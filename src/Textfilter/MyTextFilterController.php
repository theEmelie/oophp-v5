<?php
namespace Emau\TextFilter;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

class MyTextFilterController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function indexAction()
    {
        $myTextFilter = new \Emau\TextFilter\MyTextFilter();
        $title = "Textfilter Test";

        $bbIn = "[b]Bold text[/b] [i]Italic text[/i] [url=http://dbwebb.se]a link to dbwebb[/url]
        And then an image. [img]https://dbwebb.se/image/tema/trad/blad.jpg[/img]";
        $bbOut = $myTextFilter->parse($bbIn, "bbcode");

        $clIn = "This link should for example be made clickable: http://dbwebb.se and so should this
        link http://dbwebb.se/kod-exempel/function_to_make_links_clickable/ and so should this:
        http://dbwebb.se/kod-exempel/function_to_make_links_clickable#id.";
        $clOut = $myTextFilter->parse($clIn, "link");

        $markIn = "### Header level 3 {#id3} \n" .
        "* Unordered list \n" .
        "* Unordered list again \n\n" .
        "> This should be a blockquote.";
        $markOut = $myTextFilter->parse($markIn, "markdown");

        $nlIn = "This\r\nis\n\ra\nstring\r";
        $nlOut = $myTextFilter->parse($nlIn, "nl2br");


        $this->app->page->add("textfilter/index", [
            "bbOut" => $bbOut,
            "bbIn" => $bbIn,
            "clIn" => $clIn,
            "clOut" => $clOut,
            "markIn" => $markIn,
            "markOut" => $markOut,
            "nlIn" => $nlIn,
            "nlOut" => $nlOut,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
