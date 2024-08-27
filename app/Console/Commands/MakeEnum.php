<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeEnum extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:enum {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new enum class';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');

        $filesystem = new Filesystem();

        $path = app_path('Enums');

        if (! $filesystem->exists($path)) {
            $filesystem->makeDirectory($path, 0755, true);
        }

        $enumTemplate = "<?php\n\nnamespace App\Enums;\n\nenum {$name}\n{\n    case Example = 'example';\n}\n";

        $filesystem->put("{$path}/{$name}.php", $enumTemplate);

        $this->info("Enum {$name} created successfully.");

        return 0;
    }
}
