<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite\Utils;

use Illuminate\Support\Str;
use Illuminate\Support\Stringable;
use Laravel\Socialite\Contracts\User;

<<<<<<< HEAD
=======
/**
 * Classe che risolve e normalizza i campi del nome utente da dati di provider Socialite.
 */
>>>>>>> 07cc6b5c (.)
final class UserNameFieldsResolver
{
    private const NAME_SEARCH = 'before';

    private const SURNAME_SEARCH = 'after';

    public readonly ?string $name;

    public readonly ?string $first_name;

    public readonly ?string $last_name;

    public function __construct(User $user)
    {
        $this->name = $this->resolveName($user);
        $this->first_name = $this->resolveName($user);
        $this->last_name = $this->resolveSurname($user);
    }

    public static function make(User $user): self
    {
        return new self($user);
    }

    private function resolveName(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, self::NAME_SEARCH);
    }

    private function resolveSurname(User $idpUser): string
    {
        return $this->resolveNameFields($idpUser, self::SURNAME_SEARCH);
    }

    /**
     * @param  string $searchMethod  use self constants (NAME_SEARCH, SURNAME_SEARCH)
     */
    private function resolveNameFields(User $idpUser, string $searchMethod): string
    {
<<<<<<< HEAD
        // Silly way: trying to split name field on first blank space
        // occurrence. If we're lucky, this will be enough.

        $nameSection = $this->resolveNameFieldByNameAttributeAnalysis(is_string($idpUser) ? $idpUser : (string) $idpUser->getName(), $searchMethod);

        if ($nameSection->isNotEmpty()) {
            return is_string($nameSection) ? $nameSection : (string) $nameSection;
        }

        // If the section was empty, try the "hard way"
        // by analyzing raw user data
        $nameField = method_exists($idpUser, 'getRaw')
            ? ($idpUser->getRaw()['name'] ?? '')
            : '';
        $nameSection = $this->resolveNameFieldByNameAttributeAnalysis(is_string($nameField) ? $nameField : (string) $nameField, $searchMethod);
        if (! $nameSection->isNotEmpty()) {
            // If both sections were empty, try the "hardest way"
            // by analyzing email address
            return Str::of(is_string($idpUser) ? $idpUser : (string) $idpUser->getEmail())
                ->trim()
                ->before('@')
                ->$searchMethod('.') // If no point is available, the whole string should be returned
                ->trim()
                ->title()
                ->toString();
        }
        if (filter_var(is_string($nameSection) ? $nameSection : (string) $nameSection, FILTER_VALIDATE_EMAIL)) {
            // If both sections were empty, try the "hardest way"
            // by analyzing email address
            return Str::of(is_string($idpUser) ? $idpUser : (string) $idpUser->getEmail())
=======
        if (!in_array($searchMethod, [self::NAME_SEARCH, self::SURNAME_SEARCH])) {
            throw new \InvalidArgumentException('Metodo di ricerca non valido');
        }

        $name = $idpUser->getName();
        if (!is_string($name) || empty($name)) {
            return '';
        }

        $nameSection = $this->resolveNameFieldByNameAttributeAnalysis($name, $searchMethod);

        if ($nameSection->isNotEmpty()) {
            return $nameSection->toString();
        }

        // Ottenere i dati raw in modo sicuro attraverso reflection
        $raw = [];
        try {
            $reflection = new \ReflectionClass($idpUser);
            if ($reflection->hasMethod('getRaw')) {
                $method = $reflection->getMethod('getRaw');
                $method->setAccessible(true);
                $rawValue = $method->invoke($idpUser);
                if (is_array($rawValue)) {
                    $raw = $rawValue;
                }
            } elseif ($reflection->hasProperty('user')) {
                $property = $reflection->getProperty('user');
                $property->setAccessible(true);
                $userData = $property->getValue($idpUser);
                if (is_array($userData)) {
                    $raw = $userData;
                }
            }
        } catch (\ReflectionException $e) {
            // Fallback silenzioso
        }

        // Tenta di ottenere un nome dai dati raw
        $nameField = '';
        if (isset($raw['name']) && is_string($raw['name']) && !empty($raw['name'])) {
            $nameField = $raw['name'];
        }

        if (empty($nameField)) {
            return '';
        }

        $nameSection = $this->resolveNameFieldByNameAttributeAnalysis($nameField, $searchMethod);
        if (!$nameSection->isNotEmpty()) {
            // If both sections were empty, try the "hardest way"
            // by analyzing email address
            $email = $idpUser->getEmail();
            if (!is_string($email) || empty($email)) {
                return '';
            }

            return Str::of($email)
>>>>>>> 07cc6b5c (.)
                ->trim()
                ->before('@')
                ->$searchMethod('.') // If no point is available, the whole string should be returned
                ->trim()
                ->title()
                ->toString();
        }

<<<<<<< HEAD
        return is_string($nameSection) ? $nameSection : (string) $nameSection;
=======
        if (filter_var($nameSection->toString(), FILTER_VALIDATE_EMAIL)) {
            // If both sections were empty, try the "hardest way"
            // by analyzing email address
            $email = $idpUser->getEmail();
            if (!is_string($email) || empty($email)) {
                return '';
            }

            return Str::of($email)
                ->trim()
                ->before('@')
                ->$searchMethod('.') // If no point is available, the whole string should be returned
                ->trim()
                ->title()
                ->toString();
        }

        return $nameSection->toString();
>>>>>>> 07cc6b5c (.)
    }

    private function resolveNameFieldByNameAttributeAnalysis(string $nameField, string $searchMethod): Stringable
    {
<<<<<<< HEAD
=======
        if (empty($nameField)) {
            return Str::of('');
        }

        if (!in_array($searchMethod, [self::NAME_SEARCH, self::SURNAME_SEARCH])) {
            throw new \InvalidArgumentException('Metodo di ricerca non valido');
        }

>>>>>>> 07cc6b5c (.)
        return Str::of($nameField)
            ->trim()
            ->$searchMethod(' ')
            ->trim();
    }
}
