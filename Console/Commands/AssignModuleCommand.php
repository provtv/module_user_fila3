<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

use Modules\User\Models\Role;
use Modules\User\Models\User;
use Nwidart\Modules\Facades\Module;
use Symfony\Component\Console\Input\InputOption;
use Webmozart\Assert\Assert;

class AssignModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:assign-module';

    /**
     * The console command description.
     */
    protected string $description = 'Assign a module to user';

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
     */
    public function handle(): void
    {
        $email = text('email ?');
        Assert::notNull($user = User::firstWhere(['email' => $email]));
        /*
        $modules = collect(Module::all())->map(function ($module) {
            return $module->getName();
        })->toArray();
        */
        $modules_opts = array_keys(Module::all());
        $modules_opts = array_combine($modules_opts, $modules_opts);

        $modules = multiselect(
            label: 'What modules',
            options: $modules_opts,
            required: true,
            scroll: 10,
            // validate: function (array $values) {
            //  return ! \in_array(\count($values), [1, 2], true)
            //    ? 'A maximum of two'
            //  : null;
            // }
        );

        foreach ($modules as $module) {
            $module_low = Str::lower((string) $module);
            $role = $module_low.'::admin';
            $role = Role::firstOrCreate(['name' => $role]);
            $user->assignRole($role);
        }

        $this->info(implode(', ', $modules).' assigned to '.$email);
    }

    /**
     * Get the console command options.
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
