<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;

class ApiController extends AbstractController
{
    public function read(Request $request)
    {
        $apiToken = $request->headers->get('X-AUTH-TOKEN');

        if ($apiToken !== $_ENV['API_TOKEN'])
        {
            throw new UserNotFoundException('API Key is not correct');
        }

        $response = [];

        $lines = array_filter(preg_split('/\n|\r\n?/', $request->getContent()));
        $headers = array_shift($lines);

        $array = [];
        foreach ($lines as $line) {
            $array[] = array_combine(explode(',', $headers), explode(',', $line));
        }
//        $newHeader = array_shift($array);
//        $response[$newHeader['Team']][] = [
//            'team' => $newHeader['Team'],
//            'parentTeam' => $newHeader['parent_team'],
//            'managerName' => $newHeader['manager_name'],
//            'businessUnit' => $newHeader['business_unit'],
//        ];
        for ($i = 0; $i<count($array); $i++){
            for($j = 0; $j<count($array); $j++){
                if($array[$i]['Team'] === $array[$j]['parent_team']){
                    $response[$array[$i]['Team']][] = $array[$j];
//                    dump($array);
                }
            }
        }
        dump($response);
        die;
        foreach ($array as $arr){
//            dump($arr);
            $team = $arr['Team'];
//            dump($team);
//            if($arr['parent_team'] === $newHeader['Team'])
//                $response[$newHeader['Team']]['teams'][] = $arr;
            foreach ($arr as $a){
                if($a === $team){
                    dump($a);
                }
            }
            die;
//            dump($response);

//            $key = array_search('C Suit', $arr);
//            if($key){
//                $response['C Suit'] = array(
//                    'teamName' =>
//                    $arr);
//                dump($key);
//            }
//            dump($key);

//            foreach ($arr as $a){
//                dump($arr);

//            }
        }
        die;
        dd($response);
    }
}