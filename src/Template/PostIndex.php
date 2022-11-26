<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class PostIndex extends Layout
{
    private array $posts = [];

    public function __construct(array $posts)
    {
        parent::__construct();
        $this->posts = $posts;
    }

    protected function renderPage(Context $context): string
    {
        // @codingStandardsIgnoreStart
        $render = <<<HTML
            <h1 class="frame__title">Posts list</h1>
HTML;

        if (empty($this->posts)) {
            $render .= <<<HTML
                <div>
                    No article has been posted yet. Stayned tuned <i class="fa-regular fa-face-smile"></i>
                </div>
HTML;
        } else {
            foreach ($this->posts as $post) {
                $render .= <<<HTML
                    <div class="frame">
                        <h2 class="frame__title">{$post->title}</h2>
                        <div class="frame__contents">
                            <div>Publié par {$post->author->full_name}</div>
                            <hr>
                            <a href="/posts/{$post->id}">See post</a>
                        </div>
                    </div>
HTML;
            }
        }

        // @codingStandardsIgnoreEnd
        return $render;
    }
}
