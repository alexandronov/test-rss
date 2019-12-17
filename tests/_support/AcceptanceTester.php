<?php

namespace App\Tests;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

    /**
     * Define custom actions here
     */

    public function loginWithEmailAndPassword(string $email, string $password): void
    {
        $I = $this;

        $I->amOnPage('/login');
        $I->seeResponseCodeIs(200);

        $I->submitForm('#login_form', [
            'email' => $email,
            'password' => $password,
        ]);
    }

    public function registerWithEmailAndPassword(string $email, string $password): void
    {
        $I = $this;

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $I->submitForm('form', [
            'registration_form' => [
                'email' => $email,
                'plainPassword' => $password,
            ],
        ]);
    }
}
