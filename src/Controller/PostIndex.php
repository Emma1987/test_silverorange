<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Author;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;

class PostIndex extends Controller
{
    private array $posts = [];

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Posts';
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\PostIndex($this->posts);
    }

    protected function loadData(): void
    {
        $postRequest = $this->db->query('
            SELECT p.id AS post_id, p.title AS post_title, p.body AS post_body,
                    p.created_at AS post_created_at, p.modified_at AS post_modified_at,
                    a.id AS author_id, a.full_name AS author_full_name, a.created_at AS author_created_at,
                    a.modified_at AS author_modified_at
            FROM posts p
            JOIN authors a ON p.author = a.id
            ORDER BY p.created_at DESC
        ');
        $data = $postRequest->fetchAll();

        foreach ($data as $row) {
            // TODO: duplicated part, would need refactoring
            $author = new Author(
                $row['author_id'],
                $row['author_full_name'],
                $row['author_created_at'],
                $row['author_modified_at']
            );
            $post = new Post(
                $row['post_id'],
                $row['post_title'],
                $row['post_body'],
                $row['post_created_at'],
                $row['post_modified_at'],
                $author
            );

            $this->posts[] = $post;
        }
    }
}
