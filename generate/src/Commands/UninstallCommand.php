<?php

namespace Encore\Admin\Commands;

use Illuminate\Console\Command;

class UninstallCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'lagc:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the admin package';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (!$this->confirm('Are you sure to uninstall laravel-admin-generate-crud?')) {
            return;
        }

        $this->removeFilesAndDirectories();

        $this->line('<info>Uninstalling laravel-admin-generate-crud!</info>');
    }

    /**
     * Remove files and directories.
     *
     * @return void
     */
    protected function removeFilesAndDirectories()
    {
        $this->laravel['files']->deleteDirectory(config('generate.directory'));
    }
}
