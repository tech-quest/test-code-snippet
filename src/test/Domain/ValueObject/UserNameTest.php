<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Domain\ValueObject\User\UserName;

final class UserNameTest extends TestCase
{
    /**
     * @test
     */
    public function construct_(): void
    {
        $actual = new UserName('1234567890');

        $this->assertSame('1234567890', $actual->value());
    }

    /**
     * @test
     */
    public function construct_21文字以上ならエラー(): void
    {
        $this->expectException(\Exception::class);

        new UserName('123451234512345123451');
    }
}
