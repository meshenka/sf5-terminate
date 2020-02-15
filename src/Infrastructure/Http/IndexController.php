<?php

namespace App\Infrastructure\Http;

use App\Domain\Tick\Ticker;
use DateTimeInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(Ticker $ticker)
    {
        return $this->json([
            'time' => ($ticker->tick())->format(DateTimeInterface::ATOM),
        ]);
    }
}
