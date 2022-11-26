<?php

namespace silverorange\DevTest\Model;

class Post
{
    public string $id;
    public string $title;
    public string $body;
    public string $created_at;
    public string $modified_at;
    public ?Author $author;

    public function __construct(
        string $id,
        string $title,
        string $body,
        string $created_at,
        string $modified_at,
        ?Author $author
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->created_at = $created_at;
        $this->modified_at = $modified_at;
        $this->author = $author;
    }
}
