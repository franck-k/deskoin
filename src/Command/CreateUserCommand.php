<?php
namespace App\Command;

use App\Entity\CryptoCurrency;
use App\Repository\CryptoCurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    private $em;
    private $currencyRepo;

    public function __construct(EntityManagerInterface $em,  CryptoCurrencyRepository $currencyRepo)
    {
        parent::__construct();
        $this->em = $em;
        $this->currencyRepo = $currencyRepo;
    }


    protected function configure()
    {

    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $currencyReq = $this->currencyRepo->findAll();
        foreach($currencyReq as $currency){
            $currencyName = $currency->getCryptoName();
            usleep(125000);
            $marketPriceApiCall = file_get_contents('https://api.coingecko.com/api/v3/simple/price?ids='.$currencyName.'&vs_currencies=eur&include_market_cap=true&include_24hr_vol=true&include_24hr_change=true&include_last_updated_at=true');
            usleep(125000);
            $marketChartApiCall = file_get_contents('https://api.coingecko.com/api/v3/coins/'.$currencyName.'/market_chart?vs_currency=eur&days=1');
            $currency->setMarketData($marketChartApiCall);
            $currency->setMarketPrice( $marketPriceApiCall);
            $currency->setCreatedAt(new \DateTime());
            $this->em->persist($currency);
        }
        $this->em->flush();



        // outputs multiple lines to the console (adding "\n" at the end of each line)
        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        // the value returned by someMethod() can be an iterator (https://secure.php.net/iterator)
        // that generates and returns the messages with the 'yield' PHP keyword
        $output->writeln($this->configure());

        // outputs a message followed by a "\n"
        $output->writeln('Whoa!');

        // outputs a message without adding a "\n" at the end of the line
        $output->write('You are about to ');
        $output->write('create a user.');

        return Command::SUCCESS;
    }
}
?>