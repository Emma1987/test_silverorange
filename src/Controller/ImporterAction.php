<?php

namespace silverorange\DevTest\Controller;

use silverorange\DevTest\Context;
use silverorange\DevTest\Model\Post;
use silverorange\DevTest\Template;

class ImporterAction extends Controller
{
    private string $errorMessage = '';
    private string $successMessage = '';

    public function getContext(): Context
    {
        $context = new Context();
        $context->title = 'Post Importer';
        $context->errorMessage = $this->errorMessage;
        $context->successMessage = $this->successMessage;
        return $context;
    }

    public function getTemplate(): Template\Template
    {
        return new Template\ImporterAction();
    }

    public function loadData(): void
    {
        // Set in the router
        $files = $this->params;
        $errors = [];
        $count = 0;

        foreach ($files['tmp_name'] as $file) {
            $content = file_get_contents($file);
            $arrayContent = json_decode($content, true);

            $key = array_keys($arrayContent);
            $postProperties = array_keys(get_class_vars(Post::class));

            if (!empty($diff = array_diff($postProperties, $key))) {
                $errors[] = sprintf(
                    'Key(s) %s  missing from the file ' . $file,
                    implode(', ', $diff)
                );
                continue;
            }

            try {
                $this->populateDatabase($arrayContent);
            } catch (\Exception $e) {
                $errors[] = sprintf(
                    'Something went wrong while inserting data from the file ' . $file . ': %s',
                    $e->getMessage()
                );
                continue;
            }

            $count++;
        }

        if (!empty($errors)) {
            $this->errorMessage = sprintf(
                '%d errors have been detected during the import: %s',
                count($errors),
                implode(', ', $errors)
            );
        }

        $this->successMessage = sprintf('%d post(s) have been inserted', $count);
    }

    private function populateDatabase(array $data): void
    {
        $request = $this->db->prepare(
            'INSERT INTO posts (id, title, body, created_at, modified_at, author)
            VALUES (:id, :title, :body, :created_at, :modified_at, :author)'
        );

        $request->bindValue(':id', $data['id'], \PDO::PARAM_STR);
        $request->bindValue(':title', $data['title'], \PDO::PARAM_STR);
        $request->bindValue(':body', $data['body'], \PDO::PARAM_STR);
        $request->bindValue(':created_at', $data['created_at']);
        $request->bindValue(':modified_at', $data['modified_at']);
        $request->bindValue(':author', $data['author'], \PDO::PARAM_STR);

        $request->execute();
    }
}
