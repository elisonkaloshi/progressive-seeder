<?php

namespace Elison\ProgressiveSeeder\Console\Commands;

use Elison\ProgressiveSeeder\Models\SeederHistory;
use Illuminate\Console\Command;

class ProgressiveSeederCommand extends Command
{
    protected $signature = 'progressive-seeder:run {class_name?}';

    protected $description = 'Run newest seeders automatically';

    public function handle()
    {
        $className = $this->argument('class_name');

        if ($className) {
            $this->addClassToSeedersHistory($className);
        } else {
            $this->info('Running seeders...');

            $alreadyRunClassNames = SeederHistory::query()
                ->pluck('class_name')
                ->toArray();
                
            $alreadyRunClassNames[] = 'DatabaseSeeder';

            $allClassNames = $this->getAllClassNamesFromSeedersFolder();

            foreach ($allClassNames as $className) {
                if (! in_array($className, $alreadyRunClassNames)) {
                    $this->call("Database\Seeders\\" . $className);
                    $this->info('Seeder executed: ' . $className);
                    
                    $this->addClassToSeedersHistory($className);
                }
            }
        }
    }

    private function addClassToSeedersHistory($className)
    {
        SeederHistory::query()
            ->create([
                'class_name' => $className
            ]);

        $this->info('Class Added Successfully');
    }

    private function getAllClassNamesFromSeedersFolder(): array
    {
        $allFileNames = \File::files('database/seeders');
        $allClassNames = [];

        foreach ($allFileNames as $fileName) {
            $allClassNames[] = pathinfo($fileName)['filename'];
        }

        return $allClassNames;
    }
}
