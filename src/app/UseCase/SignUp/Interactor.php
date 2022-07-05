<?php
namespace App\UseCase\SignUp;
require_once __DIR__ . '/../../../vendor/autoload.php';
use App\Adapter\Query\UserQuery;
use App\Adapter\Command\UserCommand;
use App\Domain\Interface\UserQueryInterface;
use App\Domain\Interface\UserCommandInterface;
use App\UseCase\SignUp\Input;
use App\UseCase\SignUp\Output;
use App\Domain\ValueObject\User\NewUser;
use App\Domain\Entity\User;

/**
 * ユーザー登録ユースケース
 */
final class Interactor
{
    /**
     * @var UserCommandInterface
     */
    private $userCommand;

    /**
     * @var UserQueryInterface
     */
    private $userQuery;

    /**
     * @var SignUpInput
     */
    private $input;

    /**
     * コンストラクタ
     *
     * @param SignUpInput $input
     */
    public function __construct(
        Input $input,
        UserQueryInterface $userQuery,
        UserCommandInterface $userCommand
    ) {
        $this->userCommand = $userCommand;
        $this->UserQuery = $userQuery;
        $this->input = $input;
    }

    /**
     * ユーザー登録処理
     * すでに存在するメールアドレスの場合はエラーとする
     *
     * @return Output
     */
    public function run(): Output
    {
        $user = $this->findUser();

        if ($this->existsUser($user)) {
            return new Output(false);
        }

        $this->signup();
        return new Output(true);
    }

    /**
     * ユーザーを入力されたメールアドレスで検索する
     *
     * @return array
     */
    private function findUser(): ?User
    {
        return $this->UserQuery->findByEmail($this->input->email());
    }

    /**
     * ユーザーが存在するかどうか
     *
     * @param array|null $user
     * @return boolean
     */
    private function existsUser(?User $user): bool
    {
        return !is_null($user);
    }

    /**
     * ユーザーを登録する
     *
     * @return void
     */
    private function signup(): void
    {
        $this->userCommand->insert(
            new NewUser(
                $this->input->name(),
                $this->input->email(),
                $this->input->password()
            )
        );
    }
}
