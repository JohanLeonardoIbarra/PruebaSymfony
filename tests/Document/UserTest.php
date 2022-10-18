<?php

namespace App\Tests\Document;

use App\Document\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        $this->user = new User();
    }

    /**
     * @dataProvider userNameProvider
    */
    public function testNameGetterSetter($name)
    {
        $this->user->setName($name);
        self::assertSame($name, $this->user->getName());
    }

    public function userNameProvider(): array
    {
        return [
            ['Johan'],
            ['Juan'],
            ['Jose']
        ];
    }

    public function testSurnameGetterSetter()
    {
        $this->user->setSurname('Ibarra');
        self::assertSame('Ibarra', $this->user->getSurname());
    }

    public function testEmailGetterSetter()
    {
        $this->user->setEmail('johan@email.com');
        self::assertSame('johan@email.com', $this->user->getEmail());
    }

    public function testTokenGetterSetter()
    {
        $this->user->setEmail('johan@email.com');
        $this->user->setToken();
        $expectedToken = md5('johan@email.com');
        self::assertSame($expectedToken, $this->user->getToken());
    }

    public function testUserPasswordGetterSetter()
    {
        $this->user->setPassword('johan');
        self::assertSame('johan', $this->user->getPassword());
    }
}
