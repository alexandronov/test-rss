<?php

namespace App\Tests\Acceptance;

use App\Tests\AcceptanceTester;
use Codeception\Example;
use Codeception\Scenario;
use Faker\Factory as FakerFactory;

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

        $I->registerWithEmailAndPassword($data[0], 'random_password');

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

    public function testSuccessfulRegistration(AcceptanceTester $I, Scenario $scenario): void
    {
        $scenario->skip('Skipping because authorization right after registration is not implemented yet');

        $I->wantTo('See if I see feed after registration');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $faker = FakerFactory::create();

        $I->registerWithEmailAndPassword($faker->email, $faker->password);

        $I->amOnPage('/feed');
        $I->seeResponseCodeIs(200);
        $I->see('Welcome to Feed');
    }

    public function testLoginAfterRegistration(AcceptanceTester $I): void
    {
        $I->wantTo('Login after registration');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $faker = FakerFactory::create();

        $email = $faker->email;
        $password = $faker->password;

        $I->registerWithEmailAndPassword($email, $password);
        $I->loginWithEmailAndPassword($email, $password);

        $I->amOnPage('/feed');
        $I->seeResponseCodeIs(200);
        $I->see('Welcome to Feed');
    }

    public function testAlreadyRegisteredEmailCannotRegister(AcceptanceTester $I): void
    {
        $I->wantTo('See if I cannot register with the same email again');

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $faker = FakerFactory::create();

        $email = $faker->email;

        $I->registerWithEmailAndPassword($email, $faker->password);

        $I->seeResponseCodeIs(200);

        $I->amOnPage('/register');
        $I->seeResponseCodeIs(200);

        $I->registerWithEmailAndPassword($email, $faker->password);

        $I->see('There is already an account with this email');
    }
}
