<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Template;

class ImporterForm extends Controller
{
    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Importer Form';
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\ImporterForm();
    }
}
