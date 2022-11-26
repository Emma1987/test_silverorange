<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Author;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;

class PostDetails extends Controller
{
    private ?Post $post = null;

    public function getContext(): Context
    {
        $context = new Context();

        if ($this->post === null) {
            $context->title = 'Not Found';
            $context->content = "A post with id {$this->params[0]} was not found.";
        } else {
            $context->title = $this->post->title;
        }

        return $context;
    }

    public function getTemplate(): Template\Template
    {
        if ($this->post === null) {
            return new Template\NotFound();
        }

        return new Template\PostDetails($this->post);
    }

    public function getStatus(): string
    {
        if ($this->post === null) {
            return $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found';
        }

        return $_SERVER['SERVER_PROTOCOL'] . ' 200 OK';
    }

    protected function loadData(): void
    {
        $postRequest = $this->db->prepare('
            SELECT p.id AS post_id, p.title AS post_title, p.body AS post_body,
                    p.created_at AS post_created_at, p.modified_at AS post_modified_at,
                    a.id AS author_id, a.full_name AS author_full_name, a.created_at AS author_created_at,
                    a.modified_at AS author_modified_at
            FROM posts p
            JOIN authors a ON p.author = a.id
            WHERE p.id = :id
        ');
        $postRequest->bindValue(':id', $this->params[0], \PDO::PARAM_STR);
        $postRequest->execute();
        $data = $postRequest->fetch();

        $author = new Author(
            $data['author_id'],
            $data['author_full_name'],
            $data['author_created_at'],
            $data['author_modified_at']
        );
        $post = new Post(
            $data['post_id'],
            $data['post_title'],
            $data['post_body'],
            $data['post_created_at'],
            $data['post_modified_at'],
            $author
        );

        $this->post = $post;
    }
}
