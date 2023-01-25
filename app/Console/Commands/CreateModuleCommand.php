<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Composer;
use Illuminate\Support\Str;

class CreateModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module
                    {name : Class (singular) for example User}
                    {--force : Overwrite existing directory and files by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'make module';

    /**
     * Create a new failed queue jobs table command instance.
     *
     * @param Filesystem $files
     * @param Composer $composer
     * @return void
     */
    public function __construct(Filesystem $files, Composer $composer)
    {
        parent::__construct();

        $this->files = $files;
        $this->composer = $composer;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $name = $this->argument('name');

        $this->createModuleFiles($name);

        $this->info('Module created successfully!');

        $this->composer->dumpAutoloads();

        \Cache::flush();

        return 0;
    }

    /**
     * get the given stub file content
     * @param string $stub
     * @return string
     * @throws FileNotFoundException
     */
    protected function getStub(string $stub): string
    {
        return $this->files->get(base_path("stubs/module/$stub"));
    }

    /**
     * create module files for the given name
     * @param string $name Class (singular) for example User
     * @return void
     */
    protected function createModuleFiles(string $name): void
    {
        $files = $this->getFiles($name);
        foreach ($files as $stub => $destination) {
            if (file_exists($destination) && !$this->option('force')) {
                if (!$this->confirm("The [{$destination}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            $this->createFile($name, $stub, $destination);
        }
    }

    /**
     * create file by the given info
     * @param string $name module name
     * @param $stub
     * @param $destination
     * @return void
     * @throws FileNotFoundException
     */
    public function createFile(string $name, $stub, $destination): void
    {
        $template = $this->fillPlaceholders($name, $stub);

        $this->createDirectory($destination);

        $this->files->put($destination, $template);
    }

    /**
     * return stub files info and creation destination path's
     * @param string $name module name
     * @return array
     */
    public function getFiles(string $name): array
    {
        return [
            'php/Model.stub' => app_path() . "/Models/" . $name . "/" . $name . ".php",
            'php/Relationship.stub' => app_path() . "/Models/" . $name . "/Relationships/" . $name . "Relationship.php",
            'php/Scope.stub' => app_path() . "/Models/" . $name . "/Scopes/" . $name . "Scope.php",
        ];
    }

    /**
     * fill the stub placeholders with the given name
     * @param string $name
     * @param string $stub
     * @return array|string|string[]
     * @throws FileNotFoundException
     */
    public function fillPlaceholders(string $name, string $stub): array|string
    {
        return str_replace(
            [
                '{{modelName}}',
                '{{modelNamePlural}}',
                '{{modelNamePluralLowerCase}}',
                '{{modelNameSingularLowerCase}}',
                '{{modelNameSingularKebabCase}}',
            ],
            [
                $name,
                Str::plural($name),
                Str::snake(Str::plural($name)),
                Str::snake($name),
                Str::snake($name),
            ],
            $this->getStub($stub)
        );
    }

    /**
     * Create the directories for the files.
     *
     * @param $filePath
     * @return void
     */
    protected function createDirectory($filePath): void
    {
        $directory = $this->files->dirname($filePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }
    }

}
