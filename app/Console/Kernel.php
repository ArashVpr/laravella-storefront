<?php

namespace App\Console;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Carbon;
use Throwable;

class Kernel extends ConsoleKernel
{
    /**
     * Create a new console kernel instance.
     */
    public function __construct(Application $app)
    {
        parent::__construct($app, $app['events']);
    }

    /**
     * Run the console application.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface|null  $output
     * @return int
     */
    public function handle($input, $output = null)
    {
        $this->commandStartedAt = Carbon::now();

        try {
            if (in_array($input->getFirstArgument(), ['env:encrypt', 'env:decrypt'], true)) {
                $this->bootstrapWithoutBootingProviders();
            }

            $this->bootstrap();

            $artisan = $this->getArtisan();
            foreach ($artisan->all() as $command) {
                if ($command instanceof \Illuminate\Console\Command) {
                    $command->setLaravel($this->app);
                }
            }

            return $artisan->run($input, $output);
        } catch (Throwable $e) {
            $this->reportException($e);

            $this->renderException($output, $e);

            return 1;
        }
    }
}
