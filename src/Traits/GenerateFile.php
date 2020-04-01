<?php


namespace Infinitypaul\LaravelDatabaseFilter\Traits;


use Illuminate\Support\Str;

trait GenerateFile
{

    /**
     * Get the path to where we should store the migration.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path() . '/app/Filters/' . $name . '.php';
    }


    /**
     * Build the directory for the class if necessary.
     *
     * @param  string $path
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }
    }

    protected function makeFilter(){
        if(is_array($this->argument('name'))){
            foreach ($this->argument('name') as $name) {
                $this->createFile($name);
            }
            return;
        }

        $this->createFile($this->argument('name'));

    }


    protected function createFile($name){
        if ($this->files->exists($path = $this->getPath($name))) {
            return $this->error($path . ' already exists!');
        }
        $this->makeDirectory($path);
        $this->files->put($path, $this->compileFilterStub($name));
        $this->info('Filter created successfully.');
        $this->composer->dumpAutoloads();
    }

    protected function compileFilterStub($name) {
        if($this->option('model')){
            $stub = $this->files->get($this->getModelStub());
        } else {
            $stub = $this->files->get($this->getStub());
        }
        $this->replaceClassName($stub, $name)->replaceNamespace($stub, $name);
        return $stub;
    }

    /**
     * Replace the class name in the stub.
     *
     * @param string $stub
     * @param $name
     *
     * @return $this
     */
    protected function replaceClassName(&$stub, $name)
    {
        $className = ucwords($this->camel($name));
        $className = $this->splitNamespace($className);
        $stub = str_replace('{{class}}', end($className), $stub);
        return $this;
    }

    /**
     * Splits the string into array based on
     * slash or backslash.
     *
     * @param  string $name
     * @return array
     */
    private function splitNamespace($name)
    {
        if(class_exists(Str::class)){
            $namespace = Str::contains($name, '\\');
        } else{
            $namespace = str_contains($name, '\\');
        }
        if ($namespace) {
            return explode('\\', $name);
        }

        return explode('/', $name);
    }

    /**
     * @param $stub
     * @param $name
     *
     * @return $this
     */
    protected function replaceNamespace (&$stub, $name)
    {
        $namespace = ucwords($this->camel($name));
        $namespace = $this->splitNamespace($namespace);
        if (count($namespace) > 1) {
            array_pop($namespace);
        }
        $namespace = '\\' . implode('\\', $namespace);
        //dd($namespace);
        //$stub = str_replace('{{namespace}}', $namespace, $stub);
        return $this;
    }


    private function camel($name){
        if(class_exists(Str::class)){
           return Str::camel($name);
        }
        return camel_case($name);
    }
}
