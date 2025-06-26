<?php

/**
 * Custom PHP Runtime
 * Chạy các file PHP và luôn execute special_main.php cuối cùng
 */

class CustomPHPRuntime
{
    private $specialMainFile = 'special_main.php';
    private $globalState = [];
    private $executedFiles = [];

    public function __construct($specialMainPath = null)
    {
        if ($specialMainPath) {
            $this->specialMainFile = $specialMainPath;
        }
    }

    /**
     * Execute một file PHP trong cùng process
     */
    public function executeFile($filepath)
    {
        if (!file_exists($filepath)) {
            throw new Exception("File không tồn tại: $filepath");
        }

        // Lưu trữ thông tin file đã execute
        $this->executedFiles[] = $filepath;

        // Capture output nếu cần
        ob_start();

        try {
            // Include file trong scope hiện tại để chia sẻ variables
            include $filepath;
        } catch (Exception $e) {
            ob_end_clean();
            throw new Exception("Lỗi khi execute $filepath: " . $e->getMessage());
        }

        $output = ob_get_clean();
        return $output;
    }

    /**
     * Execute multiple files và special_main.php cuối
     */
    public function executeFiles($files)
    {
        $outputs = [];

        // Execute các file thường
        foreach ($files as $file) {
            echo "Executing: $file\n";
            $outputs[$file] = $this->executeFile($file);
        }

        // Luôn execute special_main.php cuối
        if (file_exists($this->specialMainFile)) {
            echo "Executing special main: {$this->specialMainFile}\n";
            $outputs[$this->specialMainFile] = $this->executeFile($this->specialMainFile);
        } else {
            echo "Warning: {$this->specialMainFile} không tồn tại\n";
        }

        return $outputs;
    }

    /**
     * Execute một file duy nhất + special_main
     */
    public function run($filepath)
    {
        return $this->executeFiles([$filepath]);
    }

    /**
     * Set global state có thể truy cập từ mọi file
     */
    public function setGlobalState($key, $value)
    {
        $this->globalState[$key] = $value;
        $GLOBALS['CUSTOM_RUNTIME_STATE'][$key] = $value;
    }

    /**
     * Get global state
     */
    public function getGlobalState($key = null)
    {
        if ($key === null) {
            return $this->globalState;
        }
        return isset($this->globalState[$key]) ? $this->globalState[$key] : null;
    }

    /**
     * Get danh sách files đã execute
     */
    public function getExecutedFiles()
    {
        return $this->executedFiles;
    }
}

// Tạo function helper để dễ sử dụng
function createCustomRuntime($specialMainPath = null)
{
    return new CustomPHPRuntime($specialMainPath);
}

// Command line interface
if (php_sapi_name() === 'cli' && basename(__FILE__) === basename($_SERVER['PHP_SELF'])) {
    if ($argc < 2) {
        echo "Sử dụng: php " . basename(__FILE__) . " <file_to_execute> [special_main_path]\n";
        echo "Ví dụ: php " . basename(__FILE__) . " test.php\n";
        echo "Ví dụ: php " . basename(__FILE__) . " test.php custom_special.php\n";
        exit(1);
    }

    $fileToExecute = $argv[1];
    $specialMainPath = isset($argv[2]) ? $argv[2] : 'special_main.php';

    try {
        $runtime = new CustomPHPRuntime($specialMainPath);

        // Set một số global state mẫu
        $runtime->setGlobalState('start_time', microtime(true));
        $runtime->setGlobalState('executed_by', 'CustomPHPRuntime');

        echo "=== Custom PHP Runtime Started ===\n";
        $outputs = $runtime->run($fileToExecute);

        echo "\n=== Runtime Info ===\n";
        echo "Executed files: " . implode(', ', $runtime->getExecutedFiles()) . "\n";
        echo "Total execution time: " . (microtime(true) - $runtime->getGlobalState('start_time')) . " seconds\n";
        echo "=== Custom PHP Runtime Finished ===\n";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
        exit(1);
    }
}
