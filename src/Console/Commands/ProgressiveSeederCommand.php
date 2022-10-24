<?php

namespace Elison\ProgressiveSeeder\Console\Commands;

use App\Models\SeederHistory;
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

            $allClassNames = $this->getAllClassNamesFromSeedersFolder();

            foreach ($allClassNames as $className) {
                if (! in_array($className, $alreadyRunClassNames)) {
                    $this->call("Database\Seeders\\" . $className);
                    $this->info('Seeder executed: ' . $className);
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
