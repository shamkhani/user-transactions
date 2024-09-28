<?php

namespace App\Commands;

use App\Service\Transaction\TransactionService;
use App\Service\Transaction\TransactionServiceInterface;
use App\Service\User\UserServiceInterface;
use DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;

class RoomVuCommand extends Command
{
    private UserServiceInterface $userService;
    private TransactionServiceInterface $transactionService;
    protected static $defaultName = 'RoomVu';


    public function __construct(UserServiceInterface $userService, TransactionService $transactionService)
    {
        $this->userService = $userService;
        $this->transactionService = $transactionService;
        parent::__construct(self::$defaultName);
    }
    protected function configure()
    {
        $this
            ->setName('RoomVu')
            ->setDescription('Some Action For User Transactions')
            ->setHelp('This command use for RoomVu Challange Code');
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $menu = [
            "Populate User List",
            "Add a Transaction",
            "Report - Total user transaction amount",
            "Report - Total all user transaction amount",
            "Exit",
        ];

        while (true) {
            $helper = $this->getHelper('question');

            $question = new ChoiceQuestion(
                '<info>Please select a number? (default = Exit) </info>',
                // choices can also be PHP objects that implement __toString() method
                $menu,
                4
            );
            $anwser = $helper->ask($input, $output, $question);
            switch ($anwser) {
                case "Populate User List":
                    $this->populateUser($output);
                    break;
                case "Add a Transaction":
                    $this->addTransaction($helper, $input, $output);
                    break;
                case "Report - Total user transaction amount":
                    $this->reportTotalPerUser($helper, $input, $output);
                    break;
                case "Report - Total all user transaction amount":
                    $this->reportTotalSum($output);
                    break;
                case "Exit":
                    return Command::SUCCESS;
            }
        }
    }
    private function populateUser($output)
    {
        $users = ($this->userService->getAllUsers());
        $users = array_slice($users, 0, 10);
        foreach ($users as $user) {
            $output->write("<comment>User Id:" . $user->getid() . "</comment>");
            $output->writeln(", Amount:" . $user->getCredit());
        }
    }
    private function addTransaction($helper, $input, $output)
    {
        $userId = $helper->ask($input, $output, new Question('<question>User Id?</question>', false));
        $trackerId = uniqid();
        $amount = $helper->ask($input, $output, new Question('<question>Amount?</question>', false));
        $tid = $this->transactionService->addTransaction($userId, $amount, $trackerId, new DateTime());
        if ($tid) {
            $output->writeln('<info>Transction Has been added</info>');
            $output->writeln("<comment>Tracker Id: $trackerId</comment>");
            $output->writeln("<info>Transaction Id: $$tid</info>");
        } else {
            $output->writeln('<error>Error, please try again</error>');
        }
    }

    private function reportTotalPerUser($helper, $input, $output)
    {
        $userId = $helper->ask($input, $output, new Question('<question>User Id?</question>', false));
        $transactions = $this->transactionService->getUserTotalTransaction($userId);
        $output->writeln("<comment>Total Transaction For User: $userId</comment>");
        foreach ($transactions as $transaction) {
            $output->write("<comment>Date:" . $transaction->getDate() . "</comment>");
            $output->writeln("<info>,Total Amount:" . $transaction->getTotalAmount() . "</info>");
        }
    }

    private function reportTotalSum($output)
    {
        $transactions = $this->transactionService->getAllUserTotalTransaction();
        foreach ($transactions as $transaction) {
            $output->write("<comment>Date:" . $transaction->getDate() . "</comment>");
            $output->writeln("<info>,Total Amount:" . $transaction->getTotalAmount() . "</info>");
        }
    }
}
