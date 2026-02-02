<?php

class TemplateEngine
{
    /* ===============================
       PUBLIC GENERATORS
    =============================== */

    public static function generateEscrow(): string
    {
        return self::generateFromTemplate('escrow');
    }

    public static function generateVault(): string
    {
        return self::generateFromTemplate('vault');
    }

    public static function generateMultisig(): string
    {
        return self::generateFromTemplate('multisig');
    }

    public static function generateSubscription(): string
    {
        return self::generateFromTemplate('subscription');
    }

    public static function generateStaking(): string
    {
        return self::generateFromTemplate('staking');
    }
    
    public static function generateRewardDistributor(): string
    {
        return self::generateFromTemplate('reward_distributor');
    }

    public static function generateDeviceRegistry(): string
    {
        return self::generateFromTemplate('device_registry');
    }

    /* ===============================
       CORE GENERATOR
    =============================== */

    private static function generateFromTemplate(string $type): string
    {
        $programId = self::generateProgramId();

        $templateDir = BASE_PATH . "/templates/$type/anchor";
        $outputDir   = BASE_PATH . "/storage/generated/{$type}_" . time();

        if (!is_dir($templateDir)) {
            throw new Exception("Template directory not found: $templateDir");
        }

        if (!mkdir($outputDir, 0777, true) && !is_dir($outputDir)) {
            throw new Exception("Failed to create output directory: $outputDir");
        }

        self::copyDirectory($templateDir, $outputDir, [
            '{{PROGRAM_ID}}'   => $programId,
            '{{PROGRAM_NAME}}' => $type
        ]);

        return $outputDir;
    }

    /* ===============================
       FILE SYSTEM UTILITIES
    =============================== */

    private static function copyDirectory(
        string $source,
        string $destination,
        array $replacements = []
    ): void {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $item) {
            $targetPath = $destination . DIRECTORY_SEPARATOR
                . $iterator->getSubPathName();

            if ($item->isDir()) {
                if (!is_dir($targetPath)) {
                    mkdir($targetPath, 0777, true);
                }
            } else {
                $content = file_get_contents($item->getPathname());
                if ($content === false) {
                    throw new Exception('Failed to read file: ' . $item->getPathname());
                }

                $content = str_replace(
                    array_keys($replacements),
                    array_values($replacements),
                    $content
                );

                if (file_put_contents($targetPath, $content) === false) {
                    throw new Exception('Failed to write file: ' . $targetPath);
                }
            }
        }
    }

    /* ===============================
       HELPERS
    =============================== */

    private static function generateProgramId(): string
    {
        // Placeholder – replaced after anchor deploy
        return '{{PROGRAM_ID}}';
    }
}
