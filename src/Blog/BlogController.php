<?php
namespace Emau\Blog;

use Emau\TextFilter;
use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;
/**
* @SuppressWarnings(PHPMD.TooManyPublicMethods)
*/
class BlogController implements AppInjectableInterface
{
    use AppInjectableTrait;

    public function checkSlug($slug, $id)
    {
        $db = $this->app->db;
        $db->connect();
        if ($id > 0) {
            $sql = "SELECT COUNT(id) AS count FROM content WHERE slug LIKE ? AND id != ?;";
            $res = $db->executeFetchAll($sql, [$slug, $id]);
        } else {
            $sql = "SELECT COUNT(id) AS count FROM content WHERE slug LIKE ?;";
            $res = $db->executeFetchAll($sql, [$slug]);
        }
        return $res[0]->count;
    }

    public function checkPath($path, $id)
    {
        $db = $this->app->db;
        $db->connect();
        if ($id > 0) {
            $sql = "SELECT COUNT(id) AS count FROM content WHERE path LIKE ? AND id != ?;";
            $res = $db->executeFetchAll($sql, [$path, $id]);
        } else {
            $sql = "SELECT COUNT(id) AS count FROM content WHERE path LIKE ?;";
            $res = $db->executeFetchAll($sql, [$path]);
        }
        return $res[0]->count;
    }

    public function runTextFilters($text, $filterString)
    {
        $myTextFilter = new Emau\TextFilter\MyTextFilter();
        $filterArray = explode(",", $filterString);

        foreach ($filterArray as $filter) {
            $text = $myTextFilter->parse($text, $filter);
        }
        return $text;
    }

    /**
    * Adding an optional catchAll() method will catch all actions sent to the
    * router. You can then reply with an actual response or return void to
    * allow for the router to move on to next handler.
    * A catchAll() handles the following, if a specific action method is not
    * created:
    * ANY METHOD mountpoint/**
    *
    * @param array $args as a variadic parameter.
    *
    * @return mixed
    *
    * @SuppressWarnings(PHPMD.UnusedFormalParameter)
    */
    public function catchAll(...$args)
    {
        $title = "404 Page Not Found";

        $this->app->page->add("blog/blog_navbar");
        $this->app->page->add("blog/404");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function indexAction()
    {
        $title = "Blog";
        $this->app->page->add("blog/blog_navbar");

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $resultset = $this->app->db->executeFetchAll($sql);
        $this->app->page->add("blog/index", [
            "resultset" => $resultset
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function adminAction()
    {
        $title = "Admin";
        $this->app->page->add("blog/blog_navbar");

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $resultset = $this->app->db->executeFetchAll($sql);
        //var_dump($resultset);
        $this->app->page->add("blog/admin", [
            "resultset" => $resultset
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function addActionPost()
    {
        $req = $this->app->request;

        $title = $req->getPost("contentTitle");
        $path = $req->getPost("contentPath");
        $pathCount = $this->checkPath($path, 0);
        $slug = $req->getPost("contentSlug");
        $slugCount = $this->checkSlug($slug, 0);
        $data = $req->getPost("contentData");
        $type = $req->getPost("contentType");
        $filter = $req->getPost("contentFilter");

        $this->app->db->connect();
        if ($slugCount == 0 && $pathCount == 0) {
            $sql = "INSERT INTO content (title, path, slug, data, type, filter)
                VALUES (?, ?, ?, ?, ?, ?);";
            $this->app->db->executeFetchAll($sql, [$title, $path, $slug, $data, $type, $filter]);
            //var_dump($resultset);
            $this->app->response->redirect("blog/index");
        } else {
            $this->app->page->add("blog/blog_navbar");
            $this->app->page->add("blog/add", [
                "errorMsg" => "Duplicate Slug/Path"
            ]);
            return $this->app->page->render([
                "title" => "Create Blog Post",
            ]);
        }
    }

    public function addActionGet()
    {
        $title = "Create Blog Post";
        $this->app->page->add("blog/blog_navbar");
        $this->app->page->add("blog/add");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function deleteActionPost($id)
    {
        $this->app->db->connect();
        $id = $this->app->request->getPost("contentId");
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $this->app->db->execute($sql, [$id]);

        $this->app->response->redirect("blog/admin");
    }

    public function deleteActionGet($id)
    {
        $title = "Delete Blog Post";
        $this->app->page->add("blog/blog_navbar");

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM content WHERE id = ?";
        $res = $db->executeFetchAll($sql, [$id]);

        $this->app->page->add("blog/delete", [
            "content" => $res[0],
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function editActionPost($id)
    {
        $this->app->db->connect();

        $id = $this->app->request->getPost("contentId") ?: $this->app->request->getGet("contentId");
        $title = $this->app->request->getPost("contentTitle");
        $path = $this->app->request->getPost("contentPath");
        $pathCount = $this->checkPath($path, $id);
        $slug = $this->app->request->getPost("contentSlug");
        $slugCount = $this->checkSlug($slug, $id);
        $data = $this->app->request->getPost("contentData");
        $type = $this->app->request->getPost("contentType");
        $filter  = $this->app->request->getPost("contentFilter");

        if ($slugCount == 0 && $pathCount == 0) {
            $sql = "UPDATE content SET title = ?, path = ?, slug = ?, data = ?, type = ?, filter = ?, updated = NOW() WHERE id = ?";
            $this->app->db->execute($sql, [$title, $path, $slug, $data, $type, $filter, $id]);
            $this->app->response->redirect("blog/admin");
        } else {
            $this->app->page->add("blog/blog_navbar");
            $this->app->page->add("blog/edit", [
                "content" => (object)["id"=>$id, "title"=>$title, "path"=>$path, "slug"=>$slug, "data"=>$data, "type"=>$type, "filter"=>$filter],
                "errorMsg" => "Duplicate Slug/Path"
            ]);
            return $this->app->page->render([
                "title" => "Edit Blog Post",
            ]);
        }
    }

    public function editActionGet($id)
    {
        $title = "Edit Blog Post";
        $this->app->page->add("blog/blog_navbar");

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM content WHERE id = ?";
        $res = $db->executeFetchAll($sql, [$id]);

        $this->app->page->add("blog/edit", [
            "content" => $res[0],
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function pagesAction()
    {
        $title = "View Pages";
        $this->app->page->add("blog/blog_navbar");

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM content WHERE type LIKE 'page'";
        $res = $db->executeFetchAll($sql);

        $this->app->page->add("blog/pages", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function showPageAction($id)
    {
        $title = "Show Page";
        $this->app->page->add("blog/blog_navbar");

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM content WHERE id = ?";
        $res = $db->executeFetchAll($sql, [$id]);

        $res[0]->data = $this->runTextFilters($res[0]->data, $res[0]->filter);

        $this->app->page->add("blog/showPage", [
            "content" => $res[0],
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function postsAction()
    {
        $title = "View Posts";
        $this->app->page->add("blog/blog_navbar");

        $db = $this->app->db;
        $db->connect();

        $sql = "SELECT * FROM content WHERE type LIKE 'post' ORDER BY created DESC";
        $res = $db->executeFetchAll($sql);

        foreach ($res as $post) {
            $post->data = $this->runTextFilters($post->data, $post->filter);
        }

        //var_dump($res);
        $this->app->page->add("blog/posts", [
            "res" => $res,
        ]);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
