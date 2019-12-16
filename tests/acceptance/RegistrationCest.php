<?php

namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;
use Codeception\Example;
use Codeception\Scenario;
use Faker\Factory;

class RegistrationCest
{
    public function testRegistrationForm(AcceptanceTester $I): void
    {
        $I->wantTo('See if registration form is on place');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $I->see('Register');
        $I->seeElement('input#registration_form_email');
        $I->seeElement('input#registration_form_plainPassword');
        $I->seeElement('button');
    }

    /**
     * @dataProvider invalidEmailDataProvider
     */
    public function testRegistrationWithInvalidEmail(AcceptanceTester $I, Scenario $scenario, Example $example): void
    {
        $I->wantTo('See if registration form validates email');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $data = $example->getIterator()->getArrayCopy();

        $I->submitForm('form', [
            'registration_form' => [
                'email' => $data[0],
                'plainPassword' => 'foobarbaz',
            ],
        ]);

        $I->seeResponseCodeIs(200);
        $I->see('Please enter a valid email');
    }

    public function invalidEmailDataProvider(): array
    {
        return [
            [''],
            ['INVALID_EMAIL'],
            ['foo@bar'],
        ];
    }

    public function testSuccessfulRegistration(AcceptanceTester $I): void
    {
        $I->wantTo('See if I see feed after registration');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $faker = Factory::create();

        $I->submitForm('form', [
            'registration_form' => [
                'email' => $faker->email,
                'plainPassword' => 'foobarbaz',
            ],
        ]);

        $I->amOnPage('/feed');
        $I->seeResponseCodeIs(200);
        $I->see('Welcome to Feed');
    }

    public function testAlreadyRegisteredEmailCannotRegister(AcceptanceTester $I): void
    {
        $I->wantTo('See if I cannot register with the same email again');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $faker = Factory::create();

        $email = $faker->email;

        $I->submitForm('form', [
            'registration_form' => [
                'email' => $email,
                'plainPassword' => 'foobarbaz',
            ],
        ]);

        $I->seeResponseCodeIs(200);

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $I->submitForm('form', [
            'registration_form' => [
                'email' => $email,
                'plainPassword' => 'foobarbaz',
            ],
        ]);

        $I->see('There is already an account with this email');
    }
}
