<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class StatCollector extends Command {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'stats:collect';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect and aggregate ad view and click stats.';

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
    public function fire()
    {


        set_time_limit(0);



        if(is_null($obj)){
            $product = new Product();
        }else{
            switch($obj){
                case 'product' :
                            $product = new Product();
                            break;
                case 'page' :
                            $product = new Page();
                            break;
                case 'post' :
                            $product = new Posts();
                            break;
                default :
                            $product = new Product();
                            break;
            }
        }

        $props = $product->orderBy('_id','desc')->get();




    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('object', InputArgument::REQUIRED, 'Parent object of picture to regenerate'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
        );
    }

}
