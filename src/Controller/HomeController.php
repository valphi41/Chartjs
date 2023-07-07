<?php

namespace App\Controller;

use App\Repository\FavoriteRepository;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        SerieRepository $serieRepository,
        ChartBuilderInterface $chartBuilder,
        FavoriteRepository $favoriteRepository
    ): Response {
        $series = $serieRepository->findAll();
        $topSeries = $favoriteRepository->createQueryBuilder('f')
            ->select('s.title', 'count(f.id) as favoriteCount')
            ->join('f.serie', 's')
            ->groupBy('s.id')
            ->orderBy('favoriteCount', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $labels = [];
        $data = [];

        foreach ($topSeries as $serie) {
            $labels[] = $serie['title'];
            $data[] = $serie['favoriteCount'];
        }
        $chart->setData([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'My First dataset',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => $data,
                ],
            ],
        ]);

        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => max($data),
                ],
            ],
        ]);


        return $this->render('home/index.html.twig', [
            'series' => $series,
            'chart' => $chart
        ]);
    }
}
