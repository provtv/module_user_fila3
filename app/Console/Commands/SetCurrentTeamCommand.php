<?php

declare(strict_types=1);

namespace Modules\User\Console\Commands;

use Illuminate\Console\Command;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;
use Symfony\Component\Console\Input\InputOption;

use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

<<<<<<< HEAD
=======
/**
 * Comando per impostare il team corrente per un utente.
 */
>>>>>>> 07cc6b5c (.)
class SetCurrentTeamCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'user:set-current-team';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assign current team to user';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $email = text('email ?');
<<<<<<< HEAD
=======
        if (empty($email)) {
            $this->error('Email non valida!');
            return;
        }
>>>>>>> 07cc6b5c (.)

        $xot = XotData::make();
        $user = $xot->getUserByEmail($email);

<<<<<<< HEAD
        if (!$user instanceof UserContract) {
            $this->error('User not found!');
=======
        if (! $user instanceof \Illuminate\Database\Eloquent\Model) {
            $this->error('Utente non trovato o non valido!');
>>>>>>> 07cc6b5c (.)
            return;
        }

        $teamClass = $xot->getTeamClass();
        if (!class_exists($teamClass)) {
<<<<<<< HEAD
            $this->error('Team class not found!');
=======
            $this->error('Classe team non trovata!');
>>>>>>> 07cc6b5c (.)
            return;
        }

        /** @var array<int|string, string> */
        $opts = $teamClass::pluck('name', 'id')->toArray();

<<<<<<< HEAD
        $team_id = select(
            label: 'What team?',
=======
        if (empty($opts)) {
            $this->error('Nessun team disponibile!');
            return;
        }

        $team_id = select(
            label: 'Quale team?',
>>>>>>> 07cc6b5c (.)
            options: $opts,
            required: true,
            scroll: 10,
        );

<<<<<<< HEAD
        $user->current_team_id = (int) $team_id;
        $user->save();

        $this->info('OK');
=======
        if (!is_numeric($team_id)) {
            $this->error('ID team non valido!');
            return;
        }

        try {
            $user->current_team_id = (int) $team_id;
            $user->save();
            $this->info('OK');
        } catch (\Exception $e) {
            $this->error('Errore durante il salvataggio: ' . $e->getMessage());
        }
>>>>>>> 07cc6b5c (.)
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
