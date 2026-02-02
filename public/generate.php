<?php
// public/generate.php

define('BASE_PATH', realpath(__DIR__ . '/..'));

require_once BASE_PATH . '/lib/TemplateEngine.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$template = $_POST['template'] ?? '';

function zipFolder(string $source, string $zipPath): void
{
    $zip = new ZipArchive();

    if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
        throw new Exception('Failed to create zip file');
    }

    $files = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );

    foreach ($files as $file) {
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($source) + 1);

        if ($file->isDir()) {
            $zip->addEmptyDir($relativePath);
        } else {
            $zip->addFile($filePath, $relativePath);
        }
    }

    $zip->close();
}

try {
    switch ($template) {
        case 'escrow':
            $path = TemplateEngine::generateEscrow();
            break;

        case 'vault':
            $path = TemplateEngine::generateVault();
            break;

        case 'multisig':
            $path = TemplateEngine::generateMultisig();
            break;
            
        case 'subscription':
            $path = TemplateEngine::generateSubscription();
            break;

        default:
            throw new Exception('Invalid template selected');
    }

    // ✅ ZIP handling
    $downloadDir = BASE_PATH . '/public/downloads';
    if (!is_dir($downloadDir)) {
        mkdir($downloadDir, 0777, true);
    }

    $zipName = basename($path) . '.zip';
    $zipPath = $downloadDir . '/' . $zipName;

    zipFolder($path, $zipPath);

} catch (Exception $e) {
    http_response_code(500);
    echo "<h3>Error</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Program Generated • Solana Builder</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: Inter, system-ui, -apple-system, sans-serif;
            background: radial-gradient(
                1000px 500px at top,
                rgba(153,69,255,0.15),
                #0b0f1a
            );
            color: #e5e7eb;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 24px;
        }

        .card {
            background: #111827;
            border: 1px solid #1f2937;
            border-radius: 16px;
            padding: 32px;
            max-width: 520px;
            width: 100%;
            box-shadow: 0 0 30px rgba(0,0,0,0.4);
        }

        h2 {
            margin-top: 0;
            text-align: center;
            font-size: 22px;
        }

        .success {
            text-align: center;
            font-size: 14px;
            color: #14F195;
            margin-bottom: 20px;
        }

        .label {
            font-size: 13px;
            color: #9ca3af;
            margin-bottom: 6px;
        }

        pre {
            background: #020617;
            border: 1px solid #1f2937;
            padding: 12px;
            border-radius: 10px;
            font-size: 12px;
            overflow-x: auto;
            margin-bottom: 20px;
        }

        .download {
            display: block;
            text-align: center;
            padding: 14px;
            border-radius: 12px;
            background: linear-gradient(90deg, #9945FF, #14F195);
            color: #020617;
            font-weight: 600;
            text-decoration: none;
            margin-bottom: 24px;
        }

        .download:hover {
            opacity: 0.9;
        }

        ul {
            padding-left: 20px;
            font-size: 14px;
            color: #cbd5f5;
        }

        code {
            background: #020617;
            padding: 2px 6px;
            border-radius: 6px;
            font-size: 13px;
        }

        .back {
            display: block;
            margin-top: 24px;
            text-align: center;
            font-size: 13px;
            color: #9ca3af;
            text-decoration: none;
        }

        .back:hover {
            color: #e5e7eb;
        }
    </style>
</head>
<body>

<div class="card">
    <div class="success">✅ Program generated successfully</div>

    <h2>Your Solana Program Is Ready</h2>

    <div class="label">Generated folder</div>
    <pre><?= htmlspecialchars($path) ?></pre>

    <a class="download" href="downloads/<?= htmlspecialchars($zipName) ?>" download>
        ⬇ Download Program ZIP
    </a>

    <div class="label">Next steps</div>
    <ul>
        <li>Unzip on a machine with Solana & Anchor</li>
        <li>Run <code>anchor build</code></li>
        <li>Deploy to devnet or mainnet</li>
    </ul>

    <a class="back" href="index.php">← Generate another program</a>
</div>

</body>
</html>