<?php

namespace Danshin\Front\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\File;
use Danshin\Front\Helpers\Config;

final class Lang extends Command
{
   /**
    * The name and signature of the console command.
   *
   * @var string
   */
   protected $signature = 'lang:json {file}';

   /**
    * The console command description.
   *
   * @var string
   */
   protected $description = 'Creates a json file containing lang';

   /**
    * Execute the console command.
   *
   * @return mixed
   */
   public function handle()
   {
      $file = $this->argument('file');
      $this->verifyFile($file);
      $fileNameSource = $this->getFileNameSource($file);
      $array = $this->getArray($fileNameSource);

      $filaNameTarget = $this->getFileNameTarget($file);

      $this->createFileTarget($filaNameTarget, $array);

      $this->info("lang:json OK");
   }

   private function getArray(string $fileName) : array
   {
      $array = require $fileName;
      if (!is_array($array)) {
         $this->info("Exception");
         throw new \Exception("content file: $path not is array");
      }
      return $array;
   }

   private function getFileNameSource(string $file) : string
   {
      $locale = App::getLocale();
      if ($locale === null) {
         $this->info("Exception");
         throw new \Exception("Unable to determine the localization");
      }

      if ($locale != "ru" && $locale != "en") {
         $this->info("Exception");
         throw new \Exception("Unsupportede the localization");
      }

      $dir = resource_path("lang/$locale");

      $path = "$dir/$file.php";

      if(!File::exists($path)) {
         $this->info("Exception");
         throw new \Exception("the file: $path does not exist");
      }

      return $path;
   }

   private function verifyFile(?string $file)
   {
      if ($file === null) {
         $this->info("Exception");
         throw new \Exception("the file name is missing");
      }
   }

   private function getFileNameTarget(string $file) : string
   {
      $partPath = Config::app('dir.lang')."/".$file.".json";
      return resource_path($partPath);
   }

   private function createFileTarget(string $fileName, array $content)
   {
      $dir = File::dirname($fileName);
      if(!File::exists($dir)) {
         File::makeDirectory($dir);
      }
      
      File::put($fileName, json_encode($content, JSON_PRETTY_PRINT));
   }
}