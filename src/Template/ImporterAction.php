<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class ImporterAction extends Layout
{
    protected function renderPage(Context $context): string
    {
        // TODO: Make a more global flash message management system

        $displayErrorAlert = empty($context->errorMessage) ? 'd-none' : '';

        // @codingStandardsIgnoreStart
        return <<<HTML
            <div class="alert alert-danger {$displayErrorAlert}">
                {$context->errorMessage}
            </div>
            <div class="alert alert-success">
                {$context->successMessage}
            </div>
            <a href="/import">Import new files</a>
HTML;
        // @codingStandardsIgnoreEnd
    }
}
