<?php

namespace Danshin\Front\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Danshin\Front\Helpers\Config;

final class Routes extends Command
{
   /**
    * The name and signature of the console command.
   *
   * @var string
   */
   protected $signature = 'routes:json';

   protected $router;

   /**
    * The console command description.
   *
   * @var string
   */
   protected $description = 'Creates a json file containing routes';

   /**
    * Create a new command instance.
   *
   * @return void
   */
   public function __construct(Router $router)
   {
      parent::__construct();
      $this->router = $router;
   }

   /**
    * Execute the console command.
   *
   * @return mixed
   */
   public function handle()
   {
      File::put($this->getFileName(), json_encode($this->getRoutes(), JSON_PRETTY_PRINT));

      $this->info("routes:json completed successfully");
   }

   /**
    * @return string[]
    */
   private function getRoutes() : array
   {
      $routes = [];
      foreach( $this->router->getRoutes() as $route) {
         $routes[$route->getName()] = config('app.url')."/".$route->uri();
      }
      return $routes;
   }

   private function getFileName() : string
   {
      $file = require __DIR__.'/../../../config/app.php';
      $dir = "/../../../resources/js/";
      return  __DIR__.$dir.(Config::app('files.routes'));
   }
}