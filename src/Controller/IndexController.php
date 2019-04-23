<?php

namespace App\Controller;


use App\Entity\Statistics;
use App\Entity\Weather;
use App\Helpers\Unit;
use App\Library\HistoryDataGenerator;
use App\Library\OpenWeatherApi;
use App\Library\StatisticsCalculator;
use App\Library\WeatherResponse;
use App\Repository\WeatherRepository;
use Doctrine\ORM\AbstractQuery;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('index/index.html.twig', []);
    }

    /**
     * @param Weather $weather
     *
     * @return Weather
     */
    private function saveWeather(Weather $weather): Weather
    {
        $this->getDoctrine()->getManager()->persist($weather);
        $this->getDoctrine()->getManager()->flush();

        return $weather;
    }

    /**
     * @Route("/weather", name="weather")
     */
    public function weather(Request $request)
    {
        try {
            $weather = (new OpenWeatherApi(
                floatval($request->get('lat')),
                floatval($request->get('lng')))
            )->getWeather();
            return $this->json(new WeatherResponse($this->saveWeather($weather), (int) $request->get('unit')));
        } catch (\Exception $e) {
            //Bład pobierania danych
            return $this->json(new WeatherResponse(null, WeatherResponse::ERR_CODE, WeatherResponse::DEFAULT_ERR_MSG));
        }
    }

    /**
     * @Route("/history/{unit}", name="history")
     */
    public function history(int $unit = Unit::METRIC)
    {
        $allWeathers = $this->getDoctrine()->getRepository(Weather::class)->findAll();
        return $this->render('index/history.html.twig', [
            'weathers_length' => ceil(count($allWeathers) / WeatherRepository::DEFAULT_PER_PAGE),
            'statistics' => $this->getStatisticsForView($allWeathers, $unit),
            'unit' => $unit
        ]);
    }

    /**
     * @Route("/history-page/{page}/{unit}", name="history-page")
     */
    public function historyPage(int $page, int $unit)
    {
        $weathers = $this->getDoctrine()->getRepository(Weather::class)->getWithLimit($page);
        return $this->json([
            'weathers' => (new HistoryDataGenerator($weathers, $unit))->getRows(),
            'page' => $page
        ]);
    }

    /**
     * @param array $weathers
     *
     * @return string
     */
    private function getStatisticsForView(array $weathers, int $unit): string
    {
        $statistics = (new StatisticsCalculator($weathers, $unit))->get()->toArray();

        return json_encode([
            'max_temp' => $statistics[Statistics::MAX_TEMPERATURE],
            'min_temp' => $statistics[Statistics::MIN_TEMPERATURE],
            'average_temp' => $statistics[Statistics::AVERAGE_TEMPERATURE],
            'common_places' => $statistics[Statistics::COMMON_PLACES]
        ]);
    }
}
