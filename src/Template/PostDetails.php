<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Post;

class PostDetails extends Layout
{
    private Post $post;

    public function __construct(Post $post)
    {
        parent::__construct();
        $this->post = $post;
    }

    protected function renderPage(Context $context): string
    {
        $parser = new \Parsedown();
        $body = $parser->text($this->post->body);

        // @codingStandardsIgnoreStart
        return <<<HTML
            <div class="frame">
                <h2 class="frame__title">{$this->post->title}</h2>
                <div class="frame__contents">
                    <div>Publié par {$this->post->author->full_name}</div>
                    <hr>
                    <div>{$body}</div>
                </div>
            </div>
            <a href="/posts/">Go back</a>
HTML;
        // @codingStandardsIgnoreEnd
    }
}
