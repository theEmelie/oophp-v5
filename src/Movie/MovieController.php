<?php
namespace Emau\Movie;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
* A sample controller to show how a controller class can be implemented.
* The controller will be injected with $app if implementing the interface
* AppInjectableInterface, like this sample class does.
* The controller is mounted on a particular route and can then handle all
* requests for that mount point.
*
* @SuppressWarnings(PHPMD.TooManyPublicMethods)
*/

class MovieController implements AppInjectableInterface
{
    use AppInjectableTrait;
    /**
    * @var string $db a sample member variable that gets initialised
    */
    // private $db = "not active";
    /**
    * The initialize method is optional and will always be called before the
    * target method/action. This is a convienient method where you could
    * setup internal properties that are commonly used by several methods.
    *
    * @return void
    */
    // public function initialize() : void
    // {
    //     // Use to initialise member variables.
    //     $this->db = "active";
    //     // Use $this->app to access the framework services.
    // }
    /**
    * This is the index method action, it handles:
    * ANY METHOD mountpoint
    * ANY METHOD mountpoint/
    * ANY METHOD mountpoint/index
    *
    * @return string
    */

    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return "active";
    }

    /**
    * Help function to add a navbar
    */
    public function addMovieNavbar()
    {
        $this->app->page->add("movie/movie_navbar");
    }

    /**
    * Show all movies.
    */
    public function initAction()
    {
        $title = "Movie database";
        $this->addMovieNavbar();
        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $this->app->page->add("movie/movie_first");

        $this->app->page->add("movie/movie_table", [
            "resultset" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function searchTitleAction()
    {
        $title = "Search";
        $this->app->db->connect();
        $this->addMovieNavbar();
        $searchTitle = $this->app->request->getGet("searchTitle");
        if ($searchTitle) {
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$searchTitle]);
            $this->app->page->add("movie/search_title", [
                "searchTitle" => $searchTitle
            ]);
            $this->app->page->add("movie/movie_table", [
                "resultset" => $res,
            ]);
        } else {
            $this->app->page->add("movie/search_title", [
                "searchTitle" => $searchTitle
            ]);
        }
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function searchYearAction()
    {
        $title = "Search";
        $this->app->db->connect();
        $this->addMovieNavbar();

        $year1 = $this->app->request->getGet("year1");
        $year2 = $this->app->request->getGet("year2");
        if ($year1 && $year2) {
            $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
            $this->app->page->add("movie/search_year", [
                "year1" =>  $year1,
                "year2" =>  $year2
            ]);
            $this->app->page->add("movie/movie_table", [
                "resultset" => $resultset,
            ]);
        } elseif ($year1) {
            $sql = "SELECT * FROM movie WHERE year >= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year1]);
            $this->app->page->add("movie/search_year", [
                "year1" =>  $year1,
                "year2" =>  $year2
            ]);
            $this->app->page->add("movie/movie_table", [
                "resultset" => $resultset,
            ]);
        } elseif ($year2) {
            $sql = "SELECT * FROM movie WHERE year <= ?;";
            $resultset = $this->app->db->executeFetchAll($sql, [$year2]);
            $this->app->page->add("movie/search_year", [
                "year1" =>  $year1,
                "year2" =>  $year2
            ]);
            $this->app->page->add("movie/movie_table", [
                "resultset" => $resultset,
            ]);
        } else {
            $this->app->page->add("movie/search_year", [
                "year1" =>  $year1,
                "year2" =>  $year2
            ]);
        }
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function addMovieActionPost()
    {
        $title = "Add Movie";
        $this->app->db->connect();
        $this->addMovieNavbar();
        $req = $this->app->request;

        $movieTitle = $req->getPost("movieTitle");
        $movieYear = $req->getPost("movieYear");
        $movieImage = $req->getPost("movieImage");
        $movieDirector = $req->getPost("movieDirector");
        $moviePlot = $req->getPost("movieTitle");
        $movieLength = $req->getPost("movieLength");
        $movieSubtext = $req->getPost("movieSubtext");
        $movieSpeech = $req->getPost("movieSpeech");
        $movieQuality = $req->getPost("movieQuality");
        $movieFormat = $req->getPost("movieFormat");

        $sql = "INSERT INTO `movie` (`title`, `year`, `image`, `director`, `plot`,
            `length`, `subtext`, `speech`, `quality`, `format`)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->app->db->executeFetchAll($sql, [$movieTitle, $movieYear, $movieImage,
            $movieDirector, $moviePlot, $movieLength, $movieSubtext, $movieSpeech, $movieQuality,
            $movieFormat]);

            $this->app->page->add("movie/movie_add");

            return $this->app->page->render([
                "title" => $title,
            ]);
    }

    public function addMovieActionGet()
    {
        $title = "Add Movie";
        $this->addMovieNavbar();
        $this->app->page->add("movie/movie_add");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editMovieActionGet($movieId)
    {
        $title = "Edit Movie";
        $this->addMovieNavbar();

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM movie WHERE id = ?";
        $res = $db->executeFetchAll($sql, [$movieId]);
        $this->app->page->add("movie/movie_edit", [
            "res" => $res

        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editMovieActionPost($movieId)
    {
        $db = $this->app->db;

        $db->connect();

        $movieId    = $this->app->request->getPost("movieId") ?: $this->app->request->getGet("movieId");
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear  = $this->app->request->getPost("movieYear");
        if ($movieYear == "") {
            $movieYear = 0;
        }
        $movieImage = $this->app->request->getPost("movieImage");
        $movieDirector = $this->app->request->getPost("movieDirector");
        $moviePlot = $this->app->request->getPost("moviePlot");
        $movieLength  = $this->app->request->getPost("movieLength");
        if ($movieLength == "") {
            $movieLength = 0;
        }
        $movieSubtext = $this->app->request->getPost("movieSubtext");
        $movieSpeech = $this->app->request->getPost("movieSpeech");
        $movieQuality = $this->app->request->getPost("movieQuality");
        $movieFormat = $this->app->request->getPost("movieFormat");

        if ($this->app->request->getPost("doSave")) {
            $sql = "UPDATE movie SET title = ?, year = ?, image = ?, director = ?, plot = ?,
            length = ?, subtext = ?, speech = ?, quality = ?, format = ? WHERE id = ?;";
            $db->executeFetchAll($sql, [$movieTitle, $movieYear, $movieImage, $movieDirector,
            $moviePlot, $movieLength, $movieSubtext, $movieSpeech, $movieQuality, $movieFormat, $movieId]);
        }

        $this->app->response->redirect("movie_first/viewMovie/" . $movieId);
    }

    public function viewMovieAction($movieId)
    {
        $title = "View Movie";
        $this->addMovieNavbar();

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM movie WHERE id = ?";
        $res = $db->executeFetchAll($sql, [$movieId]);
        $this->app->page->add("movie/movie_view", [
            "res" => $res

        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteMovieActionGet($movieId)
    {
        $title = "Delete Movie";
        $this->addMovieNavbar();

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM movie WHERE id = ?";
        $res = $db->executeFetchAll($sql, [$movieId]);
        $this->app->page->add("movie/movie_view", [
            "res" => $res

        ]);
        $this->app->page->add("movie/movie_delete", [
            "res" => $res

        ]);
        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteMovieActionPost($movieId)
    {
        $db = $this->app->db;
        $db->connect();

        $movieId = $this->app->request->getPost("movieId");
        $sql = "DELETE FROM movie WHERE id = ?";
        $db->executeFetchAll($sql, [$movieId]);

        $this->app->response->redirect("movie_first/init");
    }
}
