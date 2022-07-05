<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\TestCase;
use App\Usecase\SignUp\Input;
use App\Usecase\SignUp\Interactor;
use App\Usecase\SignUp\Output;
use App\Domain\ValueObject\User\UserId;
use App\Domain\ValueObject\User\UserName;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\InputPassword;
use App\Domain\ValueObject\HashedPassword;
use App\Domain\ValueObject\User\NewUser;
use App\Domain\Entity\User;
use App\Domain\Interface\UserQueryInterface;
use App\Domain\Interface\UserCommandInterface;

final class SignUpTest extends TestCase
{
    /**
     * @test
     */
    public function run_()
    {
        $input = new Input(
            new UserName('techquest'),
            new Email('techquest@gmail.com'),
            new InputPassword('techquest1')
        );

        $userQuery = new class implements UserQueryInterface {
            public function findByEmail(Email $email): ?User
            {
                return null;
            }
        };

        $userCommand = new class implements UserCommandInterface {
            public function insert(NewUser $user): void
            {
            }
        };

        $interactor = new Interactor($input, $userQuery, $userCommand);
        $this->assertSame(true, $interactor->run()->isSuccess());
    }

    /**
     * @test
     */
    public function run_DB内に同じメールアドレスのユーザーがいたらfalse(): void
    {
        $input = new Input(
            new UserName('techquest'),
            new Email('techquest@gmail.com'),
            new InputPassword('techquest1')
        );

        $userQuery = new class implements UserQueryInterface {
            public function findByEmail(Email $email): ?User
            {
                return new User(
                    new UserId(1),
                    new UserName('techquest'),
                    new Email('techquest@gmail.com'),
                    new HashedPassword('techquest1')
                );
            }
        };

        $userCommand = new class implements UserCommandInterface {
            public function insert(NewUser $user): void
            {
            }
        };

        $interactor = new Interactor($input, $userQuery, $userCommand);
        $this->assertSame(false, $interactor->run()->isSuccess());
    }
}
