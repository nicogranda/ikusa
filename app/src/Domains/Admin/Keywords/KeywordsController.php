<?php
class KeywordsController
{
    public function index(): void
    {
        include dirname(__DIR__, 5) . '/app/src/Domains/Admin/Keywords/views/index.php';
    }

    public function suggest(): void
    {
        while (ob_get_level()) ob_end_clean();
        header('Content-Type: application/json');

        $niche    = escapeshellarg(trim($_POST['niche']    ?? ''));
        $city     = escapeshellarg(trim($_POST['city']     ?? ''));
        $province = escapeshellarg(trim($_POST['province'] ?? ''));
        $lang     = escapeshellarg(trim($_POST['lang']     ?? 'es'));
        $country  = escapeshellarg(trim($_POST['country']  ?? 'es'));

        if (!$niche || $niche === "''") {
            echo json_encode(['error' => 'El nicho es obligatorio']);
            return;
        }

        $script = '/home/ot2ryobi838h/app/tools/keyword_suggest.py';
        $cmd    = "/bin/python3 {$script} {$niche} {$city} {$province} {$lang} {$country} 2>&1";
        $output = shell_exec($cmd);

        $data = json_decode($output, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo json_encode(['error' => 'Error en el script', 'raw' => $output]);
            return;
        }

        echo json_encode($data);
        exit;
    }
}
