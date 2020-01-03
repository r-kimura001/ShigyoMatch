<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateRepositoryFileCommand extends Command
{
  /**
   * @const string repository dir path
   */
  const REPOSITORIES_PATH = 'app/Repositories/';
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'make:repository {repositoryName : The name of repository}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Create repository files';

  /**
   * @var string
   */
  private $fileName;

  /**
   * @var string
   */
  private $dirName;

  /**
   * @var string
   */
  private $repositoryFileName;

  /**
   * @var string
   */
  private $interfaceFileName;

  /**
   * Create a new command instance.
   *
   * @return void
   */
  public function __construct()
  {
    parent::__construct();
  }

  /**
   * Execute the console command.
   *
   * @return mixed
   */
  public function handle()
  {
    $this->fileName = $this->argument('repositoryName');

    if (is_null($this->fileName)) {
      $this->error('Repository Name invalid');
    }
    $this->dirName = $this->ask('new directory name. or use directory name');

    if (is_null($this->dirName)) {
      $this->error('Directory required!');
    }

    if (!$this->isExistDirectory()) {
      $this->createDirectory();
    }

    $this->repositoryFileName = self::REPOSITORIES_PATH . $this->dirName . '/' . $this->fileName . 'Repository.php';
    $this->interfaceFileName = self::REPOSITORIES_PATH . $this->dirName . '/' . $this->fileName . 'Interface.php';
    if ($this->isExistFiles()) {
      $this->error('already exist');
      return;
    }

    $this->creatRepositoryFile();
    $this->createInterFaceFile();
    $this->info('create successfully');
  }

  /**
   * Repositoryのfileを作成する
   * @return void
   */
  private function creatRepositoryFile(): void
  {
    $content = "<?php\ndeclare(strict_types=1);\n\nnamespace App\\Repositories\\$this->dirName;\n\class $this->fileName" . "Repository implements $this->fileName" . "Interface\n{\n}\n";
    file_put_contents($this->repositoryFileName, $content);
  }

  /**
   * Interfaceのfileを作成する
   * @return void
   */
  private function createInterFaceFile(): void
  {
    $content = "<?php\ndeclare(strict_types=1);\n\nnamespace App\\Repositories\\$this->dirName;\n\ninterface $this->fileName" . "Interface\n{\n}\n";
    file_put_contents($this->interfaceFileName, $content);
  }

  /**
   * 同名fileの確認
   * @return bool
   */
  private function isExistFiles(): bool
  {
    return file_exists($this->repositoryFileName) && file_exists($this->interfaceFileName);
  }

  /**
   * directoryの存在確認
   * @return bool
   */
  private function isExistDirectory(): bool
  {
    return file_exists(self::REPOSITORIES_PATH . $this->dirName);
  }

  /**
   * 指定名でdirectoryの作成
   * @return void
   */
  private function createDirectory(): void
  {
    mkdir(self::REPOSITORIES_PATH . $this->dirName, 0755, true);
  }
}
