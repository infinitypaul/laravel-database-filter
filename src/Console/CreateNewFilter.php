<?php

namespace Infinitypaul\LaravelDatabaseFilter\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Infinitypaul\LaravelDatabaseFilter\Traits\GenerateFile;

class CreateNewFilter extends Command
{
    use GenerateFile;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:filter {name} {--model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create A New Filter';
    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $files;

    private $composer;

    /**
     * Create a new command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $filesystem
     */
    public function __construct(Filesystem $filesystem)
    {
        parent::__construct();
        $this->files = $filesystem;
        $this->composer = app()['composer'];
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->makeFilter();
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getModelStub()
    {
        return __DIR__.'/../stubs/model-filter.stub';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/filter.stub';
    }
}
