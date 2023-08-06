<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeInterface extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new interface';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $interfaceName =  ucfirst($name);
        $interfacePath = app_path("Contracts/{$interfaceName}.php");

        if (file_exists($interfacePath)) {
            $this->error("Interface '{$interfaceName}' already exists!");
            return;
        }

        $content = "<?php\n\nnamespace App\Contracts;
            \n\ninterface {$interfaceName}\n{\n 
            // Add interface methods here\n}\n";
        
        file_put_contents($interfacePath, $content);

        $this->info("Interface '{$interfaceName}' created successfully!");

    }
}
