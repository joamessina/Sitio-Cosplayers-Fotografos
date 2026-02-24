<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Finder\Finder;

class MigrateStorageToR2 extends Command
{
    protected $signature = 'storage:migrate-r2';

    protected $description = 'Migra todos los archivos de storage/app/public/ a Cloudflare R2';

    public function handle()
    {
        $publicPath = storage_path('app/public');

        if (!is_dir($publicPath)) {
            $this->error("El directorio {$publicPath} no existe.");
            return 1;
        }

        $finder = Finder::create()->files()->in($publicPath);
        $total  = iterator_count($finder);

        if ($total === 0) {
            $this->info('No hay archivos para migrar.');
            return 0;
        }

        $this->info("Migrando {$total} archivo(s) a R2...");
        $bar = $this->output->createProgressBar($total);
        $bar->start();

        $success = 0;
        $errors  = 0;

        foreach (Finder::create()->files()->in($publicPath) as $file) {
            $relativePath = str_replace('\\', '/', $file->getRelativePathname());

            try {
                $contents = file_get_contents($file->getRealPath());

                Storage::disk('s3')->put($relativePath, $contents, 'public');

                $success++;
            } catch (\Throwable $e) {
                $errors++;
                $this->newLine();
                $this->error("Error subiendo {$relativePath}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Migración completada: {$success} subidos, {$errors} errores.");

        return $errors > 0 ? 1 : 0;
    }
}
