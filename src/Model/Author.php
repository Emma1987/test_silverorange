<?php

namespace silverorange\DevTest\Model;

class Author
{
    public string $id;
    public string $full_name;
    public string $created_at;
    public string $modified_at;

    public function __construct(string $id, string $full_name, string $created_at, string $modified_at)
    {
        $this->id = $id;
        $this->full_name = $full_name;
        $this->created_at = $created_at;
        $this->modified_at = $modified_at;
    }
}
