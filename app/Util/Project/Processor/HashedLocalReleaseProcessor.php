<?php

namespace EmergencyExplorer\Util\Project\Processor;

use Carbon\Carbon;
use EmergencyExplorer\Models\Release;
use Symfony\Component\HttpFoundation\File\File;

class HashedLocalReleaseProcessor implements ReleaseProcessor
{
    const IDENTIFIER = 'hash';

    /**
     * Get a download link for a release
     *
     * @param Release $toRelease
     * @param Release $fromRelease
     *
     * @return string
     * @throws \Exception
     */
    public function url(Release $toRelease, Release $fromRelease = null): string
    {
        $upgrade = false;
        $fromName = 'null';
        $toName = $toRelease->provider['t'];
        if ($fromRelease) {
            if ($fromRelease->provider['p'] !== $toRelease->provider['p']) {
                throw new \Exception('Invalid upgrade path (different processors)');
            }
            $upgrade = true;
            $fromName = $fromRelease->provider['t'];
        }

        $downloadName = (string)($upgrade ? $fromRelease->getKey() : 'initial') . '-to-' . $toRelease->getKey();
        $generatedPath = app_path('../../emx-packer/upgrades/' . $downloadName . '.tar.gz');
        $publicPath = public_path('storage/mods/' . $downloadName . '.tar.gz');

        if (! file_exists($publicPath)) {
            chdir(app_path('../../emx-packer/'));
            $command = sprintf('node upgrade.js --from=%s --to=%s --name=%s --gzip', $fromName, $toName, $downloadName);
            exec($command);
            copy($generatedPath, $publicPath);
            //unlink($generatedPath);
        }

        return asset('storage/mods/' . $downloadName . '.tar.gz');
    }

    /**
     * @param File $file
     *
     * @return Release
     * @throws \Exception
     */
    public function store(File $file): Release
    {
        $token = $this->generateFilename();
        $filename = $token . '.' . $file->guessExtension();
        $file->move(storage_path('ingress'), $filename);
        $path = storage_path('ingress/' . $filename);

        chmod($path, 0644);

        $release = new Release;
        $release->provider = [
            's' => 1,                   //status
            't' => $token,           //token
            'p' => self::IDENTIFIER,    //
        ];

        logger()->info('Incoming release saved in ingress folder', $release->toArray());

        //TODO: IMPORTANT: REMOVE EXEC HERE!
        if (! env('APP_DEBUG', false)) {
            throw new \Exception('Do not use exec() in production');
        }

        logger()->alert('REMOVE EXEC AND USE A MESSAGE QUEUE OR SIMILAR TO COMMUNICATE');

        $cwd = getcwd();
        chdir(app_path('../../emx-packer/'));
        logger(getcwd());
        $command = sprintf('node index.js --file="%s" --name=%s', $path, $token);
        logger($command);
        $out = array();
        logger(exec($command, $out));
        logger(implode("\n", $out));

        return $release;
    }

    /**
     * @return string
     */
    protected function generateFilename()
    {
        return md5(time() . str_random(24));
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function remove(Release $release): bool
    {
        $filename = $release->provider['t'];
        $path = public_path('storage/mods/' . substr($filename, 0, 2) . '/' . $filename);
        @unlink($path);

        return $release->delete();
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function publish(Release $release): bool
    {
        return true;
    }

    /**
     * @param Release $release
     *
     * @return bool
     */
    public function unpublish(Release $release): bool
    {
        return true;
    }
}