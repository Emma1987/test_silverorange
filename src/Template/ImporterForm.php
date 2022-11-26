<?php

namespace silverorange\DevTest\Template;

use silverorange\DevTest\Context;

class ImporterForm extends Layout
{
    protected function renderPage(Context $context): string
    {
        // @codingStandardsIgnoreStart
        return <<<HTML
            <form method="post" action="import-action/" enctype="multipart/form-data">
                <div class="frame">
                    <h2 class="frame__title">Import a list of post files</h2>
                    <div class="frame__contents">
                        <div class="form-field form-field--required">
                            <label class="form-field__label" for="files">Choose files to import: <span class="form-field__label-required"> (required)</span></label>
                            <div class="form-field__contents">
                                <input type="file" name="files[]" id="files" class="entry entry--files" accept="application/json" multiple />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-button">
                    <div class="text-center">
                        <button class="btn" type="submit">Import files</button>
                    </div>
                </div>
            </form>
HTML;
        // @codingStandardsIgnoreEnd
    }
}
