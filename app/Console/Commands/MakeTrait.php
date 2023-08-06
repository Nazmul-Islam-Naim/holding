<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeTrait extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:trait {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new trait';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = $this->argument('name');
        $traitName =  ucfirst($name);
        $directoryPath = app_path("Traits");
        $traitPath = app_path("Traits/{$traitName}.php");

        if (!File::exists($directoryPath)) {
            File::makeDirectory($directoryPath, $mode = 0755, $recursive = true);
        }

        if (file_exists($traitPath)) {
            $this->error("Trait '{$traitName}' already exists!");
            return;
        }

        $content = "<?php\n\nnamespace App\Traits;
            \n\ntrait {$traitName}\n{\n 
            // Add trait methods here\n}\n";
        
        file_put_contents($traitPath, $content);

        $this->info("Trait '{$traitName}' created successfully!");
    }
}
