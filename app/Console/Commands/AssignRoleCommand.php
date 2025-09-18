<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\User\Models\Role;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Symfony\Component\Console\Input\InputOption;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\text;

class AssignRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
<<<<<<< HEAD
     *
     * @var string
     */
    protected $name = 'user:assign-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign a module to user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
=======
     */
    protected string $name = 'user:assign-role';

    /**
     * The console command description.
     */
    protected string $description = 'Assign a module to user';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
>>>>>>> 64fb2fa (.)
        parent::__construct();
    }

    /**
     * Execute the console command.
<<<<<<< HEAD
=======
     * 
     * @return void
>>>>>>> 64fb2fa (.)
     */
    public function handle(): void
    {
        $email = text('email ?');
        $user_class = XotData::make()->getUserClass();
<<<<<<< HEAD
        /** @var UserContract */
        $user = XotData::make()->getUserByEmail($email);
        /**
         * @var array<string, string>
         */
=======
        
        /** @var UserContract $user */
        $user = XotData::make()->getUserByEmail($email);
        
        /** @var array<string, string> $opts */
>>>>>>> 64fb2fa (.)
        $opts = Role::all()
            ->pluck('name', 'name')
            ->toArray();

        $rows = multiselect(
            label: 'What roles',
            options: $opts,
            required: true,
            scroll: 10,
<<<<<<< HEAD
            // validate: function (array $values) {
            //  return ! \in_array(\count($values), [1, 2], false)
            //    ? 'A maximum of two'
            //  : null;
            // }
=======
>>>>>>> 64fb2fa (.)
        );

        foreach ($rows as $row) {
            $role = Role::firstOrCreate(['name' => $row]);
            $user->assignRole($role);
        }

        $this->info(implode(', ', $rows).' assigned to '.$email);
    }

    /**
     * Get the console command options.
<<<<<<< HEAD
=======
     * 
     * @return array<array<string, mixed>>
>>>>>>> 64fb2fa (.)
     */
    protected function getOptions(): array
    {
        return [
            ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }
}
